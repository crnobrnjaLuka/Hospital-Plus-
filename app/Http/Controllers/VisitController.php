<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TreatmentModel;
use App\Http\Resources\ChartResource;
use App\Http\Resources\HelpFuncResource;

class VisitController extends Controller
{
    //
    public function createVisit($id_pacijent)
    {
        if(HelpFuncResource::checkIfHeIsMyDoctor($id_pacijent))
        {
            $id_lekar=auth()->user()->id;
            return view('lekar.createVisit',['id_pacijent'=>$id_pacijent,'id_lekar'=>$id_lekar]);
        }
        else
        {
            return back()->withErrors(['Nije vas pacijent!']);
        }
        
    }

    public function storeVisit(Request $request)
    {
        
        $pom=new TreatmentModel;

            if($request->datum=="" or $request->datum==null) return json_encode("Nepravilan datum: ".$request->datum);
            $pom->datum=$request->datum;
            if($request->id_pacijent=="" or $request->id_pacijent==null) return json_encode("Nepravilan id pacijent: ".$request->id_pacijent);
            $pom->id_pacijent=$request->id_pacijent;
            if($request->id_lekar=="" or $request->id_lekar==null) return json_encode("Nepravilan id lekar: ".$request->id_lekar);
            $pom->id_lekar=$request->id_lekar;
            if($request->dijagnoza=="" or $request->dijagnoza==null) return json_encode("Nepravilano uneta dijagnoza: ".$request->dijagnoza);
            $pom->dijagnoza=$request->dijagnoza;

            $pom->terapija=$request->terapija ?? "Terapija nije uneta.";
            
            if($request->prva_poseta=="" or $request->prva_poseta==null) return json_encode("Nepravilano uneta dijagnoza: ".$request->prva_poseta);
            $pom->prva_poseta=$request->prva_poseta;

            if($request->sifra_bolesti==null and $request->sifra_leka==null and $request->lek_prepisana_kol==null)
            {
                $pom->id_bolest=HelpFuncResource::getIdBolesti('nema');
                if($pom->id_bolest=="") return json_encode("Dodajte bolest sa sifrom:nema, imenom:nema");
                $pom->id_lek=HelpFuncResource::getIdLeka('nema');
                if($pom->id_lek=="") return json_encode("Dodajte lek sa sifrom:nema, imenom:nema, kolicinom:0");
                $pom->lek_prepisana_kol=0;
            }
            else
            {
                $pom->id_bolest=HelpFuncResource::getIdBolesti($request->sifra_bolesti);
                if($pom->id_bolest=="") return json_encode("Nepravilna sifra bolesti: ".$request->sifra_bolesti);
                $id_cure=HelpFuncResource::getIdLeka($request->sifra_leka);
                if($id_cure=="") return json_encode("Nepravilna sifra leka: ".$request->sifra_leka);
                $pom->id_lek=$id_cure;
                if($request->lek_prepisana_kol<=0) return json_encode("Nepravilna kolicina leka: ".$request->lek_prepisana_kol);
                $pom->lek_prepisana_kol=$request->lek_prepisana_kol;
                HelpFuncResource::changeCure($id_cure,-$request->lek_prepisana_kol);  
            }

            if(HelpFuncResource::checkIfHeIsMyDoctor($request->id_pacijent))
            {
                $pom->save();
                return json_encode("Snimljeno");         
            }  
            else
            {
                return json_encode("Nije vas pacijent");  
            }           
    }

    

    public function editVisit($list)
    {
        $array=explode(',',$list);
        $data=TreatmentModel::find($array[0]);
        $data->tracers=$list;
        if(HelpFuncResource::checkIfHeIsMyDoctor($data->id_pacijent))
        {
          return view('lekar.editVisit',['data'=>$data]);  
        }
        else
        {
            return back()->withErrors(['Nije vas pacijent!']);;
        }
    }

    public function updateVisit(Request $request)
    {
        $json=$request->json ?? false;
        $array=explode(',',$request->tracers);
        foreach($array as $id)
        {
            $pom=TreatmentModel::find($id);
            $pom->dijagnoza=$request->dijagnoza;
            $pom->terapija=$request->terapija;
            $pom->prva_poseta=$request->prva_poseta;

            if(HelpFuncResource::checkIfHeIsMyDoctor($pom->id_pacijent))
            {
                $pom->save();
            }
            else
            {
                return back()->withErrors(['Nije vas pacijent!']);
            }
        }

        if($json)
        {
            return json_encode("Azurirano!");
        } 
        return redirect('/lekar/chart/'.$pom->id_pacijent)->withErrors(['Sačuvano!']); 
    }

    public function destroyVisit($list)
    {
        $array=explode(',',$list);
        $id_pacijent=TreatmentModel::find($array[0])->id_pacijent;
        foreach($array as $id)
        {
            if(HelpFuncResource::checkIfHeIsMyDoctor(TreatmentModel::find($id)->id_pacijent))
            {
                $visit=TreatmentModel::find($id);
                HelpFuncResource::changeCure($visit->id_lek,$visit->lek_prepisana_kol);
                //dozovoljava samo brisanje datuma poseta koje su danas ili u buducnosti
                if(strtotime($visit->datum)>=strtotime(date('Y-m-d')))
                {
                    TreatmentModel::destroy($id);
                }
                else
                {
                    return back()->withErrors(['Ne mozete brisati posetu koja se dogodila u proslosti!']);
                }
            }
            else
            {
                return back()->withErrors(['Nije vas pacijent!']);
            }
        }

        return redirect('/lekar/chart/'.$id_pacijent)->withErrors(['Destroyed!']);
    }

    //pravi i vraca json za jednu posetu
    public function showSingleVisitJSON($list)
    {
        return json_encode(ChartResource::getVisitData($list));
    }

    //vraca json sa spiskom oboljenja i spiskom medikamenata
    public function getCodes()
    {
        return json_encode(['bolesti'=>HelpFuncResource::getListOfDiseaseCodes(),'lekovi'=>HelpFuncResource::getListOfCuresCodes()]);
    }
}

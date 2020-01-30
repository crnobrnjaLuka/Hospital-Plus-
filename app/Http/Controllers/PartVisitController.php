<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TreatmentModel;
use App\Http\Resources\HelpFuncResource;
use App\Http\Resources\ChartManagmentResource;


class PartVisitController extends Controller
{
    //
    public function createTreatmant($list)
    {
        $array=explode(',',$list);
        $data=TreatmentModel::find($array[0]);
        if(HelpFuncResource::checkIfHeIsMyDoctor($data->id_pacijent))
        {
          return view('lekar.createTreatmant',['data'=>$data]);  
        }
        else
        {
            return back()->withErrors(['Nije vas pacijent!']);
        }
    }

    public function storeTreatmant(Request $request)
    {
        $request->validate([
            'datum'=>'required',
            'id_pacijent'=>'required',
            'id_lekar'=>'required',
            'dijagnoza'=>'required',
            'terapija'=>'required',
            'prva_poseta'=>'required',
            'sifra_bolesti'=>'required',
            'sifra_leka'=>'required',
            'lek_prepisana_kol'=>'required',
        ]);

        $pom=new TreatmentModel;

        $pom->datum=$request->datum;
        $pom->id_pacijent=$request->id_pacijent;
        $pom->id_lekar=$request->id_lekar;
        $pom->dijagnoza=$request->dijagnoza;
        $pom->terapija=$request->terapija;
        $pom->prva_poseta=$request->prva_poseta;
        $pom->id_bolest=HelpFuncResource::getIdBolesti($request->sifra_bolesti);
        if($pom->id_bolest=="") return redirect('/lekar/chart/'.$request->id_pacijent)->withErrors(['Bolest ne postoji u bazi!']);
        $id_cure=HelpFuncResource::getIdLeka($request->sifra_leka);
        if($id_cure=="") return redirect('/lekar/chart/'.$request->id_pacijent)->withErrors(['Lek ne postoji u bazi!']);
        $pom->id_lek=$id_cure;
        if($request->lek_prepisana_kol<=0) return redirect('/lekar/chart/'.$request->id_pacijent)->withErrors(['Kolicina leka je manja ili jednaka nuli!']);
        $pom->lek_prepisana_kol=$request->lek_prepisana_kol;
        HelpFuncResource::changeCure($id_cure,-$request->lek_prepisana_kol);

        if(HelpFuncResource::checkIfHeIsMyDoctor($request->id_pacijent))
        {
            $pom->saveOrFail();
                    
        }  
        else
        {
            return back()->withInput()->withErrors(['Nije vas pacijent']);
        }
        
        return redirect('/lekar/chart/'.$request->id_pacijent)->withErrors(['Sačuvano!']);  
        // ChartManagmentResource::saveTreatmant($pom,$request);
                    
    }

    public function editTreatmant($id)
    {
        $data=TreatmentModel::find($id);
        $data->sifra_leka=HelpFuncResource::getCodeLeka($data->id_lek);
        $data->sifra_bolesti=HelpFuncResource::getCodeBolesti($data->id_bolest);
        if(HelpFuncResource::checkIfHeIsMyDoctor($data->id_pacijent))
        {
          return view('lekar.editTreatmant',['data'=>$data]);  
        }
        else
        {
            return back()->withErrors(['Nije vas pacijent!']);
        }
    }

    public function updateTreatmant(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'sifra_bolesti'=>'required',
            'sifra_leka'=>'required',
            'lek_prepisana_kol'=>'required',
        ]);

        $pom=TreatmentModel::find($request->id);

        $pom->id_bolest=HelpFuncResource::getIdBolesti($request->sifra_bolesti);
        $id_cure=HelpFuncResource::getIdLeka($request->sifra_leka);
        $pom->id_lek=$id_cure;
        if($request->lek_prepisana_kol<=0) return redirect('/lekar/chart/'.$request->id_pacijent)->withErrors(['Kolicina leka <=0!']);;
        $pom->lek_prepisana_kol=$request->lek_prepisana_kol;
        //menja stanje lekova u skladistu
        HelpFuncResource::changeCure($id_cure,$request->lek_prepisana_kol_staro-$request->lek_prepisana_kol);

        if(HelpFuncResource::checkIfHeIsMyDoctor($pom->id_pacijent))
        {
            $pom->save();

            return redirect('/lekar/chart/'.$pom->id_pacijent)->withErrors(['Sačuvano!']);
        }
        else
        {
            return redirect('/lekar/chart/'.$pom->id_pacijent)->withErrors(['Nije vas pacijent!']);
        }
    }

    public function updateTreatmantReact(Request $request)
    {
        
        $pom = TreatmentModel::find($request->id);
        
        $pom->id_bolest=HelpFuncResource::getIdBolesti($request->sifra_bolesti);
        if($pom->id_bolest=="") return json_encode("Nepravilna sifra bolesti: ".$request->sifra_bolesti);
        $id_cure=HelpFuncResource::getIdLeka($request->sifra_leka);
        if($id_cure=="") return json_encode("Nepravilna sifra leka: ".$request->sifra_leka);
        $pom->id_lek=$id_cure;
        if($request->lek_prepisana_kol<=0) json_encode("Nepravilna kolicina leka: ".$request->lek_prepisana_kol);
        $pom->lek_prepisana_kol=$request->lek_prepisana_kol;
        //menja stanje lekova u skladistu
        HelpFuncResource::changeCure($id_cure,$request->lek_prepisana_kol_staro-$request->lek_prepisana_kol);
        
        if(HelpFuncResource::checkIfHeIsMyDoctor($pom->id_pacijent))
        {
            
            $pom->save();
            
            return json_encode("Snimljeno");
        }
        else
        {
            return json_encode("Nije Vas Pacijent");
        }
    }
}

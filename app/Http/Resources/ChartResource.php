<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\PatientModel;
use App\TreatmentModel;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\HelpFuncResource;

class ChartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }

    //vraca podatke za karton vezane za pacijenta
    public static function mainChartData($id)
    {
        $result=PatientModel::select('id','ime','prezime','dat_rodjenja','pol','istorija_bolesti','alergija_lek','lekar')->where('id',$id)->get();
        return $result[0];
    }

    //lista svih poseta, skuplja iz tebele lecenje i grupise kada su datim, dijagnoza i terapije iste
    public static function getTreatmantData($id)
    {
        $lecenjeRaw=DB::table('lecenje')
        ->select(
            'lecenje.id',
            'lecenje.id_pacijent',
            'lecenje.id_lekar',
            'lecenje.datum',
            'lecenje.prva_poseta',
            'lecenje.dijagnoza',
            'lecenje.id_bolest',
            'lecenje.terapija',
            'lecenje.id_lek',
            'lecenje.lek_prepisana_kol',
            'bolest.sifra_bolest',
            'lek.sifra_lek',
            'bolest.ime_bolest',
            'lek.ime_lek',
            'users.name'
        )
        ->join('bolest','lecenje.id_bolest','=','bolest.id')
        ->join('lek','lecenje.id_lek','=','lek.id')
        ->join('users', 'users.id','=','lecenje.id_lekar')
        ->where('lecenje.id_pacijent',$id)
        ->orderBy('lecenje.datum','desc')
        ->get();

        $counter=count($lecenjeRaw);
        $lecenja=[];
        $br=0;
        
        if($counter>0)
        {
            $poseta=[];
            $id_tracker=[];
            $lekovi=[['sifra_bolest'=>$lecenjeRaw[0]->sifra_bolest,'sifra_lek'=>$lecenjeRaw[0]->sifra_lek,
            'name_bolest'=>$lecenjeRaw[0]->ime_bolest,'name_lek'=>$lecenjeRaw[0]->ime_lek,
            'lek_prepisana_kol'=>$lecenjeRaw[0]->lek_prepisana_kol,
            'ind_tracer'=>$lecenjeRaw[0]->id]];
            array_push($id_tracker,$lecenjeRaw[0]->id);
            $poseta=['datum'=>$lecenjeRaw[0]->datum,'prva_poseta'=>$lecenjeRaw[0]->prva_poseta,
            'dijagnoza'=>$lecenjeRaw[0]->dijagnoza,'terapija'=>$lecenjeRaw[0]->terapija,
            'id_lekar'=>$lecenjeRaw[0]->name,'lekovi'=>$lekovi,'id_tracker'=>$id_tracker];
            array_push($lecenja,$poseta);
        }
        


        for($i=1; $i<$counter; $i++)
        {
            for($j=0; $j<count($lecenja); $j++)
            {
                $check=false;
                if($lecenjeRaw[$i]->datum===$lecenja[$j]['datum'] and $lecenjeRaw[$i]->dijagnoza===$lecenja[$j]['dijagnoza']
                 and $lecenjeRaw[$i]->terapija===$lecenja[$j]['terapija'] )
                {
                    $check=true;
                }
            }

            if($check)
            {
                $lekovi=['sifra_bolest'=>$lecenjeRaw[$i]->sifra_bolest,'sifra_lek'=>$lecenjeRaw[$i]->sifra_lek,'lek_prepisana_kol'=>$lecenjeRaw[$i]->lek_prepisana_kol,
                'ind_tracer'=>$lecenjeRaw[$i]->id,'name_bolest'=>$lecenjeRaw[$i]->ime_bolest,'name_lek'=>$lecenjeRaw[$i]->ime_lek];
                $id_tracker=$lecenjeRaw[$i]->id;
                array_push($lecenja[$br]['lekovi'],$lekovi);
                array_push($lecenja[$br]['id_tracker'],$id_tracker);
            }
            else
            {
                $br++;
                $poseta=[];
                $id_tracker=[];
                $lekovi=[['sifra_bolest'=>$lecenjeRaw[$i]->sifra_bolest,'sifra_lek'=>$lecenjeRaw[$i]->sifra_lek,'lek_prepisana_kol'=>$lecenjeRaw[$i]->lek_prepisana_kol,
                'name_bolest'=>$lecenjeRaw[$i]->ime_bolest,'name_lek'=>$lecenjeRaw[$i]->ime_lek,
                'ind_tracer'=>$lecenjeRaw[$i]->id]];
                array_push($id_tracker,$lecenjeRaw[$i]->id);
                $poseta=['datum'=>$lecenjeRaw[$i]->datum,'prva_poseta'=>$lecenjeRaw[$i]->prva_poseta,
                'dijagnoza'=>$lecenjeRaw[$i]->dijagnoza,'terapija'=>$lecenjeRaw[$i]->terapija,
                'id_lekar'=>$lecenjeRaw[$i]->name,'lekovi'=>$lekovi,'id_tracker'=>$id_tracker];
                array_push($lecenja,$poseta);
            }
        }
        
        return $lecenja;
    }

    //copy
    ////lista svih poseta, skuplja iz tebele lecenje i grupise kada su datim i dijagnoza iste
    //zahteva da podaci iz baze budu grupisane po datumu i dijagnozi
    public static function getTreatmantDataOld($id)
    {
        $lecenjeRaw=DB::table('lecenje')
        ->select(
            'lecenje.id',
            'lecenje.id_pacijent',
            'lecenje.id_lekar',
            'lecenje.datum',
            'lecenje.prva_poseta',
            'lecenje.dijagnoza',
            'lecenje.id_bolest',
            'lecenje.terapija',
            'lecenje.id_lek',
            'lecenje.lek_prepisana_kol',
            'bolest.sifra_bolest',
            'lek.sifra_lek',
            'bolest.ime_bolest',
            'lek.ime_lek',
            'users.name'
        )
        ->join('bolest','lecenje.id_bolest','=','bolest.id')
        ->join('lek','lecenje.id_lek','=','lek.id')
        ->join('users', 'users.id','=','lecenje.id_lekar')
        ->where('lecenje.id_pacijent',$id)
        ->orderBy('lecenje.datum','desc')
        ->get();

        $counter=count($lecenjeRaw);
        $lecenja=[];
        $br=0;

        for($i=0; $i<$counter; $i++)
        {
            if($i==0)
            {
                $poseta=[];
                $id_tracker=[];
                $lekovi=[['sifra_bolest'=>$lecenjeRaw[$i]->sifra_bolest,'sifra_lek'=>$lecenjeRaw[$i]->sifra_lek,
                'name_bolest'=>$lecenjeRaw[$i]->ime_bolest,'name_lek'=>$lecenjeRaw[$i]->ime_lek,
                'lek_prepisana_kol'=>$lecenjeRaw[$i]->lek_prepisana_kol,
                'ind_tracer'=>$lecenjeRaw[$i]->id]];
                array_push($id_tracker,$lecenjeRaw[$i]->id);
                $poseta=['datum'=>$lecenjeRaw[$i]->datum,'prva_poseta'=>$lecenjeRaw[$i]->prva_poseta,
                'dijagnoza'=>$lecenjeRaw[$i]->dijagnoza,'terapija'=>$lecenjeRaw[$i]->terapija,
                'id_lekar'=>$lecenjeRaw[$i]->name,'lekovi'=>$lekovi,'id_tracker'=>$id_tracker];
                array_push($lecenja,$poseta);
            }
            else
            {
                if($lecenjeRaw[$i]->datum===$lecenja[$br]['datum'] and $lecenjeRaw[$i]->dijagnoza===$lecenja[$br]['dijagnoza'])
                {
                    $lekovi=['sifra_bolest'=>$lecenjeRaw[$i]->sifra_bolest,'sifra_lek'=>$lecenjeRaw[$i]->sifra_lek,'lek_prepisana_kol'=>$lecenjeRaw[$i]->lek_prepisana_kol,
                    'ind_tracer'=>$lecenjeRaw[$i]->id,'name_bolest'=>$lecenjeRaw[$i]->ime_bolest,'name_lek'=>$lecenjeRaw[$i]->ime_lek];
                    $id_tracker=$lecenjeRaw[$i]->id;
                    array_push($lecenja[$br]['lekovi'],$lekovi);
                    array_push($lecenja[$br]['id_tracker'],$id_tracker);
                }
                else
                {
                    $br++;
                    $poseta=[];
                    $id_tracker=[];
                    $lekovi=[['sifra_bolest'=>$lecenjeRaw[$i]->sifra_bolest,'sifra_lek'=>$lecenjeRaw[$i]->sifra_lek,'lek_prepisana_kol'=>$lecenjeRaw[$i]->lek_prepisana_kol,
                    'name_bolest'=>$lecenjeRaw[$i]->ime_bolest,'name_lek'=>$lecenjeRaw[$i]->ime_lek,
                    'ind_tracer'=>$lecenjeRaw[$i]->id]];
                    array_push($id_tracker,$lecenjeRaw[$i]->id);
                    $poseta=['datum'=>$lecenjeRaw[$i]->datum,'prva_poseta'=>$lecenjeRaw[$i]->prva_poseta,
                    'dijagnoza'=>$lecenjeRaw[$i]->dijagnoza,'terapija'=>$lecenjeRaw[$i]->terapija,
                    'id_lekar'=>$lecenjeRaw[$i]->name,'lekovi'=>$lekovi,'id_tracker'=>$id_tracker];
                    array_push($lecenja,$poseta);
                }
            }
        }

        return $lecenja;
    }

    //vraca podatke za jednu poseta
    public static function getVisitData($list)
    {
        $arrT=explode(',',$list);
        $lekovi=[];
        foreach($arrT as $visNum)
        {
            $pom=TreatmentModel::find($visNum);
            array_push($lekovi,['name_bolest'=>HelpFuncResource::getNameBolesti($pom->id_bolest),'name_lek'=>HelpFuncResource::getNameLeka($pom->id_lek),'lek_prepisana_kol'=>$pom->lek_prepisana_kol,
            'ind_tracer'=>$pom->id]);
        }
        return ['datum'=>$pom->datum,'prva_poseta'=>$pom->prva_poseta,
        'dijagnoza'=>$pom->dijagnoza,'terapija'=>$pom->terapija,
        'id_lekar'=>HelpFuncResource::getUserName($pom->id_lekar),'lekovi'=>$lekovi,'id_tracker'=>$list];
    }

    //lista svih id-jeva svih pacijenata
    public static function getAllPatientID()
    {
        $arr=PatientModel::all();
        $list=[];
        foreach($arr as $pat)
        {
            array_push($list,$pat->id);
        }
        return $list;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\HelpFuncResource;
use App\Http\Resources\ChartResource;
use App\PatientModel;
use App\TreatmentModel;
use App\CureModel;
use App\DiseaseModel;
use Illuminate\Support\Facades\DB;

class ReactSupportController extends Controller
{
    //
    public function createDataJSON()
    {
        $listPatients=ChartResource::getAllPatientID();
        $jsonCharts=[];
        $json=[];
        foreach($listPatients as $patId)
        {
            $jsonCharts[$patId]=[
                'osnovni'=>ChartResource::mainChartData($patId),
                'posete'=>ChartResource::getTreatmantData($patId)
            ];
        }
        $json['charts']=$jsonCharts;
        $json['cures']=CureModel::all();
        $json['dis']=DiseaseModel::all();
        $json['users']=DB::table('users')
        ->select('id','name','role')
        ->where('role',1)
        ->orWhere('role',2)
        ->orWhere('role',3)
        ->get();
        if(isset(auth()->user()->id))
        {
           $json['auth']=auth()->user()->id; 
        }
        else
        {
            $json['auth']=""; 
        }

        return json_encode($json);
    }

    public function reactAPI()
    {
        return view('react.reactAPI');
    }

    public function kartoniStranica()
    {
        return view('react.kartoniStranica');
    }

}

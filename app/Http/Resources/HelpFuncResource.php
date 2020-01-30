<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\UserModel;
use App\CureModel;
use App\DiseaseModel;
use App\PatientModel;
use App\TreatmentModel;
use App\Http\Resources\ChartResource;


class HelpFuncResource extends JsonResource
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

    public static function getUserName($id)
    {
        return UserModel::find($id)->name;
    }

    public static function getDoctorList()
    {
        return UserModel::select('id','name')->where('role',2)->get();
    }

    public static function getIdLeka($sifra)
    {
       $rez=CureModel::where('sifra_lek',$sifra)->first();
       if($rez!=null)
       {
           return $rez->id;
       }
       else
       {
           return "";
       }
    }

    public static function getCodeLeka($id)
    {
        return CureModel::find($id)->sifra_lek;
    }

    public static function getNameLeka($id)
    {
        return CureModel::find($id)->ime_lek;
    }

    public static function getIdBolesti($sifra)
    {
        $rez=DiseaseModel::where('sifra_bolest',$sifra)->first();
        if($rez!=null)
        {
            return $rez->id;
        }
        else
        {
            return "";
        }
    }

    public static function getCodeBolesti($id)
    {
        return DiseaseModel::find($id)->sifra_bolest;
    }

    public static function getNameBolesti($id)
    {
        return DiseaseModel::find($id)->ime_bolest;
    }

    public static function changeCure($id,$k=-1)
    {
        $cure=CureModel::find($id);
        $cure->kolicina_lek=$cure->kolicina_lek+$k;
        $cure->save();
    }

    public static function checkIfHeIsMyDoctor($id)
    {
        return auth()->user()->id==ChartResource::mainChartData($id)->lekar;
    }

    public static function getListOfDiseaseCodes()
    {
        return DiseaseModel::select('sifra_bolest')->get();
    }

    public static function getListOfCuresCodes()
    {
        return CureModel::select('sifra_lek')->get();
    }

    public static function canDeleteDoctor($id)
    {
        return (PatientModel::where('lekar',$id)->count()==0)? true:false;
    }
}

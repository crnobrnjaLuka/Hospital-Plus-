<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PatientModel;
use App\Http\Resources\ChartResource;
use App\Http\Resources\HelpFuncResource;

class ChartController extends Controller
{
    //vraca podatke da kreira karton
    public function showChart($id)
    {
        $mainData=ChartResource::mainChartData($id);
        $treatmants=ChartResource::getTreatmantData($id);
        if(HelpFuncResource::checkIfHeIsMyDoctor($id))
        {
            return view('lekar.chart',['mainData'=>$mainData,'treatmants'=>$treatmants]);
        }
        else
        {
            return back()->withErrors(['Nije vas pacijent!']);;
        }
    }

    public function editChart($id)
    {
        if(HelpFuncResource::checkIfHeIsMyDoctor($id))
        {
            $mainData=ChartResource::mainChartData($id);
            return view('lekar.editChart',['mainData'=>$mainData]);
        }
        else
        {
            return back()->withErrors(['Nije vas pacijent!']);
        }
    }

    //upisuje se izmene poverljivih podataka o pacijentu
    public function updateChart(Request $request)
    {
        $request->validate([
            'id'=>'required',
        ]);

        $pom=PatientModel::find($request->id);
        $pom->istorija_bolesti=$request->istorija_bolesti ?? "";
        $pom->alergija_lek=$request->alergija_lek ?? "";

        $json=$request->json ?? false;

        if(HelpFuncResource::checkIfHeIsMyDoctor($request->id))
        {
            $pom->save();
            if($json)
            {
                return json_encode("Snimljeno");
            }
            return redirect('/lekar/chart/'.$request->id)->withErrors(['Nije sačuvano!']); 
        }
        else
        {
            if($json)
            {
                return json_encode("Nije Vas pacijent.");
            }
            return back()->withErrors(['Nije sačuvano!']);
        }
    }
}

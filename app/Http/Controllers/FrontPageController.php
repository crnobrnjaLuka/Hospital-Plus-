<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\HelpFuncResource;
use App\Http\Resources\ChartResource;
use App\PatientModel;
use App\TreatmentModel;
use App\CureModel;

class FrontPageController extends Controller
{
    //
    public function index()
    {
        return view('/glavna');
    }

    public function login()
    {
        return redirect('/login');
    }

    public function test()
    {
        $a=HelpFuncResource::canDeleteDoctor(1);
        return view('test.test',['a'=>$a]);
    }

}

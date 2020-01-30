<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PatientModel;

class DoctorController extends Controller
{
    public function index()
    {
        $patients=PatientModel::where('lekar',auth()->user()->id)->get();
        return view('lekar.allPatients',['patients'=>$patients]);
    }

    
}

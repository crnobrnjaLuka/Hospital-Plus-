<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PatientModel;
use App\Http\Resources\HelpFuncResource;
use Illuminate\Support\Facades\DB;
//uraditi u odnosu na model sa pacijentima

class AssistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $listaPacijenata=DB::table('pacijent')
        ->select('pacijent.id','ime','prezime','dat_rodjenja','pol','jmbg','grad','ulica','broj','name')
        ->join('users', 'users.id','=','pacijent.lekar')
        ->get();

        return view('osoblje.allPatients',['listaPacijenata'=>$listaPacijenata]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //lista svih doktora sa id i imenom
        $doctorList=HelpFuncResource::getDoctorList();
        return view('osoblje.createPatient',['doctorList'=>$doctorList]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'ime'=>'required',
            'prezime'=>'required',
            'dat_rodjenja'=>'required',
            'pol'=>'required',
            'grad'=>'required',
            'ulica'=>'required',
            'broj'=>'required',
            'jmbg'=>'required',
            'lekar'=>'required',
        ]);


        $newPatient=new PatientModel;
        $newPatient->ime=$request->ime;
        $newPatient->prezime=$request->prezime;
        $newPatient->dat_rodjenja=$request->dat_rodjenja;
        $newPatient->pol=$request->pol;
        $newPatient->grad=$request->grad;
        $newPatient->ulica=$request->ulica;
        $newPatient->broj=$request->broj;
        $newPatient->jmbg=$request->jmbg;
        $newPatient->lekar=$request->lekar;
        $newPatient->istorija_bolesti="";
        $newPatient->alergija_lek="";
        if(strlen($newPatient->jmbg)!=13) return back()->withInput()->withErrors(['JMBG mora da ima 13 karaktera']);
        $newPatient->saveOrFail();
        return redirect('/osoblje')->withErrors(['Sacuvano']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $pacijent=PatientModel::find($id);
        $doctorList=HelpFuncResource::getDoctorList();
        return view('osoblje.editPatient',['pacijent'=>$pacijent,'doctorList'=>$doctorList]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'ime'=>'required',
            'prezime'=>'required',
            'dat_rodjenja'=>'required',
            'pol'=>'required',
            'grad'=>'required',
            'ulica'=>'required',
            'broj'=>'required',
            'jmbg'=>'required',
            'lekar'=>'required',
        ]);
        
        //samo podaci koji nisu poverljivi
        $newPatient=PatientModel::find($request->id);
        $newPatient->ime=$request->ime;
        $newPatient->prezime=$request->prezime;
        $newPatient->dat_rodjenja=$request->dat_rodjenja;
        $newPatient->pol=$request->pol;
        $newPatient->grad=$request->grad;
        $newPatient->ulica=$request->ulica;
        $newPatient->broj=$request->broj;
        $newPatient->jmbg=$request->jmbg;
        $newPatient->lekar=$request->lekar;
        $newPatient->saveOrFail();

        return redirect('/osoblje')->withErrors(['Sačuvano!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //za brisanje
        PatientModel::destroy($id);
        return redirect('/osoblje')->withErrors(['Destroyed!']);;
    }
}

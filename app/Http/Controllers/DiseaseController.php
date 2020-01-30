<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DiseaseModel;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $diseases=DiseaseModel::orderBy('ime_bolest','ASC')->get();
        return view('bolesti.disease', ['diseases'=>$diseases]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('bolesti.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'sifra'=>'required',
            'ime'=>'required',
        ]);

        $disease=new DiseaseModel;

        $disease->sifra_bolest=$request->sifra;
        $disease->ime_bolest=$request->ime;

        $disease->saveOrFail();

        return redirect('/bolesti')->withErrors(['Sačuvano!']);;
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
        $disease=DiseaseModel::find($id);
        return view('bolesti.edit',['disease'=>$disease]);
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
        //
        $request->validate([
            'id'=>'required',
            'sifra'=>'required',
            'ime'=>'required',
        ]);

        $disease=DiseaseModel::find($request->id);

        $disease->sifra_bolest=$request->sifra;
        $disease->ime_bolest=$request->ime;

        $disease->saveOrFail();

        return redirect('/bolesti')->withErrors(['Sačuvano!']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DiseaseModel::destroy($id);
        return redirect('/bolesti')->withErrors(['Desroyed!']);;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CureModel;


class CureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $cures=CureModel::orderBy('ime_lek','ASC')->get();
        return view('lekovi.cures', ['cures'=>$cures]);
    }

    public function curesByAmount()
    {
        $cures=CureModel::orderBy('kolicina_lek','ASC')->get();
        return view('lekovi.curesByAmount', ['cures'=>$cures]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('lekovi.create');
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
            'sifra'=>'required',
            'ime'=>'required',
            'kolicina'=>'required',
        ]);
        //
        $cure=new CureModel;

        $cure->sifra_lek=$request->sifra;
        $cure->ime_lek=$request->ime;
        $cure->kolicina_lek=$request->kolicina;

        $cure->saveOrFail();

        return redirect('/lekovi/curesByAmount')->withErrors(['Sačuvano!']);
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
        $cure=CureModel::find($id);
        return view('lekovi.edit',['cure'=>$cure]);
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
            'kolicina'=>'required',
        ]);

        $cure=CureModel::find($request->id);

        $cure->sifra_lek=$request->sifra;
        $cure->ime_lek=$request->ime;
        $cure->kolicina_lek=$request->kolicina;

        $cure->saveOrFail();

        return redirect('/lekovi/curesByAmount')->withErrors(['Sačuvano!']);
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
        CureModel::destroy($id);
        return redirect('/lekovi/curesByAmount')->withErrors(['Destroyed!']);;
    }
}

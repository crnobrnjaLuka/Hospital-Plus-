@extends('layouts.index')

@section('content')

@php
    // var_dump($data);
@endphp

<button class='linkDugme' data-link='/lekar/chart/{{ $data->id_pacijent }}'>Nazad</button>

<form action="/lekar/storeTreatmant" method="POST">
    @csrf

    @foreach ($errors->all() as $error)
            <p class="r_error">{{ $error }}</p>
        @endforeach
        <div class="disapear"><input type="date" name="datum"  value={{ $data->datum }} readonly></div>
        <div class="disapear"><input type="text" name="id_lekar"  value={{ $data->id_lekar }} readonly></div>
        <div class="disapear"><input type="text" name="id_pacijent"  value={{ $data->id_pacijent }} readonly></div>
            <label for="tipPosete" class="disapear">
                <select name="prva_poseta" id="tipPosete" readonly>
                    <option value="1" @if ($data->prva_poseta==1) {!! 'selected' !!}@endif>Prva Poseta</option>
                    <option value="0"  @if ($data->prva_poseta==0) {!! 'selected' !!}@endif>Kontrolna Poseta</option>
                </select>
            </label>
            <label for="dijagnoza" class="disapear">Dijagnoza <br><textarea id="dijagnoza" cols="30" rows="10" name='dijagnoza' readonly>{{ $data->dijagnoza }}</textarea></label><br>
            <label for="terapija" class="disapear">Terapija <br><textarea id="terapija" cols="30" rows="10" name='terapija' readonly>{{ $data->terapija }}</textarea></label><br>
            <label for=zadnji.sbId>Sifra bolesti: <input type="text" name='sifra_bolesti' id=zadnji.sbId value="" requred></label>
            <label for=zadnji.slId>Sifra leka: <input type="text" name='sifra_leka' id=zadnji.slId value="" requred></label>
            <label for=zadnji.klId>Kolicina leka: <input type="number" name='lek_prepisana_kol' id=zadnji.klId value="" requred></label>

    
   
    <input id='dugme' type="submit" value="Posalji">

</form>

@endsection
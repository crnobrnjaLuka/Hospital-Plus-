@extends('layouts.index')

@section('content')

@php
    // var_dump($data);
@endphp

<button class='linkDugme' data-link='/lekar/chart/{{ $data->id_pacijent }}'>Nazad</button>

<form action="/lekar/updateCure" method="POST">
    @csrf

    @foreach ($errors->all() as $error)
            <p class="r_error">{{ $error }}</p>
        @endforeach

    <div class="disapear"><input type="text" name="id" id="id" value={{ $data->id }}></div>
            <label for="tipPosete">
                <select name="prva_poseta" id="tipPosete" class="disapear">
                    <option value="1" @if ($data->prva_poseta==1) {!! 'selected' !!}@endif>Prva Poseta</option>
                    <option value="0"  @if ($data->prva_poseta==0) {!! 'selected' !!}@endif>Kontrolna Poseta</option>
                </select>
            </label>
            <label for="dijagnoza" class="disapear">Dijagnoza <br><textarea id="dijagnoza" cols="30" rows="10" name='dijagnoza'>{{ $data->dijagnoza }}</textarea></label><br>
            <label for="terapija" class="disapear">Terapija <br><textarea id="terapija" cols="30" rows="10" name='terapija'>{{ $data->terapija }}</textarea></label><br>
            <label for=zadnji.klIdStr class="disapear">Kolicina leka: <input type="number" name='lek_prepisana_kol_staro' id=zadnji.klIdStr value={{ $data->lek_prepisana_kol }} readonly></label>
            <label for=zadnji.sbId>Sifra bolesti: <input type="text" name='sifra_bolesti' id=zadnji.sbId value={{ $data->sifra_bolesti }}></label>
            <label for=zadnji.slId>Sifra leka: <input type="text" name='sifra_leka' id=zadnji.slId value={{ $data->sifra_leka }}></label>
            <label for=zadnji.klId>Kolicina leka: <input type="number" name='lek_prepisana_kol' id=zadnji.klId value={{ $data->lek_prepisana_kol }}></label>

    
   
    <input id='dugme' type="submit" value="Posalji">

</form>

@endsection
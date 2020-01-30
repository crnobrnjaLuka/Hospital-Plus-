@extends('layouts.index')

@section('content')

@php
    // var_dump($data);
@endphp

<button class='linkDugme' data-link='/lekar/chart/{{ $data->id_pacijent }}'>Nazad</button>

<form action="/lekar/updateVisit" method="POST">
    @csrf

    @foreach ($errors->all() as $error)
            <p class="r_error">{{ $error }}</p>
        @endforeach

    <div class="disapear"><input type="text" name="tracers" id="id" value={{ $data->tracers }}></div>
            <label for="tipPosete">
                <select name="prva_poseta" id="tipPosete">
                    <option value="1" @if ($data->prva_poseta==1) {!! 'selected' !!}@endif>Prva Poseta</option>
                    <option value="0"  @if ($data->prva_poseta==0) {!! 'selected' !!}@endif>Kontrolna Poseta</option>
                </select>
            </label>
            <label for="dijagnoza">Dijagnoza <br><textarea id="dijagnoza" cols="30" rows="10" name='dijagnoza'>{{ $data->dijagnoza }}</textarea></label><br>
            <label for="terapija">Terapija <br><textarea id="terapija" cols="30" rows="10" name='terapija'>{{ $data->terapija }}</textarea></label><br>
            

    
   
    <input id='dugme' type="submit" value="Posalji">

</form>

@endsection
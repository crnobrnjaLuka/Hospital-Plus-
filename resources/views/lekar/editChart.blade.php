@extends('layouts.index')

@section('content')

@php
    // var_dump($mainData);
@endphp



<form action="/lekar/updateChart" method="POST">
    @csrf

    @foreach ($errors->all() as $error)
            <p class="r_error">{{ $error }}</p>
        @endforeach
    <div class="flexRow">
        <div>
            <span>Broj Kartona: K-<input type="number" name='id' value="{{ $mainData->id }}" readonly required></span>
        </div>
        <div>
            <span>Ime: <input type="text" name="ime" value="{{ $mainData->ime }}" ><span>Prezime: <input type="text" name="prezime" value="{{ $mainData->prezime }}"></span><!-- ovo je duplo zato da bi menjalo izgled datuma na naski -->
            <label for="dateRodjEditChart" id="label1">Datum Rodjenja <input type="date" name="dat_rodjenja" value="{{ $mainData->dat_rodjenja }}" id="dateRodjEditChart"></label>
            <label for="dateRodj2EditChart" id="label2" class="disapear">Datum Rodjenja <input type="text" id="dateRodj2EditChart"></label><span></span></span>
        </div>
    </div>
    

    
    
    <textarea name="istorija_bolesti" id="" cols="30" rows="10" required>{{ $mainData->istorija_bolesti }}</textarea>
    <textarea name="alergija_lek" id="" cols="30" rows="10" required>{{ $mainData->alergija_lek }}</textarea>
   
    <input id='dugme' type="submit" value="Posalji">

</form>
<div class="edit_chart_button">
    <button class='linkDugme' data-link='/lekar/chart/{{ $mainData->id }}'>Nazad</button>
</div>


@endsection
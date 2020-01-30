@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">
@php
// var_dump($cures);
@endphp
@auth
<div class="margin_20 flexColumn">
    <div class="bolestiNaslov">
        <h1>Oboljenja</h1>
    </div>

    <label class="osobFilter leftMargin" for="filter">
        <input type="text" id="filter" class='kartonInput' style="background-image: url('/images/search.png')" placeholder="Pretraži...">
    </label>
    <div class="tabelaOboljenja">


        @if (Auth::user()->role==1)
        <button class='linkDugme w100' data-link='/bolesti/create'>Dodaj novo oboljenje</button>
        @endif


        <table>
            <tr>
                <th>Šifra</th>
                <th>Naziv</th>
                @if (Auth::user()->role==1)
                <th>Izmeni</th>
                <!-- <th>Obrisi</th> -->
                @endif
            </tr>

            @foreach ($diseases as $disease)
            <tr>
                <td>{{ $disease->sifra_bolest }}</td>
                <td>{{ $disease->ime_bolest }}</td>
                @if (Auth::user()->role==1)
                <td><button class='linkDugme linkDugmeIzmeni' data-link='/bolesti/edit/{{ $disease->id }}' style="background-image: url('/images/pencil.png')"></button></td>
                <!-- <td><button class='obrisi' data-link='/bolesti/destroy/{{ $disease->id }}'>Obrisi</button></td> -->
                @endif
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endauth
@foreach ($errors->all() as $error)
<p class="r_error">{{ $error }}</p>
@endforeach

@endsection
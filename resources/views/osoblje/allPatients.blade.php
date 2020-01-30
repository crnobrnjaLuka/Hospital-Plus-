@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

@auth
<div class="margin_20 flexColumn">

    <div class="bolestiNaslov">
        <h1>Pacijenti</h1>
    </div>

    @foreach ($errors->all() as $error)
    <p class="r_error">{{ $error }}</p>
    @endforeach

    <label class="leftMargin" for="filter">
        <input type="text" id="filter" class='kartonInput' placeholder="Pretraži...">
    </label>

    <div class="tabelaOboljenja">


        <button class='linkDugme w100' data-link='/osoblje/create'>Dodaj Novog</button>

        <table>

            <head>
                <th>Karton</th>
                <th>Ime</th>
                <th>Prezime</th>
                <!-- <th>Datum Rodjenja</th> -->
                <th>Pol</th>
                <th>JMBG</th>
                <th>Grad</th>
                <th>Ulica</th>
                <th>Broj</th>
                <th>Doktor</th>
                <th>Izmeni</th>
                <!-- <th>Obrisi</th> -->
            </head>

            @foreach ($listaPacijenata as $pacijent)
            @php
            $date=explode('-',$pacijent->dat_rodjenja);
            $date=array_reverse($date);
            $pacijent->dat_rodjenja=implode('.',$date).".";
            @endphp
            <tr>
                <td>K-{{ $pacijent->id }}</td>
                <td>{{ $pacijent->ime }}</td>
                <td>{{ $pacijent->prezime }}</td>
                <!-- <td>{{ $pacijent->dat_rodjenja }}</td> -->
                <td>{{ $pacijent->pol }}</td>
                <td>{{ $pacijent->jmbg }}</td>
                <td>{{ $pacijent->grad }}</td>
                <td>{{ $pacijent->ulica }}</td>
                <td>{{ $pacijent->broj }}</td>
                <td>{{ $pacijent->name }}</td>
                <td><button class='linkDugme linkDugmeIzmeni' data-link='/osoblje/edit/{{ $pacijent->id }}' style="background-image: url('/images/pencil.png')"></button></td>
                <!-- <td><button class='obrisi' data-link='/osoblje/destroy/{{ $pacijent->id }}'>Ubij</button></td> -->
            </tr>

            @endforeach

        </table>
    </div>
</div>
@endauth


@endsection
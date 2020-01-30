@extends('layouts.index')

@section('content')

@auth
    <div class="margin_20">
        <label for="filter">
            <input type="text" id="filter" class='filter' placeholder="Pretraži...">
        </label>
    </div>
@endauth

<div class="patient-list">
    <h1>Spisak pacijenata</h1>

    @foreach ($errors->all() as $error)
        <p class="r_error">{{ $error }}</p>
    @endforeach

    <table>
        <head>
            <tr>
                <th>Broj Kartona</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Udji u karton</th>
            </tr>
        </head>

        @foreach ($patients as $patient)
        <tr>
            <td>{{ $patient->id }}</td>
            <td>{{ $patient->ime }}</td>
            <td>{{ $patient->prezime }}</td>
            <td><button class='linkDugme' data-link='/lekar/chart/{{ $patient->id }}'>Karton</button></td>
        </tr>
            
        @endforeach
    </table>

</div>

    

@endsection



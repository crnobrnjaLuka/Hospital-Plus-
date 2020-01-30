@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

@auth
    <div class="margin_20 flexColumn">
        <div class="bolestiNaslov">
            <h1>Medikament - promena podataka</h1>
        </div>

        @foreach ($errors->all() as $error)
            <p class="r_error">{{ $error }}</p>
        @endforeach
    </div>
@endauth

<button class='linkDugme' data-link='/lekovi'>Povratak na listu</button>

<form action="/lekovi/update" method="POST">
        @csrf

        <div class="okvir1 cardDisapear">
            <div class="okvir11">
                <label for="id">ID medikamenta</label>
            </div>
            <div class="okvir12 jmbg">
                <input type="number" name='id' value="{{ $cure->id }}" readonly required>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="sifra">Šifra medikamenta</label>
            </div>
            <div class="okvir12">
                <input type="text" name="sifra" value="{{ $cure->sifra_lek }}" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="ime">Naziv medikamenta</label>
            </div>
            <div class="okvir12">
                <input type="text" name="ime" value="{{ $cure->ime_lek }}" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="kolicina">Količina</label>
            </div>
            <div class="okvir12 jmbg">
                <input type="number" name="kolicina" value="{{ $cure->kolicina_lek }}" requred>
            </div>
        </div>

        <div class="divUnos">
            <input id='dugme' class='dugmeUnos' type="submit" value="" style="background-image: url('/images/check_32.png')">
        </div>

        
    </form>
@endsection
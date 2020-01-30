@extends('layouts.index')

@section('content')
    <link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

    @auth
        <div class="margin_20 flexColumn">
            <div class="bolestiNaslov">
                <h1>Izmena podataka o oboljenju</h1>
            </div>

            @foreach ($errors->all() as $error)
                <p class="r_error">{{ $error }}</p>
            @endforeach
        </div>
    @endauth


    <button class='linkDugme' data-link='/bolesti'>Povratak na listu</button>

    <form action="/bolesti/update" method="POST">
            @csrf
            

            <div class="okvir1 cardDisapear">
                <div class="okvir11">
                    <label for="id">ID</label>
                </div>
                <div class="okvir12 jmbg">
                    <input type="number" name='id' value="{{ $disease->id }}" readonly required>
                </div>
            </div>

            <div class="okvir1">
                <div class="okvir11">
                    <label for="sifra">Šifra oboljenja</label>
                </div>
                <div class="okvir12">
                    <input type="text" name="sifra" value="{{ $disease->sifra_bolest }}" requred>
                </div>
            </div>

            <div class="okvir1">
                <div class="okvir11">
                    <label for="">Naziv oboljenja</label>
                </div>
                <div class="okvir12">
                    <input type="text" name="ime" value="{{ $disease->ime_bolest }}" requred>
                </div>
            </div>        
        
            <div class="divUnos">
                <input id='dugme' class='dugmeUnos' type="submit" value="" style="background-image: url('/images/check_32.png')">
            </div>


        </form>
@endsection
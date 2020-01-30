@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

@auth
    <div class="margin_20 flexColumn">
        <div class="bolestiNaslov">
            <h1>Pacijent - promena podataka</h1>
        </div>

        @foreach ($errors->all() as $error)
            <p class="r_error">{{ $error }}</p>
        @endforeach
    </div>
@endauth

<button class='linkDugme' data-link='/osoblje'>Povratak na listu</button>
<div>
    <form action="/osoblje/update" method="POST">
        @csrf
                    
        <div class="okvir1 cardDisapear">
            <div class="okvir11">
                <label for="id">ID</label>
            </div>
            <div class="okvir12 jmbg">
                <input type="text" name='id' value="{{ $pacijent->id }}" requred readonly>
            </div>
        </div>
        
        <div class="okvir1">
            <div class="okvir11">
                <label for="ime">Ime</label>
            </div>
            <div class="okvir12">
                <input type="text" name="ime" value="{{ $pacijent->ime }}" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="prezime">Prezime</label>
            </div>
            <div class="okvir12">
                <input type="text" name="prezime" value="{{ $pacijent->prezime }}" requred>
            </div>
        </div>

        <!-- ovo je duplo zato da bi menjalo izgled datuma na formi -->
        <!-- DEO SA DATUMOM OSTAVITI KAKO JE KREIRAN ZBOG SAKRIVANJA NEPOTREBNOG -->
        <div class="okvir1">
            <div class="okvir11">
                <label for="">Datum rođenja</label>
            </div>
            <div class="okvir12">
                <label for="dateRodj" id="label1" ><input type="date" name="dat_rodjenja" value="{{ $pacijent->dat_rodjenja }}" id="dateRodjEditChart" requred></label>
                <label for="dateRodj2" id="label2" class="disapear"><input type="text" id="dateRodj2EditChart"></label>
            </div>
        </div>
        <!-- KRAJ DELA SA DATUMOM -->

        <div class="okvir1">
            <div class="okvir11">
                <label for="jmbg">JMBG</label>
            </div>
            <div class="okvir12 jmbg">
                <input type="number" name="jmbg" value="{{ $pacijent->jmbg }}" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="pol">Pol</label>
            </div>
            <div class="okvir12">
                <select class="formaIzbor" name="pol" id="" value= {{ $pacijent->pol }} >
                    <option value="muski"  @if ($pacijent->pol=='muski')selected @endif>muški</option>
                    <option value="zenski" @if ($pacijent->pol=='zenski')selected @endif>ženski</option>
                    <option value="neopredeljen" @if ($pacijent->pol=='neopredeljen')selected @endif>neopredeljen</option>
                </select>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="">Adresa stanovanja</label>
            </div>
            <div class="okvir12">
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="grad">Grad</label>
            </div>
            <div class="okvir12">
                <input type="text" name="grad" value="{{ $pacijent->grad }}" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="ulica">Ulica</label>
            </div>
            <div class="okvir12">
                <input type="text" name="ulica" value="{{ $pacijent->ulica }}" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="broj">Broj</label>
            </div>
            <div class="okvir12 jmbg">
                <input type="text" name="broj" value="{{ $pacijent->broj }}" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="lekar">Glavni doktor</label>
            </div>
            <div class="okvir12">
                <select name="lekar" id="" value= {{ $pacijent->lekar }} >
                    @foreach ($doctorList as $doctor)
                        <option value="{{ $doctor->id }}" @if($pacijent->lekar==$doctor->id) selected @endif>{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="divUnos">
            <input id='dugme' class='dugmeUnos' type="submit" value="" style="background-image: url('/images/check_32.png')">
        </div>


    </form>
</div>
@endsection
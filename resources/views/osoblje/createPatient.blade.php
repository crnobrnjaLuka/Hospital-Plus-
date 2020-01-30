@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

@auth
    <div class="margin_20 flexColumn">
        <div class="bolestiNaslov">
            <h1>Pacijent - dodavanje novog</h1>
        </div>

        @foreach ($errors->all() as $error)
            <p class="r_error">{{ $error }}</p>
        @endforeach
    </div>
@endauth

<button class='linkDugme' data-link='/osoblje'>Povratak na listu</button>
<div>
    <form action="/osoblje/store" method="POST">
        @csrf

        <div class="okvir1">
            <div class="okvir11">
                <label for="ime">Ime</label>
            </div>
            <div class="okvir12">
                <input type="text" name="ime" value="" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="prezime">Prezime</label>
            </div>
            <div class="okvir12">
                <input type="text" name="prezime" value="" requred>
            </div>
        </div>
        
        <!-- ovo je duplo zato da bi menjalo izgled datuma na formi -->
        <!-- DEO SA DATUMOM OSTAVITI KAKO JE KREIRAN ZBOG SAKRIVANJA NEPOTREBNOG -->
        <div class="okvir1">
            <div class="okvir11">
                <label for="">Datum rođenja</label>
            </div>
            <div class="okvir12">
                <label for="dateRodj" id="label1"><input type="date" name="dat_rodjenja" value="" id="dateRodj" requred></label>
                <label for="dateRodj2" id="label2" class="disapear"><input type="text" id="dateRodj2"></label>
            </div>
        </div>
        <!-- KRAJ DELA SA DATUMOM -->

        <div class="okvir1">
            <div class="okvir11">
                <label for="jmbg">JMBG</label>
            </div>
            <div class="okvir12 jmbg">
                <input type="number" name="jmbg" value="" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="pol">Pol</label>
            </div>
            <div class="okvir12">
                <select class="formaIzbor" name="pol" id="">
                    <option value="muski">muški</option>
                    <option value="zenski">ženski</option>
                    <option value="neopredeljen">neopredeljen</option>
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
                <input type="text" name="grad" value="" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="ulica">Ulica</label>
            </div>
            <div class="okvir12">
                <input type="text" name="ulica" value="" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="broj">Broj</label>
            </div>
            <div class="okvir12 jmbg">
                <input type="text" name="broj" value="" requred>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="lekar">Glavni doktor</label>
            </div>
            <div class="okvir12">
            <select class="formaIzbor" name="lekar" id="">
                    @foreach ($doctorList as $doctor)
                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="divUnos">
            <input id='dugme' class='dugmeUnos' type="submit" value="" style="background-image: url('/images/check_32.png')">
        </div>


    </form>
</div>


<script src="biblioteka.js"></script>
<script>
    let dateStartLabel = document.querySelector('#label1');
    let dateStartLabel2 = document.querySelector('#label2');
    let dateStartInput = document.querySelector('#dateRodj');
    let dateStartInput2 = document.querySelector('#dateRodj2');

    function changeVisibilityStart() {
        dateStartLabel.classList.toggle('disapear');
        dateStartLabel2.classList.toggle('disapear');
    }

    //dogadjaji
    dateStartInput.addEventListener('change', function() {
        changeVisibilityStart();
        dateStartInput2.value = pf.dateToSerbianFormat(dateStartInput.value);
    })

    dateStartInput2.addEventListener('click', function() {
        changeVisibilityStart();
        dateStartInput.value = "";
        dateStartInput.focus();
    })
</script>
@endsection
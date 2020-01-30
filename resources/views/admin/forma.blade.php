@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

@auth
    <div class="margin_20 flexColumn">
        <div class="bolestiNaslov">
            <h1>Korisnik - promena podataka</h1>
        </div>
    </div>
@endauth


<form method="POST" action="/admin/change">

    @foreach ($errors->all() as $error)
        <p class="r_error">{{ $error }}</p>
    @endforeach
    
    
    <div class="flexRow cardDisapear">@csrf</div>
    <div class="flexRow cardDisapear"><input type="number" name='id' id='id' value={{ $users->id }} hidden></div>
    <div class="flexColumn">

        <div class="okvir1">
            <div class="okvir11">
                <label for="name">Ime i prezime</label>
            </div>
            <div class="okvir12">
                <input type="text" name="name" id="name" value="{{ $users->name }}" readonly required>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="meil">Email</label>
            </div>
            <div class="okvir12">
                <input type="email" name="meil" id="meil" value="{{ $users->email }}" readonly required>
            </div>
        </div>

        <div class="okvir1">
            <div class="okvir11">
                <label for="role">Pozicija</label>
            </div>
            <div class="okvir12">
                <select name="role" id="role">
                    <option value="0" @if ($users->role=='0')
                        {!! "selected" !!}
                    @endif>Nedodeljeno</option>
                    <option value="1"@if ($users->role=='1')
                        {!! "selected" !!}
                    @endif>Osoblje</option>
                    <option value="2"@if ($users->role=='2')
                        {!! "selected" !!}
                    @endif>Lekar</option>
                </select>
            </div>
        </div>

        <div class="divUnos">
            <input id='dugme' class='dugmeUnos' type="submit" value="" style="background-image: url('/images/check_32.png')">
        </div>

    </div>
</form>
@endsection
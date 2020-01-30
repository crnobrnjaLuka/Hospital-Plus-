@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

<div class="margin_20 flexColumn">
  <div class="bolestiNaslov">
    <h1>
      Promena lozinke
    </h1>
  </div>
</div>



<div class="promenaLoz">
  <form method="POST" action="/changePassword">
    @csrf

    <div class="row  text-center">
      <div class="col-md-12">
        @foreach ($errors->all() as $error)
        <p class="text-danger">{{ $error }}</p>
        @endforeach
      </div>
    </div>


    <div class="okvir1">
      <div class="okvir11">
        <label for="password" class="col-md-4 col-form-label text-md-right">
          Stara
        </label>
      </div>


      <div class="okvir12  @error('current_password') {{'has-error'}} @enderror">
        <input id="password" type="password" class="form-control" name="current_password" autocomplete="current-password">
      </div>
    </div>


    <div class="okvir1">
      <div class="okvir11">
        <label for="password" class="col-md-4 col-form-label text-md-right">
          Nova
        </label>
      </div>

      <div class="okvir12  @error('new_password') {{'has-error'}} @enderror">
        <input id="new_password" type="password" class="form-control" name="new_password" autocomplete="current-password">
      </div>
    </div>


    <div class="okvir1">
      <div class="okvir11">
        <label for="password" class="col-md-4 col-form-label text-md-right">
          Potvrdi novu
        </label>
      </div>

      <div class="okvir12 @error('new_confirm_password') {{'has-error'}} @enderror">
        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password" autocomplete="current-password">
      </div>
    </div>



    <div class="divPrijava">
      <button type="submit" class="dugmePrijava" style="background-image: url('/images/check_32.png')">
      </button>
    </div>


  </form>
</div>
</div>
@endsection
@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">



<div>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <div class="margin_20 flexColumn">
        <div class="bolestiNaslov">
            <h1>
                Vi ste ulogovani!
			</h1>
        </div>
    </div>

    <div class="prijavaPot">

        <div class="viSteLogovani">
            <a href="/glavna">Povratak na glavnu stranicu</a>
		</div>
		
		<div class="viSteLogovani">
            <a href="/izmeniPodatkeUser">Promeni podatke</a>
        </div>
        
        <div class="viSteLogovani">
        <a href="/izmeniLozinku">Promeni lozinku</a>
		</div>


        <div class="viSteLogovani">
            <a href="{{ route('logout') }}" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>		
        </div>




    </div>






    

</div>

@endsection

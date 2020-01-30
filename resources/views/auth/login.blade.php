@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">


    <div class="margin_20 flexColumn">
        <div class="bolestiNaslov">
            <h1>
				<div>
					{{ __('Prijavljivanje') }}
				</div>
			</h1>
        </div>
    </div>




<div class="prijava">
	<form method="POST" action="{{ route('login') }}">
		@csrf

		<div class="okvir1">
            <div class="okvir11">
				<label for="email">
					{{ __('E-mail') }}
				</label>
            </div>
            <div class="okvir12">
				<input class="inPrijava" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
            </div>
        </div>


        <div class="okvir1">
            <div class="okvir11">
				<label for="password">
					{{ __('Lozinka') }}
				</label>
            </div>
				<div class="okvir12">
				<input class="inPrijava" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
            </div>
		</div>
		
		<div class="okvir1">
            <div class="okvir11">
            </div>
			<div class="okvir12">
				<input class="formCheckInput" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
				<label class="remember" for="remember">
					{{ __('Zapamti me') }}
				</label>
			</div>
		</div>



			<div class="divPrijava">
				<button type="submit" class="dugmePrijava" style="background-image: url('/images/check_32.png')">
				</button>
			</div>
			<div class="passReq">
				@if (Route::has('password.request'))
					<a href="{{ route('password.request') }}">
						{{ __('Zaboravili ste lozinku?') }}
					</a>
				@endif
			</div>
	</form>
</div>
			
				
@endsection

@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">


<div class="margin_20 flexColumn">
	<div class="bolestiNaslov">
		<h1>
			<div>
				{{ __('Registracija') }}
			</div>
		</h1>
	</div>
</div>

			
<div class="promenaLoz">
	<form method="POST" action="{{ route('register') }}">
		@csrf

		<div class="okvir1">
			<div class="okvir11">
				<label for="name" class="col-md-4 col-form-label text-md-right">
					{{ __('Ime i prezime') }}
				</label>
			</div>

			<div class="okvir12">
				<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

				@error('name')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

		</div>

		<div class="okvir1">
			<div class="okvir11">
				<label for="email" class="col-md-4 col-form-label text-md-right">
					{{ __('E-Mail Address') }}
				</label>
			</div>

			<div class="okvir12">
				<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

		</div>

		<div class="okvir1">
			<div class="okvir11">
				<label for="password" class="col-md-4 col-form-label text-md-right">
					{{ __('Password') }}
				</label>
			</div>

			<div class="okvir12">
				<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

		</div>

		<div class="okvir1">
			<div class="okvir11">
				<label for="password-confirm" class="col-md-4 col-form-label text-md-right">
					{{ __('Confirm Password') }}
				</label>
			</div>

			<div class="okvir12">
				<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
			</div>

		</div>

		<div class="divPrijava">
			<button type="submit" class="dugmePrijava" style="background-image: url('/images/check_32.png')">
			</button>
		</div>
	</form>
</div>
@endsection

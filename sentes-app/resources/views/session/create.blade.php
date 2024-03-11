<x-layoutLight>
	<section>
		<x-basicFrameHeader>
			<h1>
                Connexion
            </h1>
		</x-basicFrameHeader>
		<x-basicFrameContent>
			<form method="POST" action="/session" class="w-50">
				@csrf

				<div class="form-input">
					<label for="email" class="text-shadowed">
                        Email
                    </label>
					<input type="email" name="email" id="email" value="{{ old('email') }}" required>
					@error('email')
					<p>
						{{ $message }}
					</p>
					@enderror
				</div>

				<div class="form-input">
					<label for="password" class="text-shadowed">
                        Mot de passe
                    </label>
					<input type="password" name="password" id="password" required>
					@error('password')
					<p>
						{{ $message }}
					</p>
					@enderror
				</div>

				<div class="form-check">
					<input type="checkbox" name="remember" id="remember">
					<label for="remember">
                        Se souvenir de moi
                    </label>
				</div>

				<div class="form-input">
					<button type="submit" class="green-button special-elite-regular">
                        Te connecter
                    </button>
				</div>

				<div class="form-input">
					<a href="{{ route('password.request') }}" class="text-green link">Mot de passe oublié ?</a>
				</div>

			</form>
		</x-basicFrameContent>
	</section>
</x-layoutLight>


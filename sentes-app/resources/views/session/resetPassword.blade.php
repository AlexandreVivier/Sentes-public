<x-layoutLight>
	<section>
		<x-basicFrameHeader>
			<h1 class="special-elite-regular">
                Mot de passe oublié ?
            </h1>
		</x-basicFrameHeader>

		<x-basicFrameContent>
			<form method="POST" action="/reset-password">
				@csrf

				<div class="form-input">
					<input type="hidden" name="email" id="email" value="{{ $email }}" required>
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

				<div class="form-input">
					<label for="password_confirmation" class="text-shadowed">
                        Confirmer le mot de passe
                    </label>
					<input type="password" name="password_confirmation" id="password_confirmation" required>
					<p class="text-small italic text-green">
						Le mot de passe doit faire entre 10 et 25 caractères de long, inclure une majuscule, une minuscule, un chiffre et un caractère spécial.
					</p>
					@error('password_confirmation')
					<p>
						{{ $message }}
					</p>
					@enderror
				</div>

				<div class="form-check">
					<input type="hidden" name="token" id="token" value="{{ $token }}" >
				</div>

				<div class="form-input">
					<button type="submit" class="green-button special-elite-regular">
                        Enregistrer
                    </button>
				</div>

			</form>
		</x-basicFrameContent>
	</section>
</x-layoutLight>


<x-layoutLight>
	<section>
		<x-basicFrameHeader>
			<h1 class="special-elite-regular">
                Mot de passe oublié ?
            </h1>
		</x-basicFrameHeader>

		<x-basicFrameContent>
			<form method="POST" action="/forgot-password">
				@csrf

				<div class="form-input">
					<label for="email" class="text-shadowed">
                        Email :
                    </label>
					<input type="email" name="email" id="email" value="{{ old('email') }}" required>
					<p class="text-small italic text-green">
						Vérifie tes emails, tu recevras un lien pour réinitialiser ton mot de passe.
					</p>
					@error('email')
					<p>
						{{ $message }}
					</p>
					@enderror
				</div>

				<div class="form-input">
					<button type="submit" class="green-button special-elite-regular">
                        Réinitialiser mon mot de passe.
                    </button>
				</div>
			</form>
		</x-basicFrameContent>
	</section>
</x-layoutLight>


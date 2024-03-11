<x-layoutLight>
	<section>
		<x-basicFrameHeader>
			<h1>
                Inscription
            </h1>
		</x-basicFrameHeader>
		<x-basicFrameContent>
			<form method="POST" action="/register">
				@csrf

					@include('components.forms.userCreate1')

                    <div class="form-check">
                        <input type="checkbox" name="accepted_terms" id="accepted_terms" value=1 required>
                        <label for="accepted_terms">
                            J'accepte les
                            <a href="#" class="text-green link italic" id="showTerms">conditions d'utilisation</a>
                            du site.
                        </label>

                    </div>

				<div class="form-input">
					<button type="submit" class="green-button special-elite-regular">
                        Je m'inscris
                    </button>
				</div>

			</form>
		</x-basicFrameContent>
	</section>
<dialog class="">
@include('components.modals.termsOfUse')
</dialog>

@include('components.scripts.modalTerms')


</x-layoutLight>


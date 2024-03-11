<x-layoutLight>
	<section>
		<x-basicFrameHeader>
			<h1>
                Créer un nouveau GN
            </h1>
		</x-basicFrameHeader>

		<x-basicFrameContent>
			<form method="POST" action="/events" class="form-large">
				@csrf

                        @include('components.forms.eventCreate1')

						<div class="form-input form-multi-button">
							<a href="{{ route('home') }}" class="light-button">
                                Retour
                            </a>
							<button type="submit" class="green-button">
                                Suivant
                            </button>
						</div>
			</form>
		</x-basicFrameContent>
	</section>
</x-layoutLight>


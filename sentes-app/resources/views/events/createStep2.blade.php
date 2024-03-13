<x-layoutLight>
	<section>
		<x-basicFrameHeader>
			<h1 class="special-elite-regular">
                Créer un nouveau GN
            </h1>
		</x-basicFrameHeader>

		<x-basicFrameContent>
			<form method="POST" action="{{ route('events.update', $event) }}" class="form-large" enctype="multipart/form-data">

                @csrf
                @method('PATCH')

                @include('components.forms.eventCreate2')

                <div class="form-input form-multi-button">
                    <a href="{{ route('home') }}" class="light-button special-elite-regular">
                        Ignorer
                    </a>
                    <button type="submit" class="green-button special-elite-regular">
                        Enregistrer
                    </button>
                </div>
			</form>
		</x-basicFrameContent>
	</section>
</x-layoutLight>


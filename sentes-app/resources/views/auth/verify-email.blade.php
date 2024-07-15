<x-layoutLight>
	<section>
		<x-basicFrameHeader>
			<h1 class="special-elite-regular">
                Compte non vérifié
            </h1>
		</x-basicFrameHeader>
		<x-basicFrameContent>
            <p>Ton compte n'est pas encore vérifié, tu ne peux pas faire cette action pour le moment.</p>
            <p>Si tu n'as pas reçu le mail de vérification, tu peux en demander un nouveau en cliquant sur le bouton ci-dessous.</p>
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="green-button special-elite-regular">
                    Renvoyer le mail de vérification
                </button>
                <a href="{{ route('home') }}" class="light-button special-elite-regular">Retourner à l'accueil</a>
            </form>

		</x-basicFrameContent>
        <div class="h-50vh"></div>
	</section>
</x-layoutLight>


<x-layoutLight>
	<section>
		<x-basicFrameHeader>
            <h2 class="special-elite-regular">
                {{ $user->login }}
                @if($user->is_admin)
                <span class="italic">  (Admin du site) </span>
                @elseif($user->is_banned)
                <span class="italic uppercase"> (Banni) </span>
                @endif
            </h2>
		</x-basicFrameHeader>
		<x-basicFrameContent>
            <article>
                @include('components.shows.user', ['user' => $user])
                <div class="user-button-container">
                    <a href="{{ url()->previous() }}" class="light-button special-elite-regular">
                        Retour à la page précédente
                    </a>
                    <a href="{{ route('event.content.creation.index', $user->id) }}" class="light-button special-elite-regular">
                        Voir tout ce que {{ $user->login }} a créé
                    </a>
                </div>
                <div class="user-button-container">
                    <a href="#" class="light-button special-elite-regular">
                        Voir les organisations de {{ $user->login }}
                    </a>
                    <a href="#" class="light-button special-elite-regular">
                        Voir les GN sur lesquels {{ $user->login }} participe
                    </a>
                </div>
            </article>
        </x-basicFrameContent>
	</section>
</x-layoutLight>

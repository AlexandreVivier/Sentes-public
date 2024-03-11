<x-layoutLight>
	<section>
		<x-basicFrameHeader>
            <h2>
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
                </div>


            </article>
        </x-basicFrameContent>
	</section>
</x-layoutLight>

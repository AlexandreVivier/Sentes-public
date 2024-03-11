<x-layoutLight>
	<section>
		<x-basicFrameHeader>
            <h2 class="special-elite-regular">
                {{ $user->login }}
                @if($user->is_admin)
                <span class="italic">  (Admin du site) </span>
                @elseif($user->is_banned)
                <span class="italic">  (Banni) </span>
                @endif
            </h2>
		</x-basicFrameHeader>
		<x-basicFrameContent>
            <article>
                @include('components.shows.user', ['user' => $user])
                <div>
                    @if($user->id === auth()->user()->id)
                    <a href="{{ route('user.edit', $user->id) }}" class="light-button special-elite-regular">Modifier mon profil</a>
                    @endif
                </div>


            </article>
        </x-basicFrameContent>
	</section>
</x-layoutLight>

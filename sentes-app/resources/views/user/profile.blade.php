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
                <div class="user-button-container ">
                <div class="w-100">
                    @if($user->id === auth()->user()->id)
                    <a href="{{ route('user.edit', $user->id) }}" class="light-button special-elite-regular">Modifier mon profil</a>
                    @endif
                </div>
                <div class="w-100">
                    <form action="{{ route('user.delete', $user->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="transparent-button special-elite-regular" id="delete">
                            <span class="text-normal special-elite-regular">Supprimer mon compte</span>
                        </button>
                    </form>
                </div>
                </div>


            </article>
        </x-basicFrameContent>
	</section>
</x-layoutLight>

<x-layoutLight>
	<section>
		<x-basicFrameHeader>
            <h2>
                {{ $user->login }}
                @if($user->is_admin)
                <span class="italic">  (Admin du site) </span>
                @elseif($user->is_banned)
                <span class="italic uppercase"> - Banni -</span>
                @endif
            </h2>
		</x-basicFrameHeader>
		<x-basicFrameContent>
            <article>
                <div class="user-show">
                    <div class="w-100 flex-row justify-center">
                    <img src="{{ asset('storage/' . $user->avatar_path) }}" class="avatar-pict user-photo" alt="{{ $user->login }}"/>
                    </div>
                        <p class="text-green">{{ $user->email }}</p>
                        <p class="text-green">Alias {{ $user->first_name }} {{ $user->last_name }}</p>
                        @if($user->city)
                        <p class="text-green">De {{ $user->city }}</p>
                        @endif
                        <p class="text-green italic">Membre de la communauté depuis le {{ $user->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    @if($user->id === auth()->user()->id)
                    <a href="{{ route('user.edit', $user->id) }}" class="light-button">Modifier mon profil</a>
                    @endif
                </div>


            </article>
        </x-basicFrameContent>
	</section>
</x-layoutLight>

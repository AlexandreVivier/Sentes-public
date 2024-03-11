<div class="user-show">
    <div class="w-100 flex-row justify-center">
    <img src="{{ asset('storage/' . $user->avatar_path) }}" class="avatar-pict user-photo" alt="{{ $user->login }}"/>
    </div>
    @if($user->is_admin || $user->id === auth()->user()->id)
        <p class="text-green">{{ $user->email }}</p>
    @endif
        <p class="text-green">
            Prénom : {{ $user->first_name }}
        </p>
        @if($user->is_admin || $user->id === auth()->user()->id)
        <p class="text-green">
                Nom : {{ $user->last_name }}
        </p>
        @endif
        @if($user->city)
        <p class="text-green">De {{ $user->city }}</p>
        @endif
        <p class="text-green italic">Membre de la communauté depuis le {{ $user->created_at->format('d M Y') }}</p>
</div>

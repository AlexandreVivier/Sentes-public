<article>
    <p class="text-green text-medium">ID: {{ $user->id }}</p>
    <p class="text-green">Login: {{ $user->login }}</p>
    <img src="{{ asset('storage/' . $user->avatar_path) }}" class="w-33 user-photo" alt="{{ $user->login }}"/>
    <p class="text-green">Email: {{ $user->email }}</p>
    <p class="text-green">Nom: {{ $user->last_name }}</p>
    <p class="text-green">Prénom: {{ $user->first_name }}</p>
    <p class="text-green">Ville: {{ $user->city }}</p>
    @if ($user->is_admin)
    <p class="text-green">Rôle: Admin</p>
    @endif
    <p class="text-green">Créé le: {{ $user->created_at->format('d M Y') }}</p>
    <p class="text-green">Dernière modification le: {{ $user->updated_at->format('d M Y') }}</p>

    <div class="show-button-container">
        <div class="w-100">
            <a href="{{ route('admin.users.index') }}" class="light-button">
                Retour
            </a>
        </div>
        <div class="w-100">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="green-button">
                Modifier
            </a>
        </div>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" class="w-100">
            @csrf
            @method('DELETE')
            <button type="submit" class="transparent-button" id="delete">
                Supprimer
            </button>
        </form>
    </div>
</article>

<dialog>
    @include('components.modals.deleteConfirm')
</dialog>

@include('components.scripts.deleteConfirm')


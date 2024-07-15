<section>
    <h1 class="index-title special-elite-regular">Utilisateur id :{{ $user->id }}</h1>
    <div class="flex-row justify-center w-100">
    <p class="text-green"><span class="semi-bold">Pseudo: </span>{{ $user->login }}</p>
    </div>
    @include('components.shows.user', ['user' => $user])
    <p class="text-green italic">Dernière modification le: {{ $user->getFormatedDate($user->updated_at) }}</p>

    <div class="show-button-container">
        <div class="w-100">
            <a href="{{ route('admin.users.index') }}" class="light-button special-elite-regular">
                Retour
            </a>
        </div>
        <div class="w-100">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="green-button special-elite-regular">
                Modifier
            </a>
        </div>
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="post" class="w-100">
            @csrf
            @method('DELETE')
            <button type="submit" class="transparent-button special-elite-regular" id="delete">
                Supprimer
            </button>
        </form>
    </div>
</section>

<dialog>
    @include('components.modals.deleteConfirm')
</dialog>

@include('components.scripts.deleteConfirm')


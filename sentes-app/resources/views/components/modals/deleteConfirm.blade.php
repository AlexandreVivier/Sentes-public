<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title uppercase">
        Attention !
    </h1>
</header>


<main class="text-green">
    <p>
        Tu es sur le point de supprimer un élément de la base de données.
    </p>
    <p>
        Cette action est irréversible.
    </p>

</main>

<footer >
    <div class="show-button-container">

        <div class="w-33">
            <button type="button" class="light-button" onclick="window.history.back()">
                Non
            </button>
        </div>

        @isset($event)
        <form action="{{ route('admin.events.destroy', $event->id) }}" method="post" class="w-33">
            @csrf
            @method('DELETE')
            <button type="submit" class="green-button w-33">
                Oui
            </button>
        </form>
        @endisset
        @isset($user)
        <form action="{{ route('admin.users.destroy', $user->id) }}" method="post"  class="w-33">
            @csrf
            @method('DELETE')
            <button type="submit" class="green-button w-33">
                Oui
            </button>
        </form>
        @endisset
        @isset($location)
        <form action="{{ route('admin.locations.destroy', $location->id) }}" method="post"  class="w-33">
            @csrf
            @method('DELETE')
            <button type="submit" class="green-button w-33">
                Oui
            </button>
        </form>
        @endisset

    </div>
</footer>

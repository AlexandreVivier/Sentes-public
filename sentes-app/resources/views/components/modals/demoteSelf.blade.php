<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title special-elite-regular uppercase">
        Attention {{auth()->user()->login }} !
    </h1>
</header>


<main class="text-green">
    <p>
        Tu es sur le point de quitter l'organisation de ce GN.
    </p>
    <p>
        Seul·e un·e autre orga pourra te rétattribuer ce statut !
    </p>
</main>

<footer >
    <div class="user-button-container">

        <div class="w-50">
            <button type="button" class="light-button special-elite-regular" onclick="window.history.back()">
                Oups, je reste orga du GN.
            </button>
        </div>

        <form action="{{ route('event.organizer.demote.self', $event->id) }}" method="post"  class="w-50">
            @csrf
            @method('PATCH')
            <button type="submit" class="green-button special-elite-regular w-33">
                Je quitte l'organisation
            </button>
        </form>
    </div>
</footer>

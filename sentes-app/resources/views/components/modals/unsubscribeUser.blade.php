<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title special-elite-regular uppercase">
        Attention {{auth()->user()->login }} !
    </h1>
</header>


<main class="text-green">
    <p>
        Tu es sur le point de te désinscrire de ce GN.
    </p>
    <p>
        Tu pourras à tout moment te réinscrire si tu changes d'avis, tes informations sont conservées et disponibles pour les orgas.
    </p>
</main>

<footer >
    <div class="user-button-container">

        <div class="w-50">
            <button type="button" class="light-button special-elite-regular" onclick="window.history.back()">
                Non, je reste inscrit·e.
            </button>
        </div>

        <form action="{{ route('attendee.unsubscribe', $event->id) }}" method="post"  class="w-50">
            @csrf
            @method('DELETE')
            <button type="submit" class="green-button special-elite-regular w-33">
                Oui, je confirme.
            </button>
        </form>
    </div>
</footer>

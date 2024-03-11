<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title uppercase">
        Attention {{auth()->user()->login }} !
    </h1>
</header>


<main class="text-green">
    <p>
        Tu es sur le point de te désinscrire de ce GN.
    </p>
    <p>
        Toutes les informations de ton inscription seront définitivement effacées, comme le paiement de la PàF si tu l'as déjà effectué.
    </p>
    <p>
        N'hésite pas à contacter l'organisation avant de confirmer ta désinscription.
    </p>
    <p>
        Cette action est irréversible !
    </p>
</main>

<footer >
    <div class="user-button-container">

        <div class="w-50">
            <button type="button" class="light-button special-elite-regular" onclick="window.history.back()">
                Je vais y réfléchir.
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
    <p class="text-small italic">
        Il te sera toujours possible de te réinscrire si tu changes d'avis, et reprocéder aux actions que tu avais déjà effectuées.
    </p>
</footer>

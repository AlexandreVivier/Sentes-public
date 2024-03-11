<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title uppercase">
        Attention {{auth()->user()->login }} !
    </h1>
</header>


<main class="text-green">
    <p>
        Tu es sur le point d'annuler ton GN !
    </p>
    <p>
        Le GN ne sera pas effacé mais il ne sera plus visible sur le site.
    </p>
</main>

<footer >
    <div class="user-button-container">

        <div class="w-50">
            <button type="button" class="light-button special-elite-regular" onclick="window.history.back()">
                Non, je me suis trompé.
            </button>
        </div>

        <form action="{{ route('event.cancel', $event->id) }}" method="post"  class="w-50">
            @csrf
            @method('PATCH')
            <button type="submit" class="green-button special-elite-regular w-33">
                Oui, je confirme.
            </button>
        </form>
    </div>
    <p class="text-small italic">
        Avant de recourir à l'annulation, tu peux contacter un admin pour discuter des solutions possibles.
    </p>
</footer>

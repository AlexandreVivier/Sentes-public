<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title special-elite-regular">
        Autoriser les doubles relations pour {{ $event->title }}
    </h1>
</header>

<main class="text-green flex-col justify-center text-center">
    <p>Les doubles relations impliquent que deux personnages sont liés en réservant chacun un emplacement chez l'autre. Cette option est désactivée par défaut.</p>
    <p>Elle peut s'avérer utile pour rendre les relations plus ressérées, intenses ou riches entre les personnages et peuvent donner de la cohérence à l'histoire.</p>
    <p>Attention, cette option peut aussi rendre les relations plus complexes à gérer et à jouer, et réduisent le nombre de relation possibles par personnage.</p>
    <p class="uppercase text-large"> Cette modification est définitive !</p>
</main>

<footer >
    <div class="user-button-container">
        <form method="post" action="{{ route('event.profile.double.link', $event->id) }}" class="w-50">
            @csrf
            @method('PATCH')
            <button type="submit" class="green-button special-elite-regular">
                Autoriser
            </button>
        </form>
        <div class="w-50">
            <button type="button" class="light-button special-elite-regular" onclick="window.history.back()">
                Revenir en arrière
            </button>
        </div>
    </div>
</footer>

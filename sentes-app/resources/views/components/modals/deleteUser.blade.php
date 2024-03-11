<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title uppercase">
        Attention {{$user->login }} !
    </h1>
</header>


<main class="text-green">
    <p>
        Tu es sur le point de supprimer ton compte !
    </p>
    <p>
        Toutes tes données personnelles seront définitivement effacées.
    </p>
    <p>
        Les GN que tu as créés ou auxquels tu as participé, passés et futurs, n'auront plus mention de tes participations.
    </p>
    <p>
        Cette action est irréversible !
    </p>
</main>

<footer >
    <div class="user-button-container">

        <div class="w-50">
            <button type="button" class="light-button special-elite-regular" onclick="window.history.back()">
                Vite, retour en arrère !
            </button>
        </div>

        <form action="{{ route('user.delete', $user->id) }}" method="post"  class="w-50">
            @csrf
            @method('DELETE')
            <button type="submit" class="green-button special-elite-regular w-33">
                Oui, je confirme.
            </button>
        </form>
    </div>
    <p class="text-small italic">
        Si tu veux discuter d'une solution pour suspendre et masquer ton compte/tes infos temporairement, tu peux contacter un admin.
    </p>
</footer>

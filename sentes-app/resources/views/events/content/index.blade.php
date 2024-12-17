<x-layoutDoom>
    <div class="bg-light dashboard-frame border-light flex-col items-center justify-center">
        <div class="flex-row w-75 justify-center">
                <h1 class="index-title special-elite-regular">Menu de création :</h1>
        </div>
        <div class="admin-container">
            <ul class="list-none w-100 flex-wrap justify-center">
                <li class="w-30"><a href="{{ route('archetypes.categories.index')}}" class="transparent-button special-elite-regular">Catégories d'archétypes</a></li>
                <li class="w-30"><a href="{{ route('archetypes.list.index')}}" class="transparent-button special-elite-regular">Archétypes</a></li>
                <li class="w-30"><a href="{{ route('rituals.list.index')}}" class="transparent-button special-elite-regular">Rituels</a></li>
                <li class="w-30"><a href="{{ route('communities.list.index')}}" class="transparent-button special-elite-regular">Communautés</a></li>
                <li class="w-30"><a href="{{ route('backgrounds.list.index')}}" class="transparent-button special-elite-regular">Backgrounds</a></li>
                <li class="w-30"><a href="{{ route('miscellaneous.categories.index')}}" class="transparent-button special-elite-regular">Catégories de listes diverses</a></li>
                <li class="w-30"><a href="{{ route('miscellaneous.list.index')}}" class="transparent-button special-elite-regular">Listes diverses</a></li>
            </ul>
        </div>
        <div class="w-75 show-button-container border-top-down-gradient">
            {{-- <a href="{{ route('event.content.index', $event->id) }}" class="transparent-button special-elite-regular">Retour au GN {{$event->title}}</a> --}}
            <a href="{{ route('user.organisations.index', auth()->user()->id) }}" class="light-button special-elite-regular">Retour à mes organisations</a>
            <a href="{{ route('event.content.creation.index', auth()->user()->id )}}" class="light-button special-elite-regular">Voir tout ce que tu as créé</a>
            <a href="#" class="green-button special-elite-regular">Copier une liste</a>
        </div>
        <div class="w-100 show-button-container">
            {{-- <a href="#" class="green-button special-elite-regular">Créer une liste</a>
            <a href="#" class="green-button special-elite-regular">Créer un item</a> --}}
            {{-- <a href="#" class="green-button special-elite-regular">Copier une liste</a> --}}
        </div>
    </div>
    <div class="h-70vh"></div>
</x-layoutDoom>

<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
    <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">Archétypes de la liste : {{ $archetypeList->name }}</h1>
        <h2 class="index-title special-elite-regular">Catégorie : {{ $archetypeList->category->name }}</h2>
        <p class="special-elite-regular">"{{ $archetypeList->description }}" - par {{ $archetypeList->author->login}}</p>
        <p class="special-elite-regular text-green-light">Si tu es auteurice de cette liste, tu peux ici ajouter, modifier ou supprimer des archétypes.</p>
        @if($archetypes->isEmpty())
        <p class="special-elite-regular">Pas d'archétypes dans cette liste pour le moment.</p>
        @else
        <ul class="list-none w-100 flex-wrap justify-center">
            @foreach ($archetypes as $archetype)
            <li class="w-30 h-max">
                <div class="flex-row form-content-list justify-between h-max">
                    <div class="flex-col w-75">
                        <p class="archetype-title border-light uppercase text-frame-title special-elite-regular">
                            {{ $archetype->name }}
                        </p>
                        <p class="special-elite-regular">
                            {{ $archetype->description }}
                        </p>
                        <p class="special-elite-regular">
                            Premier lien : {{ $archetype->first_link }}
                        </p>
                        <p class="special-elite-regular">
                            Deuxième lien : {{ $archetype->second_link }}
                        </p>
                    </div>
                    @if($archetype->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <div class="w-100 flex-row justify-end gap-1">
                        @if($archetype->author_id == auth()->user()->id)
                        <p class="text-light-green small-text italic">En tant qu'auteurice, tu peux : </p>
                        @else
                        <p class="text-light-green small-text italic">En tant qu'admin, tu peux : </p>
                        @endif
                        <div class="">
                            <a href="{{ route('archetypes.edit', $archetype->id) }}" class="transparent-button special-elite-regular">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                        <form action="{{ route('archetypes.destroy', $archetype->id) }}" method="POST" class="">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transparent-button special-elite-regular ">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </li>
            @endforeach
        </ul>
        @endif
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('event.content.creation') }}" class="light-button special-elite-regular">Retour vers la création de contenus</a>
                <a  href="{{ route('archetypes.list.index')}}" class="light-button special-elite-regular">Retour aux listes d'archétypes</a>
                @if($archetypeList->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <a href="{{ route('archetypes.create', $archetypeList->id) }}" class="green-button special-elite-regular">Ajouter un archétype à la liste {{ $archetypeList->name }}</a>
                @endif
            </div>
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('archetypes.export', $archetypeList->id) }}" class="green-button special-elite-regular">Exporter en CSV</a>
            </div>
        </section>
    </main>
</x-layoutDoom>

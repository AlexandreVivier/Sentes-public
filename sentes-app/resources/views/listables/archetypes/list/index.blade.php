<x-layoutDoom>
    <section class="w-75 flex-col items-center bg-light border-light">
        <h1 class="index-title special-elite-regular">Listes d'archétypes :</h1>
        <h4 class="special-elite-regular">Si tu es auteurice d'une de ces listes, tu peux ici la modifier ou la supprimer.</h4>
        <h4 class="special-elite-regular text-light-green">Attention, cette modification/suppression affectera l'ensemble du site et les personnes / GN qui l'utilisent !</h4>
        @if($archetypeLists->isEmpty())
            <p class="special-elite-regular">Cette liste est vide pour le moment.</p>
        @else
            <ul class="list-none w-50 flex-col">
            @foreach ($archetypeLists as $archetypeList)
                <li>
                    <div class="flex-row">
                        <a href="{{ route('archetypes.list.show', $archetypeList->id) }}" class="transparent-button special-elite-regular uppercase w-50">
                        {{ $archetypeList->name }}
                        @if($archetypeList->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                        @else
                        <span class="special-elite-regular text-small">
                            - par {{ $archetypeList->author->login }}
                        </span>
                        @endif
                        </a>
                        @if(auth()->user()->id == $archetypeList->author_id || Auth::user()->is_admin == 1)
                        <div class="w-25">
                            <a href="{{ route('archetypes.list.edit', $archetypeList->id) }}" class="transparent-button special-elite-regular">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                        <form action="{{ route('archetypes.list.destroy', $archetypeList->id) }}" method="POST" class="w-25">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="transparent-button special-elite-regular w-25">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                </li>
            @endforeach
            </ul>
        @endif
        <div class="w-100 show-button-container border-top-down-gradient">
            <a href="{{ route('archetypes.categories.index') }}" class="light-button special-elite-regular w-100">Voir toutes les catégories</a>
            <a href="{{ route('event.content.creation') }}" class="light-button special-elite-regular w-100">Retour à la création de contenu</a>
            <a href="{{ route('archetypes.list.create') }}" class="green-button special-elite-regular w-100">Créer une liste d'archétypes</a>
        </div>
    </section>
    <div class="h-50vh"></div>
</x-layoutDoom>

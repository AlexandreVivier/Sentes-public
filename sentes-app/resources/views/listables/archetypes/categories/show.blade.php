<x-layoutDoom>
    <section class="w-75 flex-col items-center bg-light border-light">
        <h1 class="index-title special-elite-regular">Listes d'archétypes de "{{$archetypeCategory->name}}" :</h1>
        <h4 class="special-elite-regular">Si tu es auteurice d'une de ces listes, tu peux ici la modifier ou la supprimer.</h4>
        <h4 class="special-elite-regular text-light-green">Attention, cette modification/suppression affectera l'ensemble du site et les personnes / GN qui l'utilisent !</h4>
        @if($archetypeCategories)
        <div x-data="{ show: false }" class="w-75" @click.away="show = false">
            <button class="light-button special-elite-regular dropdown-toggle" @click="show = !show">
                {{ isset($archetypeCategory) ? ucwords($archetypeCategory->name) : 'Par catégorie' }}
                <span class="chevron"><i class="fa-solid fa-chevron-down"></i></span>
            </button>
            <div x-show="show" class="dropdown-list">
                <a href="{{ route('archetypes.list.index') }}" class="text-green text-normal semi-bold none">Toutes les catégories</a>
                @foreach ($archetypeCategories as $archetypeCategory)
                    <a href="{{ route('archetypes.lists.categories.show', $archetypeCategory->id)}}" class="text-green text-normal semi-bold none">
                        {{ $archetypeCategory->name }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif
        @if($archetypeLists->isEmpty())
            <p class="special-elite-regular">Cette liste est vide pour le moment.</p>
        @else
            <ul class="list-none w-50 flex-col">
            @foreach ($archetypeLists as $archetype)
                <li>
                    <div class="flex-row">
                    <a href="{{ route('archetypes.list.show', $archetype->id) }}" class="transparent-button special-elite-regular uppercase w-50">
                        "{{ $archetype->name }}"
                        @if($archetype->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                        @else
                        <span class="special-elite-regular text-small">
                            - par
                             {{ $archetype->author->login }}
                        </span>
                        @endif
                    </a>
                    @if($archetype->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <div class="w-25">
                        <a href="{{ route('archetypes.list.edit', $archetype->id) }}" class="transparent-button special-elite-regular">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </div>
                    <form action="{{ route('archetypes.list.destroy', $archetype->id) }}" method="POST" class="w-25">
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
        <div class="w-75 show-button-container border-top-down-gradient">
            <a href="{{ route('archetypes.list.index') }}" class="light-button special-elite-regular">Voir toutes les listes d'archétypes</a>
            <a href="{{ route('archetypes.categories.index') }}" class="light-button special-elite-regular">Retour aux catégories d'archétypes</a>
        </div>
        <div class="w-75 show-button-container border-top-down-gradient">
            {{-- <a href="{{ route('user.organisations.index', auth()->user()->id) }}" class="light-button special-elite-regular">Retour à mes organisations</a> --}}
            <a href="{{ route('event.content.creation') }}" class="light-button special-elite-regular">Retour vers la création de contenus</a>
            <a href="{{ route('archetypes.list.create') }}" class="green-button special-elite-regular">Créer une nouvelle liste d'archétypes</a>
        </div>
    </section>
</x-layoutDoom>

<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
    <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">Eléments de la liste diverse {{$miscellaneousList->name }} :</h1>
        <h2 class="special-elite-regular text-green">Catégorie : {{$miscellaneousList->miscellaneousCategory->name}}</h2>
        <p class="special-elite-regular text-large text-green italic">"{{$miscellaneousList->description}}" - par {{$miscellaneousList->author->login}}</p>
        <p class="special-elite-regular text-green-light">Si tu es auteurice de cette liste, tu peux ici ajouter, modifier ou supprimer des éléments.</p>
        @if($miscellaneous->isEmpty())
        <p class="special-elite-regular">La liste {{$miscellaneousList->name}} ne contient aucun éléments pour le moment.</p>
        @else
        <ul class="list-none w-100 flex-wrap justify-center">
            @foreach ($miscellaneous as $miscellaneous)
            <li class="w-30 h-max">
                <div class="flex-row form-content-list justify-between h-max">
                    <div class="flex-col w-75">
                        <p class="archetype-title border-light uppercase text-frame-title special-elite-regular">
                            N°{{ $loop->iteration }}
                        </p>
                        <p class="special-elite-regular">
                            {{ $miscellaneous->description }}
                        </p>
                    </div>
                    @if($miscellaneous->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <div class="w-100 flex-row justify-end gap-1">
                        @if($miscellaneous->author_id == auth()->user()->id)
                        <p class="text-light-green small-text italic">En tant qu'auteurice, tu peux : </p>
                        @else
                        <p class="text-light-green small-text italic">En tant qu'admin, tu peux : </p>
                        @endif
                        <div class="">
                            <a href="{{ route('miscellaneous.edit', $miscellaneous->id) }}" class="transparent-button special-elite-regular">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                        <form action="{{ route('miscellaneous.destroy', $miscellaneous->id) }}" method="POST" class="">
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
                <a  href="{{ route('miscellaneous.list.index')}}" class="light-button special-elite-regular">Retour aux listes diverses</a>
                @if($miscellaneousList->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <a href="{{ route('miscellaneous.create', $miscellaneousList->id) }}" class="green-button special-elite-regular">Ajouter un élément à la liste {{ $miscellaneousList->name }}</a>
                @endif
            </div>
        </section>
    </main>
</x-layoutDoom>

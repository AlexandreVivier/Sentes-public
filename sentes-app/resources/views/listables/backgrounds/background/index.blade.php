<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Backgrounds de la liste {{$backgroundList->name}}</h1>
            <p class="special-elite-regular text-large text-green italic">"{{$backgroundList->description}}" - par {{$backgroundList->author->login}}</p>
            <p class="special-elite-regular text-green-light">Si tu es auteurice de cette liste, tu peux ici ajouter, modifier ou supprimer des backgrounds.</p>
            @if($backgrounds->isEmpty())
                <p class="special-elite-regular">La liste {{$backgroundList->name}} ne contient aucun background pour le moment.</p>
            @else
                <ul class="list-none w-100 flex-wrap justify-center">
                    @foreach ($backgrounds as $background)
                        <li class="w-75 h-max">
                            <div class="flex-row form-content-list justify-between h-max">
                                <div class="flex-col w-75">
                                    <p class="archetype-title border-light uppercase text-frame-title special-elite-regular">
                                        N°{{ $loop->iteration }} -
                                        {{ $background->name }}
                                    </p>
                                    <p class="special-elite-regular">
                                        {{ $background->description }}
                                    </p>
                                </div>
                                @if($background->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                                    <div class="w-100 flex-row justify-end gap-1">
                                        @if($background->author_id == auth()->user()->id)
                                        <p class="text-light-green small-text italic">En tant qu'auteurice, tu peux : </p>
                                        @else
                                        <p class="text-light-green small-text italic">En tant qu'admin, tu peux : </p>
                                        @endif
                                        <div class="">
                                            <a href="{{ route('backgrounds.edit', $background->id) }}" class="transparent-button special-elite-regular">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                        </div>
                                        <form action="{{ route('backgrounds.destroy', $background->id) }}" method="POST" class="">
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
                <a href="{{ route('backgrounds.list.index')}}" class="light-button special-elite-regular">Retour aux listes de background</a>
                @if($backgroundList->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <a href="{{ route('backgrounds.create', $backgroundList->id) }}" class="green-button special-elite-regular">Ajouter un background à la liste {{ $backgroundList->name }}</a>
                @endif
            </div>
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('backgrounds.export', $backgroundList->id) }}" class="green-button special-elite-regular">Exporter en CSV</a>
            </div>
        </section>
    </main>
</x-layoutDoom>

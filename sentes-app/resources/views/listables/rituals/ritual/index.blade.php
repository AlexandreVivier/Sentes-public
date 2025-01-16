<x-layoutDark>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
    <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">rituels de la liste {{$ritualList->name }} :</h1>
        <p class="special-elite-regular text-large text-green italic">"{{$ritualList->description}}" - par {{$ritualList->author->login}}</p>
        <p class="special-elite-regular text-green-light">Si tu es auteurice de cette liste, tu peux ici ajouter, modifier ou supprimer des rituels.</p>
        @if($rituals->isEmpty())
        <p class="special-elite-regular">La liste {{$ritualList->name}} ne contient aucun rituels pour le moment.</p>
        @else
        <ul class="list-none w-100 flex-wrap justify-center">
            @foreach ($rituals as $ritual)
            <li class="w-30 h-max">
                <div class="flex-row form-content-list justify-between h-max">
                    <div class="flex-col w-75">
                        <p class="archetype-title border-light uppercase text-frame-title special-elite-regular">
                            N°{{ $loop->iteration }} -
                            {{ $ritual->name }}
                        </p>
                        <p class="special-elite-regular">
                            {{ $ritual->description }}
                        </p>
                    </div>
                    @if($ritual->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <div class="w-100 flex-row justify-end gap-1">
                        @if($ritual->author_id == auth()->user()->id)
                        <p class="text-light-green small-text italic">En tant qu'auteurice, tu peux : </p>
                        @else
                        <p class="text-light-green small-text italic">En tant qu'admin, tu peux : </p>
                        @endif
                        <div class="">
                            <a href="{{ route('rituals.edit', $ritual->id) }}" class="transparent-button special-elite-regular">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </div>
                        <form action="{{ route('rituals.destroy', $ritual->id) }}" method="POST" class="">
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
                <a href="{{ route('rituals.list.index')}}" class="light-button special-elite-regular">Retour aux listes de rituel</a>
                @if($ritualList->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                    <a href="{{ route('rituals.create', $ritualList->id) }}" class="green-button special-elite-regular">Ajouter un rituel à la liste {{ $ritualList->name }}</a>
                @endif
            </div>
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('rituals.export', $ritualList->id) }}" class="green-button special-elite-regular">Exporter en CSV</a>
            </div>
        </section>
    </main>
</x-layoutDark>

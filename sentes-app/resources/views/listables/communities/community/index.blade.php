<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Communautés de la liste {{$communityList->name}}</h1>
            <p class="special-elite-regular text-large text-green italic">"{{$communityList->description}}" - par {{$communityList->author->login}}</p>
            <p class="special-elite-regular text-green-light">Si tu es auteurice de cette liste, tu peux ici ajouter, modifier ou supprimer des rituels.</p>
            @if($communities->isEmpty())
            <p class="special-elite-regular">La liste {{$communityList->name}} ne contient aucune communauté pour le moment.</p>
            @else
            <ul class="list-none w-100 flex-wrap justify-center">
                @foreach ($communities as $community)
                <li class="w-45 h-max">
                    <div class="flex-row form-content-list justify-between h-max">
                        <div class="flex-col w-75">
                            <p class="archetype-title border-light uppercase text-frame-title special-elite-regular">
                                N°{{ $loop->iteration }} -
                                {{ $community->name }}
                            </p>
                            <p class="special-elite-regular">
                                {{ $community->description }}
                            </p>
                            @if($community->individual)
                            <div class="archetype-item">
                                <p>
                                    <span class="italic text-light-green">
                                        face à un individu :
                                    </span>
                                    <span class="special-elite-regular">
                                        {{ $community->individual }}
                                    </span>
                                </p>
                            </div>
                            @endif
                            @if($community->group)
                            <div class="archetype-item">
                                <p>
                                    <span class="italic text-light-green">
                                        face à un groupe :
                                    </span>
                                    <span class="special-elite-regular">
                                        {{ $community->group }}
                                    </span>
                                </p>
                            </div>
                            @endif
                            @if($community->perspectives)
                            <div class="archetype-item">
                                <p>
                                    <span class="italic text-light-green">
                                        perspectives :
                                    </span>
                                    <span class="special-elite-regular">
                                        {{ $community->perspectives }}
                                    </span>
                                </p>
                            </div>
                            @endif
                            @if($community->highlights)
                            <div class="archetype-item">
                                <p>
                                    <span class="italic text-light-green">
                                        temps forts :
                                    </span>
                                    <span class="special-elite-regular">
                                        {{ $community->highlights }}
                                    </span>
                                </p>
                            @endif
                        </div>
                        @if($community->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                        <div class="w-100 flex-row justify-end gap-1">
                            @if($community->author_id == auth()->user()->id)
                            <p class="text-light-green small-text italic">En tant qu'auteurice, tu peux : </p>
                            @else
                            <p class="text-light-green small-text italic">En tant qu'admin, tu peux : </p>
                            @endif
                            <div class="">
                                <a href="{{ route('communities.edit', $community->id) }}" class="transparent-button special-elite-regular">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                            </div>
                            <form action="{{ route('communities.destroy', $community->id) }}" method="POST" class="">
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
                    <a  href="{{ route('communities.list.index')}}" class="light-button special-elite-regular">Retour aux listes de communautés</a>
                    @if($communityList->author_id == auth()->user()->id || Auth::user()->is_admin == 1)
                        <a href="{{ route('communities.create', $communityList->id) }}" class="green-button special-elite-regular">Ajouter une communauté à la liste {{ $communityList->name }}</a>
                    @endif
                </div>
            </section>
        </main>
    </x-layoutDoom>

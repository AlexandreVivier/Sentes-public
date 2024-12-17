<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title special-elite-regular">
        Voir tout le contenu de {{ $list->name }}
    </h1>
</header>

<main class="text-green">
    <div class="wrapper">
                    <h1 class="index-title special-elite-regular">Archétypes de la liste : {{ $list->name }}</h1>
                    <p class="">
                        <span class="italic special-elite-regular">"{{ $list->description }}"</span>
                        <span class="text-small special-elite-regular"> - par {{ $list->author->login }}</span>
                    </p>
                @if($list->archetypes->count() > 0)
                <div class="archetype-container">
                    @foreach ($list->archetypes as $archetype)
                        <div class="archetype-box">
                            <h2 class="archetype-title border-light uppercase text-frame-title special-elite-regular">
                                N°{{ $loop->iteration }} -
                                {{ $archetype->name }}
                            </h2>
                            <div class="archetype-item">
                                <p>
                                    <span class="uppercase text-small">
                                        description :
                                    </span>
                                    <span class="italic">
                                        {{ $archetype->description }}
                                    </span>
                                </p>
                            </div>
                            <div class="archetype-item">
                                <p>
                                    <span class="uppercase text-small">
                                        premier lien :
                                    </span>
                                    <span class="italic">
                                        {{ $archetype->first_link }}
                                    </span>
                                </p>
                            </div>
                            <div class="archetype-item">
                               <p>
                                    <span class="uppercase text-small">
                                        deuxième lien :
                                    </span>
                                    <span class="italic">
                                        {{ $archetype->second_link }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="italic special-elite-regular">Pas d'archétypes dans cette liste pour le moment.</p>
                @endif
                {{-- @break
            @case('rituels')
                <h1 class="index-title special-elite-regular">Rituels de la liste : {{ $list->name }}</h1>
                <p class="italic special-elite-regular">"{{ $list->description }}"</p>
                @if($list->rituals->count() > 0)
                <div class="archetype-container">
                    @foreach ($list->rituals as $ritual)
                        <div class="archetype-box">
                            <h2 class="archetype-title border-light uppercase text-frame-title special-elite-regular">{{ $ritual->name }}</h2>
                            <p class="archetype-item">{{ $ritual->description }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="italic special-elite-regular">Pas de rituels dans cette liste pour le moment.</p>
                @endif
                @break
            @case('communautés')
                <h1 class="index-title special-elite-regular">Communautés de la liste : {{ $list->name }}</h1>
                <p class="italic special-elite-regular">"{{ $list->description }}"</p>
                @if($list->communities->count() > 0)
                <div class="archetype-container">
                    @foreach ($list->communities as $community)
                        <div class="archetype-box">
                            <h2 class="archetype-title border-light uppercase text-frame-title special-elite-regular">{{ $community->name }}</h2>
                            <p class="archetype-item">{{ $community->description }}</p>
                            <p class="archetype-item">{{ $community->individual }}</p>
                            <p class="archetype-item">{{ $community->group }}</p>
                            <p class="archetype-item">{{ $community->perspectives }}</p>
                        </div>
                    @endforeach
                @else
                    <p class="italic special-elite-regular">Pas de communautés dans cette liste pour le moment.</p>
                @endif
                @break
        @endswitch --}}
    </div>
</main>

<footer >
    <div class="user-button-container">
        <div class="w-50">
            <a href="{{ route('event.content.index', $event->id) }}" class="light-button special-elite-regular">
                Retour
            </a>
        </div>
    </div>
</footer>

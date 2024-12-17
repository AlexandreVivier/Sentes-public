<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title special-elite-regular">
        Voir tout le contenu de {{ $list->name }}
    </h1>
</header>

<main class="text-green">
    <div class="wrapper">
        <h1 class="index-title special-elite-regular">Communautés de la liste : {{ $list->name }}</h1>
        <p class="">
            <span class="italic special-elite-regular">"{{ $list->description }}"</span>
            <span class="text-small special-elite-regular"> - par {{ $list->author->login }}</span>
        </p>
                @if($list->communities->count() > 0)
                <div class="archetype-container">
                    @foreach ($list->communities as $community)
                        <div class="archetype-box">
                            <h2 class="archetype-title border-light uppercase text-frame-title special-elite-regular">
                                N°{{ $loop->iteration }} -
                                {{ $community->name }}</h2>
                            <div class="archetype-item">
                                <p>
                                    <span class="uppercase text-small">
                                        description :
                                    </span>
                                    <span class="italic">
                                        {{ $community->description }}
                                    </span>
                                </p>
                            </div>
                            <div class="archetype-item">
                                <p>
                                    <span class="uppercase text-small">
                                        face à un groupe :
                                    </span>
                                    <span class="italic">
                                        {{ $community->group }}
                                    </span>
                                </p>
                            </div>
                            <div class="archetype-item">
                                <p>
                                    <span class="uppercase text-small">
                                        face à un individu :
                                    </span>
                                    <span class="italic">
                                        {{ $community->individual }}
                                    </span>
                                </p>
                            </div>
                            <div class="archetype-item">
                                <p>
                                    <span class="uppercase text-small">
                                        perspectives :
                                    </span>
                                    <span class="italic">
                                        {{ $community->perspectives }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="italic special-elite-regular">Pas de communautés dans cette liste pour le moment.</p>
                @endif
                </div>
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

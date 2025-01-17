<x-layoutDark>
    <main class="event-frame-content bg-light border-light text-green justify-center flex-col w-100 items-center">
        <h1 class="text-green special-elite-regular text-center">{{ $event->title }} - Contenu du jeu</h1>
            <section class="w-75 justify-around flex-row content-responsive-wrapper">
                <div class="w-100 flex-col">
                    <h2 class="text-green special-elite-regular">Tables de contenus pour le GN :</h2>
                    <div class="flex-row justify-center">
                @if($contents->isEmpty())
                    <p class="text-center italic">Aucun contenu n'a été créé pour ce GN.</p>
                @else
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>Titre :</th>
                            <th class="td-mobile-none">Description :</th>
                            <th>Contenu :</th>
                            <th class="td-mobile-none">Catégorie / famille :</th>
                            <th class="td-mobile-none">Unicité :</th>
                            <th>Actions :</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contents as $content)
                            <tr>
                                <td>
                                    <span class="uppercase">
                                        {{ $content->title }}
                                    </span>
                                </td>
                                <td class="td-mobile-none">
                                    <span class="italic">
                                        {{ $content->description }}
                                    </span>
                                 </td>
                                <td>
                                    @switch($content->type)
                                        @case('archetypes')
                                            @if($content->archetypeLists->isEmpty())
                                            <span class="italic text-light-green">Aucun contenu n'a été ajouté à cette table.</span>
                                            @else
                                            @foreach($content->archetypeLists as $list)
                                                <a href="#" id="seeAllArch-{{$list->id}}" class="text-green special-elite-regular event-link link none semi-bold uppercase">
                                                    {{ $list->name }}{{ $loop->last ? '' : ' / ' }}
                                                </a>
                                            @endforeach
                                            @endif
                                        @break
                                        @case('rituels')
                                            @if($content->ritualLists->isEmpty())
                                            <span class="italic text-light-green">Aucun contenu n'a été ajouté à cette table.</span>
                                            @else
                                            @foreach($content->ritualLists as $list)
                                                <a href="#" id="seeAllRit-{{$list->id}}" class="text-green special-elite-regular event-link link none semi-bold uppercase">
                                                    {{ $list->name }}{{ $loop->last ? '' : ' / ' }}
                                                </a>
                                            @endforeach
                                            @endif
                                        @break
                                        @case('communautés')
                                            @if($content->communityLists->isEmpty())
                                            <span class="italic text-light-green">Aucun contenu n'a été ajouté à cette table.</span>
                                            @else
                                            @foreach($content->communityLists as $list)
                                                <a href="#" id="seeAllComm-{{$list->id}}" class="text-green special-elite-regular event-link link none semi-bold uppercase">
                                                    {{ $list->name }}{{ $loop->last ? '' : ' / ' }}
                                                </a>
                                            @endforeach
                                            @endif
                                        @break
                                        @case('backgrounds')
                                            @if($content->backgroundLists->isEmpty())
                                            <span class="italic text-light-green">Aucun contenu n'a été ajouté à cette table.</span>
                                            @else
                                            @foreach($content->backgroundLists as $list)
                                                <a href="#" id="seeAllBack-{{$list->id}}" class="text-green special-elite-regular event-link link none semi-bold uppercase">
                                                    {{ $list->name }}{{ $loop->last ? '' : ' / ' }}
                                                </a>
                                            @endforeach
                                            @endif
                                        @break
                                        @case('miscellaneous')
                                            @if($content->miscellaneousLists->isEmpty())
                                            <span class="italic text-light-green">Aucun contenu n'a été ajouté à cette table.</span>
                                            @else
                                            @foreach($content->miscellaneousLists as $list)
                                                <a href="#" id="seeAllMisc-{{$list->id}}" class="text-green special-elite-regular event-link link none semi-bold uppercase">
                                                    {{ $list->name }}{{ $loop->last ? '' : ' / ' }}
                                                </a>
                                            @endforeach
                                            @endif
                                        @break
                                    @endswitch
                                </td>
                                <td class="td-mobile-none">
                                    <span class="text-green special-elite-regular uppercase">
                                        {{ $content->type }}
                                    </span>
                                </td>
                                <td class="td-mobile-none">
                                    @if($content->is_unique == 1)
                                        <span class="text-green special-elite-regular">Oui</span>
                                    @else
                                        <span class="text-green special-elite-regular">Non</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex-row justify-center gap-1">
                                        <button id="assignList-{{ $content->id }}" class="transparent-button chip-large special-elite-regular">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                        <form method="post" action="{{ route('event.content.destroy', [$event->id, $content->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="transparent-button chip-large special-elite-regular">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
                    </div>
                    <h2 class="text-green special-elite-regular">Actions de publication / autorisations :</h2>
                    <div class="w-100 show-button-container">
                        @if(!$event->profile->published)
                        <form method="post" action="{{ route('event.profile.publish', $event->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="green-button special-elite-regular">Publier le GN</button>
                        </form>
                        @endif
                        @if(!$event->profile->subscribing)
                        <form method="post" action="{{ route('event.profile.registrations', $event->id) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="light-button special-elite-regular">Ouvrir les inscriptions</button>
                        </form>
                        @endif
                    </div>
                    @if($event->profile->subscribing)
                    <div class="w-100 show-button-container flex-wrap">
                        <form method="post" action="{{ route('event.profile.character.creation', $event->id) }}" class="w-25">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="light-button special-elite-regular">
                                @if(!$event->profile->character_creation)
                                Ouvrir la création de personnages
                                @else
                                Fermer la création de personnages
                                @endif
                            </button>
                        </form>
                        <form method="post" action="{{ route('event.profile.character.relations', $event->id) }}" class="w-33">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="light-button special-elite-regular">
                                @if(!$event->profile->character_relation)
                                Ouvrir les relations de personnages
                                @else
                                Fermer les relations de personnages
                                @endif
                            </button>
                        </form>
                        @if(!$event->profile->double_relation && $event->profile->character_relation)
                        <div class="w-25">
                            <button id="double" class="light-button special-elite-regular">
                                Autoriser les double liens
                            </button>
                        </div>
                        @endif
                    </div>
                    @if($event->profile->double_relation)
                    <p class="text-center italic">Les double liens sont autorisés pour ce GN.</p>
                    @endif
                    @endif
            </div>
            <div class="w-100 flex-row justify-center">
                <form method="post" class="w-100 " action="{{ route('event.content.store', $event->id) }}" >
                    @csrf
                    @method('POST')
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="form-content w-100 bg-light border-light">
                        <h4 class="text-green special-elite-regular">
                            Ajouter une table de contenu :
                        </h4>
                        <div class="form-input">
                            <label for="title" class="text-shadowed">
                                Titre de la nouvelle table :
                            </label>
                            <input type="text" name="title" id="title">
                        </div>
                        <div class="form-input">
                            <label for="description" class="text-shadowed">
                                Description publique :
                            </label>
                            <input type="text" name="description" id="description">
                        </div>
                        <div class="form-input">
                            <label for="content" class="text-shadowed">
                                Catégorie / famille de la table :
                            </label>
                            <select name="type" id="type">
                                <option value="archetypes">Archétypes Sentes</option>
                                <option value="rituels">Rituels</option>
                                <option value="communautés">Communautés</option>
                                <option value="backgrounds">Backgrounds</option>
                                <option value="miscellaneous">Divers</option>
                            </select>
                        </div>
                        <div class="flex-row justify-around">
                        <div class="form-check">
                            <label for="is_unique" class="text-shadowed">
                                Eléments de contenu uniques ?
                            </label>
                            <input type="checkbox" name="is_unique" id="is_unique" value="1">
                        </div>
                        <div class="form-check">
                            <label for="is_public" class="text-shadowed">
                                Table visible pour les joueurs ?
                            </label>
                            <input type="checkbox" name="is_visible" id="is_visible" value="1" checked required>
                        </div>
                        </div>
                        <div class="flex-row justify-around">
                        <div class="form-input">
                            <label for="number_of_selections" class="text-shadowed">
                                Nombre de fois ou cet élément sera sélectionnable par les PJ:
                            </label>
                            <input type="number" name="number_of_selections" id="number_of_selections" value="1" required>
                        </div>
                        <div class="form-input">
                            <label for="max_selections" class="text-shadowed text-light-green">
                                Nombre max de sélections de l'élément par les PJ (optionnel) :
                            </label>
                            <input type="number" name="max_selections" id="max_selections">
                        </div>
                        </div>
                        <button type="submit" class="transparent-button special-elite-regular w-50">Ajouter au GN</button>
                    </div>
                </form>
            </div>
            </section>
            <section class="w-75">
                <div class="w-100 show-button-container">
                    <a href="{{ route('events.show', $event->id) }}" class="light-button special-elite-regular">Retour au GN</a>
                    <a href="{{ route('event.content.creation')}}" class="green-button special-elite-regular">Création de contenus</a>
                </div>
            </section>
    </main>
    @foreach($contents as $content)
    <dialog id="assignListToContent-{{ $content->id }}">
        @switch($content->type)
            @case('archetypes')
                @include('components.modals.assignListToContent', ['content' => $content, 'event' => $event, 'lists' => $allArchetypes])
                @break
            @case('rituels')
                @include('components.modals.assignListToContent', ['content' => $content, 'event' => $event, 'lists' => $allRituals])
                @break
            @case('communautés')
                @include('components.modals.assignListToContent', ['content' => $content, 'event' => $event, 'lists' => $allCommunities])
                @break
            @case('backgrounds')
                @include('components.modals.assignListToContent', ['content' => $content, 'event' => $event, 'lists' => $allBackgrounds])
                @break
            @case('miscellaneous')
                @include('components.modals.assignListToContent', ['content' => $content, 'event' => $event, 'lists' => $allMiscellaneous])
                @break
        @endswitch
    </dialog>
    @endforeach
    <dialog id="doubleLink">
        @include('components.modals.doubleLink', ['event' => $event])
    </dialog>
    @if($contents->isNotEmpty())
    @foreach($contents as $content)
    @switch($content->type)
    @case('archetypes')
        @foreach($content->archetypeLists as $list)
        <dialog id="seeAllArchetypes-{{ $list->id }}">
            @include('components.modals.seeAllArchetypes', ['list' => $list, 'content' => $content, 'event' => $event])
        </dialog>
        @endforeach
        @break
    @case('rituels')
        @foreach($content->ritualLists as $list)
        <dialog id="seeAllRituals-{{ $list->id }}">
            @include('components.modals.seeAllRituals', ['list' => $list, 'content' => $content, 'event' => $event])
        </dialog>
        @endforeach
        @break
    @case('communautés')
        @foreach($content->communityLists as $list)
        <dialog id="seeAllCommunities-{{ $list->id }}">
            @include('components.modals.seeAllCommunities', ['list' => $list, 'content' => $content, 'event' => $event])
        </dialog>
        @endforeach
        @break
    @case('backgrounds')
        @foreach($content->backgroundLists as $list)
        <dialog id="seeAllBackgrounds-{{ $list->id }}">
            @include('components.modals.seeAllBackgrounds', ['list' => $list, 'content' => $content, 'event' => $event])
        </dialog>
        @endforeach
        @break
    @case('miscellaneous')
        @foreach($content->miscellaneousLists as $list)
        <dialog id="seeAllMiscellaneouses-{{ $list->id }}">
            @include('components.modals.seeAllMiscellaneouses', ['list' => $list, 'content' => $content, 'event' => $event])
        </dialog>
        @endforeach
        @break
    @endswitch
    @endforeach
    @endif
    @include('components.scripts.assigntListToContent')
    @include('components.scripts.seeAllArchetypes')
    @include('components.scripts.seeAllRituals')
    @include('components.scripts.seeAllCommunities')
    @include('components.scripts.seeAllBackgrounds')
    @include('components.scripts.seeAllMiscellaneouses')
    @include('components.scripts.doubleLink')
</x-layoutDark>

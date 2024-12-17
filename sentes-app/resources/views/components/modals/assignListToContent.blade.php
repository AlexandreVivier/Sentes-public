<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title special-elite-regular">
        Assigner une liste au contenu {{ $content->title }} du GN {{ $event->title }}
    </h1>
</header>

<main class="text-green">
    <p>
        Listes de
        <span class="uppercase special-elite-regular">
            "{{ $content->type }}"
        </span>
        disponibles pour le GN {{ $event->title }} :
    </p>
    <form action="{{ route('content.table.update', [$event->id, $content->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-content w-100 bg-light border-light">
            <div class="form-input">
                <label for="listable_id" class="text-shadowed">
                    Liste(s) à assigner :
                </label>
                @switch($content->type)
                    @case('archetypes')
                        <select name="listable_id[]" id="listable_id" multiple>
                            @foreach ($lists as $list)
                                <option value="{{ $list->id }}"
                                    {{ $content->archetypeLists->contains($list) ? 'selected' : '' }} class="text-medium select-border-top special-elite-regular">
                                    <span class="uppercase">
                                        {{ $list->name }}
                                    </span>
                                    <span class="italic">
                                         - ({{ $list->category->name }})
                                    </span>
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="listable_type" value="App\Models\ArchetypeList">
                        @break
                    @case('rituels')
                        <select name="listable_id[]" id="listable_id" multiple>
                            @foreach ($lists as $list)
                                <option value="{{ $list->id }}"
                                    {{ $content->ritualLists->contains($list) ? 'selected' : '' }} class="text-medium select-border-top uppercase special-elite-regular">
                                    {{ $list->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="listable_type" value="App\Models\RitualList">
                        @break
                    @case('communautés')
                        <select name="listable_id[]" id="listable_id" multiple>
                            @foreach ($lists as $list)
                                <option value="{{ $list->id }}"
                                    {{ $content->communityLists->contains($list) ? 'selected' : '' }} class="text-medium select-border-top uppercase special-elite-regular">
                                    {{ $list->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="listable_type" value="App\Models\CommunityList">
                        @break
                    @case('backgrounds')
                        <select name="listable_id[]" id="listable_id" multiple>
                            @foreach ($lists as $list)
                                <option value="{{ $list->id }}"
                                    {{ $content->backgroundLists->contains($list) ? 'selected' : '' }} class="text-medium select-border-top uppercase special-elite-regular">
                                    {{ $list->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="listable_type" value="App\Models\BackgroundList">
                        @break
                    @case('miscellaneous')
                        <select name="listable_id[]" id="listable_id" multiple>
                            @foreach ($lists as $list)
                                <option value="{{ $list->id }}"
                                    {{ $content->miscellaneousLists->contains($list) ? 'selected' : '' }} class="text-medium select-border-top uppercase special-elite-regular">
                                    {{ $list->name }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="listable_type" value="App\Models\MiscellaneousList">
                        @break
                        @default
                        <p class="italic special-elite-regular">Pas de listes disponibles pour ce type de contenu.</p>
                    @endswitch
            </div>
            <input type="hidden" name="content_id" value="{{ $content->id }}">
            <div class="w-50">
            <button type="submit" class="green-button special-elite-regular w-50">
                Ajouter au contenu
            </button>
            </div>
        </div>
    </form>
</main>

<footer >
    <div class="user-button-container">
        <div class="w-50">
            <a href="{{ route('event.content.index', $event->id) }}" class="light-button special-elite-regular">
                Annuler
            </a>
        </div>
    </div>
</footer>

<x-layoutDoom>
    <div class="bg-light dashboard-frame border-light  flex-col items-center justify-center">
        <div class="flex-row w-75 justify-center">
                <h1 class="index-title special-elite-regular">Contenus créés par {{$user->login}} </h1>
        </div>
        <div class="w-75 justify-center items-center flex-col">
            <div class="form-content-list border-light bg-light">
            <h4 class="special-elite-regular text-green text-large">Catégories d'archétypes :</h4>

            @if($userArchetypesCategories->isEmpty() && $user->id == auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">Tu n'as créé aucune catégorie d'archétype.</p>
            @elseif($userArchetypesCategories->isEmpty() && $user->id != auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">{{$user->login}} n'a créé aucune catégorie d'archétype.</p>
            @else
                <ul class="w-100">
                    @foreach($userArchetypesCategories as $category)
                        <li class="w-90 flex-row justify-center">
                            <div class="w-75">
                                <a href="{{ route('archetypes.lists.categories.show', $category->id) }}" class="light-button special-elite-regular">
                                    {{$category->name}}
                                </a>
                            </div>
                            @if($category->author_id == auth()->user()->id)
                            <div class="w-25 flex-row">
                                <div class="w-25">
                                    <a href="{{ route('archetypes.categories.edit', $category->id) }}" class="light-button text-medium">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="w-25">
                                    <form action="{{ route('archetypes.categories.destroy', $category->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="light-button text-medium special-elite-regular">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
            </div>
        </div>
        <div class="w-75 justify-center items-center flex-col">
            <h4 class="special-elite-regular text-green text-large">Archétypes :</h4>
            <div class="form-content-list border-light bg-light">
            @if($userArchetypes->isEmpty() && $user->id == auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">Tu n'as créé aucun archétype.</p>
            @elseif($userArchetypes->isEmpty() && $user->id != auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">{{$user->login}} n'a créé aucun archétype.</p>
            @else
                <ul class="w-100">
                    @foreach($userArchetypes as $archetype)
                        <li class="w-90 flex-row justify-center">
                            <div class="w-75">
                                <a href="{{ route('archetypes.list.show', $archetype->id) }}" class="light-button special-elite-regular">
                                    {{$archetype->name}} - <span class="text-light-green special-elite-regular italic">({{$archetype->category->name}})</span>
                                </a>
                            </div>
                            @if($archetype->author_id == auth()->user()->id)
                            <div class="w-25 flex-row">
                                <div class="w-25">
                                    <a href="{{ route('archetypes.list.edit', $archetype->id) }}" class="light-button text-medium">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="w-25">
                                    <form action="{{ route('archetypes.list.destroy', $archetype->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="light-button text-medium special-elite-regular">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif
            </div>
        </div>
        <div class="w-75 justify-center items-center flex-col">
            <h4 class="special-elite-regular text-green text-large">Rituels :</h4>
            <div class="form-content-list border-light bg-light">
            @if($userRituals->isEmpty() && $user->id == auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">Tu n'as créé aucun rituel.</p>
            @elseif($userRituals->isEmpty() && $user->id != auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">{{$user->login}} n'a créé aucun rituel.</p>
            @else
            <ul class="w-100">
                @foreach($userRituals as $ritual)
                    <li class="w-90 flex-row justify-center">
                        <div class="w-75">
                            <a href="{{ route('rituals.list.show', $ritual->id) }}" class="light-button special-elite-regular">
                                {{$ritual->name}}
                            </a>
                        </div>
                        @if($ritual->author_id == auth()->user()->id)
                        <div class="w-25 flex-row">
                            <div class="w-25">
                                <a href="{{ route('rituals.list.edit', $ritual->id) }}" class="light-button text-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="w-25">
                                <form action="{{ route('rituals.list.destroy', $ritual->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="light-button text-medium special-elite-regular">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            @endif
            </div>
        </div>
        <div class="w-75 justify-center items-center flex-col">
            <h4 class="special-elite-regular text-green text-large">Communautés :</h4>
            <div class="form-content-list border-light bg-light">
            @if($userCommunities->isEmpty() && $user->id == auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">Tu n'as créé aucune communauté.</p>
            @elseif($userCommunities->isEmpty() && $user->id != auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">{{$user->login}} n'a créé aucune communauté.</p>
            @else
            <ul class="w-100">
                @foreach($userCommunities as $community)
                    <li class="w-90 flex-row justify-center">
                        <div class="w-75">
                            <a href="{{ route('communities.list.show', $community->id) }}" class="light-button special-elite-regular">
                                {{$community->name}}
                            </a>
                        </div>
                        @if($community->author_id == auth()->user()->id)
                        <div class="w-25 flex-row">
                            <div class="w-25">
                                <a href="{{ route('communities.list.edit', $community->id) }}" class="light-button text-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="w-25">
                                <form action="{{ route('communities.list.destroy', $community->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="light-button text-medium special-elite-regular">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            @endif
            </div>
        </div>
        <div class="w-75 justify-center items-center flex-col">
            <h4 class="special-elite-regular text-green text-large">Backgrounds :</h4>
            <div class="form-content-list border-light bg-light">
            @if($userBackgrounds->isEmpty() && $user->id == auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">Tu n'as créé aucun background.</p>
            @elseif($userBackgrounds->isEmpty() && $user->id != auth()->user()->id)
                <p class="special-elite-regular italic text-light-green">{{$user->login}} n'a créé aucun background.</p>
            @else
            <ul class="w-100">
                @foreach($userBackgrounds as $background)
                    <li class="w-90 flex-row justify-center">
                        <div class="w-75">
                            <a href="{{ route('backgrounds.list.show', $background->id) }}" class="light-button special-elite-regular">
                                {{$background->name}}
                            </a>
                        </div>
                        @if($background->author_id == auth()->user()->id)
                        <div class="w-25 flex-row">
                            <div class="w-25">
                                <a href="{{ route('backgrounds.list.edit', $background->id) }}" class="light-button text-medium">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </div>
                            <div class="w-25">
                                <form action="{{ route('backgrounds.list.destroy', $background->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="light-button text-medium special-elite-regular">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </li>
                @endforeach
            </ul>
            @endif
            </div>
        </div>
        <div class="w-75 justify-center items-center flex-col">
            <h4 class="special-elite-regular text-green text-large">Catégories diverses :</h4>
            <div class="form-content-list border-light bg-light">
                @if($userMiscellaneousCategories->isEmpty() && $user->id == auth()->user()->id)
                    <p class="special-elite-regular italic text-light-green">Tu n'as créé aucune catégorie diverse.</p>
                @elseif($userMiscellaneousCategories->isEmpty() && $user->id != auth()->user()->id)
                    <p class="special-elite-regular italic text-light-green">{{$user->login}} n'a créé aucune catégorie diverse.</p>
                @else
                    <ul class="w-100">
                        @foreach($userMiscellaneousCategories as $category)
                            <li class="w-90 flex-row justify-center">
                                <div class="w-75">
                                    <a href="{{ route('miscellaneous.lists.categories.show', $category->id) }}" class="light-button special-elite-regular">
                                        {{$category->name}}
                                    </a>
                                </div>
                                @if($category->author_id == auth()->user()->id)
                                    <div class="w-25 flex-row">
                                        <div class="w-25">
                                            <a href="{{ route('miscellaneous.categories.edit', $category->id) }}" class="light-button text-medium">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="w-25">
                                            <form action="{{ route('miscellaneous.categories.destroy', $category->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="light-button text-medium special-elite-regular">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="w-75 justify-center items-center flex-col">
            <h4 class="special-elite-regular text-green text-large">Listes diverses :</h4>
            <div class="form-content-list border-light bg-light">
                @if($userMiscellaneous->isEmpty() && $user->id == auth()->user()->id)
                    <p class="special-elite-regular italic text-light-green">Tu n'as créé aucune liste diverse.</p>
                @elseif($userMiscellaneous->isEmpty() && $user->id != auth()->user()->id)
                    <p class="special-elite-regular italic text-light-green">{{$user->login}} n'a créé aucune liste diverse.</p>
                @else
                    <ul class="w-100">
                        @foreach($userMiscellaneous as $miscellaneous)
                            <li class="w-90 flex-row justify-center">
                                <div class="w-75">
                                    <a href="{{ route('miscellaneous.list.show', $miscellaneous->id) }}" class="light-button special-elite-regular">
                                        {{$miscellaneous->name}} - <span class="text-light-green special-elite-regular italic">({{$miscellaneous->miscellaneousCategory->name}})</span>
                                    </a>
                                </div>
                                @if($miscellaneous->author_id == auth()->user()->id)
                                    <div class="w-25 flex-row">
                                        <div class="w-25">
                                            <a href="{{ route('miscellaneous.list.edit', $miscellaneous->id) }}" class="light-button text-medium">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </div>
                                        <div class="w-25">
                                            <form action="{{ route('miscellaneous.list.destroy', $miscellaneous->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="light-button text-medium special-elite-regular">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
        <div class="w-100 show-button-container border-top-down-gradient">
            <a href="{{ route('user.organisations.index', $user->id) }}" class="light-button special-elite-regular">Retour vers tes organisations</a>
            <a href="{{ route('events.index') }}" class="light-button special-elite-regular">Retour vers tous les GN</a>
            <a href="{{ route('event.content.creation') }}" class="light-button special-elite-regular">Retour vers la création de contenus</a>
        </div>
        {{-- <div class="w-75 show-button-container">
            <a href="{{ route('event.content.creation') }}" class="light-button special-elite-regular">Retour vers la création de contenus</a>
        </div> --}}
    </div>
    <div class="h-70vh"></div>
</x-layoutDoom>

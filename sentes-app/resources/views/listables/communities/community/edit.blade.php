<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Modifier la communauté {{$community->name}}</h1>
            <form action="{{ route('communities.update', $community->id) }}" method="POST" class="flex-col justify-center items-center" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-input">
                    <label for="name" class="text-shadowed">Nom de la communauté :</label>
                    <input type="text" name="name" id="name" value="{{$community->name}}" class="w-100">
                    @error('name')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="description" class="text-shadowed">Description de la communauté :</label>
                    <textarea name="description" id="description" class="w-100">{{$community->description}}</textarea>
                    @error('description')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="individual" class="text-shadowed">Face à un individu :</label>
                    <input type="text" name="individual" id="individual" value="{{$community->individual}}" class="w-100">
                    @error('individual')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="group" class="text-shadowed">Face à un groupe :</label>
                    <input type="text" name="group" id="group" value="{{$community->group}}" class="w-100">
                    @error('group')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="perspectives" class="text-shadowed">Perspectives :</label>
                    <p class="text-light-green italic special-elite-regular text-small">"Certaines d'entre nous voudraient... D'autres voudraient plutôt..."</p>
                    <input type="text" name="perspectives" id="perspectives" value="{{$community->perspectives}}" class="w-100">
                    @error('perspectives')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="highlights" class="text-shadowed">Temps forts :</label>
                    <input type="text" name="highlights" id="highlights" value="{{$community->highlights}}" class="w-100">
                    @error('highlights')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                <input type="hidden" name="community_list_id" value="{{ $communityList->id }}">
                <div class="show-button-container w-100 border-top-down-gradient">
                    <button type="submit" class="green-button special-elite-regular">Modifier la communauté</button>
                    <a href="{{ route('communities.list.index', $communityList->id) }}" class="light-button special-elite-regular">Retour aux listes de communautés</a>
                </div>
            </form>
        </section>
    </main>
</x-layoutDoom>


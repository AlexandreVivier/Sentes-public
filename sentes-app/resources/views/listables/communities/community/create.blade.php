<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Créer une communauté pour la liste {{ $communityList->name }}</h1>
            <form action="{{ route('communities.store', $communityList) }}" method="POST" class="flex-col justify-center items-center">
                @csrf
                <div class="form-input">
                    <label for="name" class="text-shadowed">Nom de la communauté :</label>
                    <input type="text" name="name" id="name" required>
                    @error('name')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="description" class="text-shadowed">Description de la communauté :</label>
                    <textarea name="description" id="description" required></textarea>
                    @error('description')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="individual" class="text-shadowed">Face à un individu :</label>
                    <p class="text-light-green italic special-elite-regular text-small">optionnel</p>
                    <input type="text" name="individual" id="individual">
                    @error('individual')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="group" class="text-shadowed">Face à un groupe :</label>
                    <p class="text-light-green italic special-elite-regular text-small">optionnel</p>
                    <input type="text" name="group" id="group">
                    @error('group')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="perspectives" class="text-shadowed">Perspectives :</label>
                    <p class="text-light-green italic special-elite-regular">"Certaines d'entre nous voudraient... D'autres voudraient plutôt..."</p>
                    <p class="text-light-green italic special-elite-regular text-small">optionnel</p>
                    <input type="text" name="perspectives" id="perspectives">
                    @error('perspectives')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="highlights" class="text-shadowed">Temps forts :</label>
                    <p class="text-light-green italic special-elite-regular text-small">optionnel</p>
                    <input type="text" name="highlights" id="highlights">
                    @error('highlights')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <input type="hidden" name="author_id" value="{{ auth()->id() }}">
                <input type="hidden" name="community_list_id" value="{{ $communityList->id }}">
                <div class="show-button-container w-100 border-top-down-gradient">
                    <button type="submit" class="green-button special-elite-regular">Créer la communauté</button>
                    <a href="{{ route('communities.list.show', $communityList) }}" class="light-button special-elite-regular">Retour à la liste</a>
                </div>
            </form>
        </section>
    </main>
</x-layoutDoom>

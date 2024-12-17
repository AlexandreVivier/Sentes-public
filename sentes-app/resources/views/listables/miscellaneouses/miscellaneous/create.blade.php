<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Créer un élément pour la liste {{$miscellaneousList->name }} :</h1>
            <h2 class="index-title special-elite-regular">De la catégorie {{$miscellaneousList->miscellaneousCategory->name}}</h2>
            <form action="{{ route('miscellaneous.store', $miscellaneousList->id) }}" method="POST" class="w-75 flex-col">
                @csrf
                <div class="form-input">
                    <label for="description" class="text-shadowed">Description de l'élément :</label>
                    <textarea name="description" id="description" class="w-100"></textarea>
                    @error('description')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                    <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
                    <input type="hidden" name="miscellaneous_list_id" id="miscellaneous_list_id" value="{{$miscellaneousList->id}}" class="w-100">
                    <div class="w-100 show-button-container border-top-down-gradient">
                        <a href="{{ route('miscellaneous.list.show', $miscellaneousList->id)}}" class="light-button special-elite-regular">Retour aux listes diverses</a>
                        <button type="submit" class="green-button special-elite-regular">Créer l'élément</button>
                    </div>
            </form>
        </section>
    </main>
</x-layoutDoom>

<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">Créer une liste de communautés</h1>
         <form action="{{ route('communities.list.store')}} method="POST" class="flex-col justify-center items-center">
            @csrf
            <div class="form-input">
                <label for="name" class="text-shadowed">Nom de la liste de communautés :</label>
                <input type="text" name="name" id="name" class="w-100">
                @error('name')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="description" class="text-shadowed">Description de la liste de communautés :</label>
                <textarea name="description" id="description" class="w-100"></textarea>
                @error('description')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('communities.list.index')}}" class="light-button special-elite-regular">Retour aux listes de communautés</a>
                <button type="submit" class="green-button special-elite-regular">Créer la liste de communautés</button>
            </div>
        </form>
    </section>
</main>
</x-layoutDoom>

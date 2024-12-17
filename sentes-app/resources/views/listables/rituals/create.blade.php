<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">Créer une liste de rituels :</h1>
         <form action="{{ route('rituals.list.store') }}" method="POST" class="w-75 flex-col">
            @csrf
            <div class="form-input">
                <label for="name" class="text-shadowed">Nom de la liste de rituels :</label>
                <input type="text" name="name" id="name" class="w-100">
                @error('name')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="description" class="text-shadowed">Description de la liste de rituels :</label>
                <textarea name="description" id="description" class="w-100"></textarea>
                @error('description')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('rituals.list.index')}}" class="light-button special-elite-regular">Retour aux listes de rituel</a>
                <button type="submit" class="green-button special-elite-regular">Créer la liste de rituels</button>
            </div>
        </form>
    </section>
</main>
</x-layoutDoom>

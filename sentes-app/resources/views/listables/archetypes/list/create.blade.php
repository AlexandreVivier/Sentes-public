<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">Créer une liste d'archétypes</h1>
         <form action="{{ route('archetypes.list.create') }}" method="POST" class="w-75 flex-col">
            @csrf
            <div class="form-input">
                <label for="name" class="text-shadowed">Nom de la liste d'archétypes :</label>
                <input type="text" name="name" id="name" class="w-100">
                @error('name')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="description" class="text-shadowed">Description de la liste d'archétypes :</label>
                <textarea name="description" id="description" class="w-100"></textarea>
                @error('description')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="archetype_category_id" class="text-shadowed">Catégorie de la liste d'archétypes :</label>
                <select name="archetype_category_id" id="archetype_category_id" class="w-100">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('archetype_category_id')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('archetypes.list.index')}}" class="light-button special-elite-regular w-100">Retour aux listes d'archétypes</a>
                <button type="submit" class="green-button special-elite-regular w-100">Créer la liste d'archétypes</button>
            </div>
        </form>
    </section>
</main>
</x-layoutDoom>

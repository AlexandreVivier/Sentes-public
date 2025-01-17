<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">Créer une liste diverse :</h1>
         <form action="{{ route('miscellaneous.list.store') }}" method="POST" class="w-75 flex-col" enctype="multipart/form-data">
            @csrf
            <div class="form-input">
                <label for="name" class="text-shadowed">Nom de la liste diverse :</label>
                <input type="text" name="name" id="name" class="w-100">
                @error('name')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="description" class="text-shadowed">Description de la liste diverse :</label>
                <textarea name="description" id="description" class="w-100"></textarea>
                @error('description')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="miscellaneous_category_id" class="text-shadowed">Catégorie de la liste diverse :</label>
                <select name="miscellaneous_category_id" id="miscellaneous_category_id" class="w-100">
                    @foreach($miscellaneousCategories as $miscellaneousCategory)
                        <option value="{{$miscellaneousCategory->id}}">{{$miscellaneousCategory->name}}</option>
                    @endforeach
                </select>
                @error('miscellaneous_category_id')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
            <div class="w-100 show-button-container border-top-down-gradient">
                <a href="{{ route('miscellaneous.list.index')}}" class="light-button special-elite-regular">Retour aux listes diverses</a>
                <button type="submit" class="green-button special-elite-regular">Créer la liste diverse</button>
            </div>
        </form>
    </section>
</main>
</x-layoutDoom>

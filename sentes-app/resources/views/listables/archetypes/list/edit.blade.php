<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
        <h1 class="index-title special-elite-regular">Modifier la liste d'archétypes {{$archetypeList->name}}</h1>
        <h2 class="index-title special-elite-regular">Catégorie : {{$archetypeList->category->name}}</h2>
         <form action="{{ route('archetypes.list.update', $archetypeList->id) }}" method="POST" class="w-75 flex-col" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="form-input">
                <label for="name" class="text-shadowed">Nom de la liste d'archétypes :</label>
                <input type="text" name="name" id="name" class="w-100" value="{{$archetypeList->name}}">
                @error('name')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="description" class="text-shadowed">Description de la liste d'archétypes :</label>
                <textarea name="description" id="description" class="w-100">{{$archetypeList->description}}</textarea>
                @error('description')
                <p>
                    {{ $message }}
                </p>
                @enderror
            </div>
            <div class="form-input">
                <label for="archetype_category_id" class="text-shadowed">Catégorie de la liste d'archétypes :</label>
                <select name="archetype_category_id" id="archetype_category_id" class="w-100">
                    @foreach($archetypeCategories as $archetypeCategory)
                        <option value="{{$archetypeCategory->id}}" @if($archetypeCategory->id == $archetypeList->archetype_category_id) selected @endif>{{$archetypeCategory->name}}</option>
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
                <a href="{{ route('archetypes.list.show', $archetypeList->id)}}" class="light-button special-elite-regular w-100">Retour à la liste d'archétypes</a>
                <button type="submit" class="green-button special-elite-regular w-100">Modifier la liste {{$archetypeList->name}}</button>
            </div>
        </form>
    </section>
</main>
</x-layoutDoom>

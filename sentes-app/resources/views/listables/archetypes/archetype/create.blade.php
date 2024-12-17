<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Créer un archétype pour la liste : {{ $archetypeList->name }}</h1>
            <h2 class="index-title special-elite-regular">De la catégorie : {{ $archetypeList->category->name }}</h2>
            <form action="{{ route('archetypes.store', $archetypeList->id) }}" method="POST" class="w-75 flex-col">
                @csrf
                <div class="form-input">
                    <label for="name" class="text-shadowed">Nom de l'archétype :</label>
                    <input type="text" name="name" id="name" class="w-100">
                    @error('name')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="description" class="text-shadowed">Description de l'archétype :</label>
                    <textarea name="description" id="description" class="w-100"></textarea>
                    @error('description')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="first_link" class="text-shadowed">Premier lien de l'archétype :</label>
                    <input type="text" name="first_link" id="first_link" class="w-100">
                    @error('first_link')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="second_link" class="text-shadowed">Deuxième lien de l'archétype :</label>
                    <input type="text" name="second_link" id="second_link" class="w-100">
                    @error('second_link')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
                <input type="hidden" name="archetype_list_id" id="archetype_list_id" value="{{$archetypeList->id}}" class="w-100">
                <div class="w-100 show-button-container border-top-down-gradient">
                    <a href="{{ route('archetypes.list.show', $archetypeList->id)}}" class="light-button special-elite-regular w-100">Retour à la liste</a>
                    <button type="submit" class="green-button special-elite-regular w-100">Créer l'archétype</button>
                </div>
            </form>
        </section>
    </main>
</x-layoutDoom>

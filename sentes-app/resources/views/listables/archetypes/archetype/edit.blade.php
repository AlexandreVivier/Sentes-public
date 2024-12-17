<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Modifier l'archétype : {{ $archetype->name }}</h1>
            <h2 class="index-title special-elite-regular">De la liste : {{ $archetype->list->name }}</h2>
            <form action="{{ route('archetypes.update', $archetype->id) }}" method="POST" class="w-75 flex-col" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="form-input">
                    <label for="name" class="text-shadowed">Nom de l'archétype :</label>
                    <input type="text" name="name" id="name" class="w-100" value="{{ $archetype->name }}">
                    @error('name')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="description" class="text-shadowed">Description de l'archétype :</label>
                    <textarea name="description" id="description" class="w-100">{{ $archetype->description }}</textarea>
                    @error('description')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="first_link" class="text-shadowed">Premier lien de l'archétype :</label>
                    <input type="text" name="first_link" id="first_link" class="w-100" value="{{ $archetype->first_link }}">
                    @error('first_link')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="second_link" class="text-shadowed">Deuxième lien de l'archétype :</label>
                    <input type="text" name="second_link" id="second_link" class="w-100" value="{{ $archetype->second_link }}">
                    @error('second_link')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
                <input type="hidden" name="archetype_list_id" id="archetype_list_id" value="{{$archetype->list->id}}" class="w-100">
                <div class="w-100 show-button-container border-top-down-gradient">
                    <a href="{{ route('archetypes.list.show', $archetype->list->id) }}" class="light-button special-elite-regular w-100">Retour à la liste</a>
                    <button type="submit" class="green-button special-elite-regular w-100">Modifier l'archétype {{ $archetype->name }}</button>
                </div>
            </form>
        </section>
    </main>
</x-layoutDoom>

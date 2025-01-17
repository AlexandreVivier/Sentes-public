<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Modifier le background {{ $background->name }} dans la liste {{ $backgroundList->name }} :</h1>
            <form action="{{ route('backgrounds.update', $background->id) }}" method="POST" class="w-75 flex-col" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-input">
                    <label for="name" class="text-shadowed">Nom du background :</label>
                    <input type="text" name="name" id="name" class="w-100" value="{{$background->name}}">
                    @error('name')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="description" class="text-shadowed">Description du background :</label>
                    <textarea name="description" id="description" class="w-100">{{$background->description}}</textarea>
                    @error('description')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                    <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
                    <input type="hidden" name="background_list_id" id="background_list_id" value="{{$backgroundList->id}}" class="w-100">
                    <div class="w-100 show-button-container border-top-down-gradient">
                        <a href="{{ route('backgrounds.list.index', $backgroundList->id)}}" class="light-button special-elite-regular">Retour aux listes de backgrounds</a>
                        <button type="submit" class="green-button special-elite-regular">Modifier le background {{ $background->name}} </button>
                    </div>
            </form>
        </section>
    </main>
</x-layoutDoom>

<x-layoutDoom>
    <main class="event-frame-content bg-light flex-row justify-center border-light">
        <section class="w-75 flex-col justify-center items-center">
            <h1 class="index-title special-elite-regular">Modifier le rituel {{ $ritual->name }} dans la liste {{$ritualList->name }} :</h1>
            <form action="{{ route('rituals.update', $ritual->id) }}" method="POST" class="w-75 flex-col" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="form-input">
                    <label for="name" class="text-shadowed">Nom du rituel :</label>
                    <input type="text" name="name" id="name" class="w-100" value="{{$ritual->name}}">
                    @error('name')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="description" class="text-shadowed">Description du rituel :</label>
                    <textarea name="description" id="description" class="w-100">{{$ritual->description}}</textarea>
                    @error('description')
                    <p>
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                    <input type="hidden" name="author_id" id="author_id" value="{{auth()->user()->id}}" class="w-100">
                    <input type="hidden" name="ritual_list_id" id="ritual_list_id" value="{{$ritualList->id}}" class="w-100">
                    <div class="w-100 show-button-container border-top-down-gradient">
                        <a href="{{ route('rituals.list.index', $ritualList->id)}}" class="light-button special-elite-regular">Retour aux listes de rituel</a>
                        <button type="submit" class="green-button special-elite-regular">Modifier le rituel</button>
                    </div>

            </form>
        </section>
    </main>
</x-layoutDoom>

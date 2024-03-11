<section>
    <h1 class="index-title special-elite-regular">Lieu id :{{ $location->id }}</h1>
    <p class="text-green"><span class="semi-bold">Nom: </span>{{ $location->title }}</p>
    <p class="text-green"><span class="semi-bold">Adresse complète :</span> {{ $location->number }} {{ $location->street }}, {{ $location->zip_code }} {{ $location->city_name }}</p>
    <p class="text-green italic">Créé le: {{ $location->created_at->format('d M Y') }}</p>
    <p class="text-green italic">Modifié le: {{ $location->updated_at->format('d M Y') }}</p>

    <div class="show-button-container">
        <div class="w-100">
            <a href="{{ route('admin.locations.index') }}" class="light-button special-elite-regular">
                Retour
            </a>
        </div>
        <div class="w-100">
            <a href="{{ route('admin.locations.edit', $location->id) }}" class="green-button special-elite-regular">
                Modifier
            </a>
        </div>
        <form action="{{ route('admin.locations.destroy', $location->id) }}" method="post" class="w-100">
            @csrf
            @method('DELETE')
            <button type="submit" class="transparent-button special-elite-regular" id="delete">
                Supprimer
            </button>
        </form>
    </div>
</section>

<dialog>
    @include('components.modals.deleteConfirm')
</dialog>

@include('components.scripts.deleteConfirm')


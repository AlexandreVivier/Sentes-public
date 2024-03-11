<article>
    <p class="text-green">ID: {{ $location->id }}</p>
    <p class="text-green">Nom: {{ $location->title }}</p>
    <p class="text-green">Adresse: {{ $location->number }} {{ $location->street }}, {{ $location->zip_code }} {{ $location->city_name }}</p>
    <p class="text-green">Créé le: {{ $location->created_at->format('d M Y') }}</p>
    <p class="text-green">Modifié le: {{ $location->updated_at->format('d M Y') }}</p>

    <div class="show-button-container">
        <div class="w-100">
            <a href="{{ route('admin.locations.index') }}" class="light-button">
                Retour
            </a>
        </div>
        <div class="w-100">
            <a href="{{ route('admin.locations.edit', $location->id) }}" class="green-button">
                Modifier
            </a>
        </div>
        <form action="{{ route('admin.locations.destroy', $location->id) }}" method="post" class="w-100">
            @csrf
            @method('DELETE')
            <button type="submit" class="transparent-button" id="delete">
                Supprimer
            </button>
        </form>
    </div>
</article>
<dialog>
    @include('components.modals.deleteConfirm')
</dialog>

@include('components.scripts.deleteConfirm')


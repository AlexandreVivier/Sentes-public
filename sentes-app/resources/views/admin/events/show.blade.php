<div class="show-wrapper">
    <h1 class="index-title special-elite-regular">GN id :{{ $event->id }}</h1>

    @include('components.eventCard', ['event' => $event, 'attendees' => $event->attendees, 'organizers' => $event->organizers, 'location' => $event->location])

    <p class="text-green italic">Créé le: {{ $event->created_at->format('d M Y') }}</p>
    <p class="text-green italic">Modifié le: {{ $event->updated_at->format('d M Y') }}</p>

        <div class="show-button-container">
            <div class="w-100">
                <a href="{{ route('admin.events.index') }}" class="light-button special-elite-regular">
                    Retour
                </a>
            </div>
            <div class="w-100">
                <a href="{{ route('admin.events.edit', $event->id) }}" class="green-button special-elite-regular">
                    Modifier
                </a>
            </div>
            <form action="{{ route('admin.events.destroy', $event->id) }}" method="post" class="w-100">
                @csrf
                @method('DELETE')
                <button type="submit" class="transparent-button special-elite-regular" id="delete">
                Supprimer
                </button>
            </form>
        </div>


</div>
<dialog>
    @include('components.modals.deleteConfirm')
</dialog>

@include('components.scripts.deleteConfirm')

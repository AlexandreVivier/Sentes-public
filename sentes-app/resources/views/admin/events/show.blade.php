<div class="show-wrapper">
    <h1 class="index-title special-elite-regular">GN id :{{ $event->id }}</h1>
    <header class="event-frame-header border-green-lg {{ $event->is_cancelled ? 'bg-head-cancelled' : ($event->start_date < now() ? 'bg-head-past' : 'bg-header') }} text-frame-title text-large ">
        <h2 class="text-large special-elite-regular {{ $event->is_cancelled ? 'text-line-through' : ''}}">{{ $event->title }}</h2>
    </header>

    <main class="event-frame-content {{ $event->is_cancelled ? 'bg-content-cancelled' : 'bg-light'}} border-light text-green ">

        @if($event->is_cancelled)
            <p class="italic"> GN Annulé !</p>
        @elseif($event->start_date < now())
            <p> GN terminé !</p>
        @endif

    @include('components.shows.event', ['event' => $event, 'attendees' => $event->attendees, 'organizers' => $event->organizers, 'location' => $event->location])

    <p class="text-green italic">Créé le: {{ $event->getFormatedDate($event->created_at) }}</p>
    <p class="text-green italic">Modifié le: {{ $event->getFormatedDate($event->updated_at) }}</p>


</main>
<aside>
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
</aside>

</div>
<dialog>
    @include('components.modals.deleteConfirm')
</dialog>

@include('components.scripts.deleteConfirm')

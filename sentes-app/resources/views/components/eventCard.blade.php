<header class="event-frame-header border-green-lg {{ $event->is_cancelled ? 'bg-head-cancelled' : ($event->start_date < now() ? 'bg-head-past' : 'bg-header') }} text-frame-title text-large ">
    <h2 class="text-large special-elite-regular {{ $event->is_cancelled ? 'text-line-through' : ''}}">{{ $event->title }}</h2>
</header>

<main class="event-frame-content {{ $event->is_cancelled ? 'bg-content-cancelled' : 'bg-light'}} border-light text-green">

    @if($event->is_cancelled)
        <p class="italic"> GN Annulé !</p>
    @elseif($event->start_date < now())
        <p> GN terminé !</p>
    @endif

    @include('components.shows.event', ['event' => $event, 'attendees' => $event->attendees, 'organizers' => $event->organizers])

    <div class="flex-row w-100">
        @if (auth()->user() && !$event->is_cancelled && $event->start_date > now())
            @if (in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray()))
                <form method="post" action="{{ route('event.cancel', $event->id) }}" class="event-button-grid">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="transparent-button special-elite-regular" id="cancel">Annuler l'évènement</button>
                </form>
            @elseif (!in_array(auth()->user()->id, $attendees->pluck('user_id')->toArray()) && $event->max_attendees > $event->attendees->count())
                <form method="POST" action="{{ route('attendee.subscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    <button type="submit" class="light-button special-elite-regular">T'inscrire !</button>
                </form>
            @elseif(in_array(auth()->user()->id, $attendees->pluck('user_id')->toArray()))
                <form method="post" action="{{ route('attendee.unsubscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="light-button special-elite-regular" id="unsubscribe">Te désinscrire</button>
                </form>
                @elseif($event->max_attendees === $event->attendees->count())
                <div class="w-100 flex-row justify-center">
                    <p class="text-green special-elite-regular text-large"> GN Complet !</p>
                </div>
            @endif
        @endif
    </div>
</main>

<dialog id="cancelEvent">
    @include('components.modals.cancelEvent')
</dialog>

<dialog id="unsubscribeUser">
    @include('components.modals.unsubscribeUser')
</dialog>
@include('components.scripts.cancelEvent')
@include('components.scripts.unsubscribeUser')

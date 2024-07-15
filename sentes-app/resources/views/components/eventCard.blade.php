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

    @auth
    <div class="flex-row w-100">
        @if (in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray()))
                @include('events.components.organizerButtons')
        @elseif (!in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray())
        && in_array(auth()->user()->id, $attendees->pluck('user_id')->toArray()))
                @include('events.components.attendeeButtons')
        @elseif ($event->max_attendees === $event->attendees->count())
        <div class="w-100 flex-row justify-center">
            <p class="text-green special-elite-regular text-large"> GN Complet !</p>
        </div>
        @elseif (!in_array(auth()->user()->id, $attendees->pluck('user_id')->toArray())
        && !$event->is_cancelled
        && $event->start_date > now())
            <form method="POST" action="{{ route('attendee.subscribe', $event->id) }}" class="event-button-grid">
                @csrf
                <button type="submit" class="light-button special-elite-regular">T'inscrire !</button>
            </form>
        @endif
    </div>
    @endauth
</main>

@if(auth()->user())
<dialog id="cancelEvent">
    @include('components.modals.cancelEvent')
</dialog>

<dialog id="unsubscribeUser">
    @include('components.modals.unsubscribeUser')
</dialog>
@endif
@include('components.scripts.cancelEvent')
@include('components.scripts.unsubscribeUser')

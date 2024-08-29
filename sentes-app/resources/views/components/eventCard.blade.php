<header class="event-frame-header border-green-lg {{ $event->is_cancelled ? 'bg-head-cancelled' : ($event->start_date < now() ? 'bg-head-past' : 'bg-header') }} text-frame-title text-large ">
    <h2 class="text-large special-elite-regular {{ $event->is_cancelled ? 'text-line-through' : ''}}">{{ $event->title }}</h2>
</header>

<main class="event-frame-content {{ $event->is_cancelled ? 'bg-content-cancelled' : 'bg-light'}} border-light text-green">

    @if($event->is_cancelled)
        <p class="italic"> GN Annulé !</p>
    @elseif($event->start_date < now())
        <p> GN terminé !</p>
    @endif

    @include('components.shows.event', ['event' => $event])

    @auth
    <div class="flex-row w-100">
        @switch($event->checkAuthAttendeeStatus())
            @case('null')
                @if($event->start_date > now())
                <form method="POST" action="{{ route('attendee.subscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    <button type="submit" class="light-button special-elite-regular">T'inscrire !</button>
                </form>
                @endif
            @break
            @case('organizer')
                @include('events.components.organizerButtons')
            @break
            @case('subscribed')
                @include('events.components.attendeeButtons')
            @break
            @case('unsubscribed')
                @if($event->start_date > now())
                <form method="POST" action="{{ route('attendee.subscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    <button type="submit" class="light-button special-elite-regular">Te réinscrire !</button>
                </form>
                @endif
                @break
        @endswitch
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

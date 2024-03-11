<header class="event-frame-header border-green-lg {{ $event->is_cancelled ? 'bg-head-cancelled' : 'bg-header'}} text-frame-title text-large text-roboto">
    <h2 class="text-medium {{ $event->is_cancelled ? 'text-line-through' : ''}}">{{ $event->title }}</h2>
    @if($event->is_cancelled)
        <p class="italic"> GN Annulé !</p>
    @endif
</header>

<main class="event-frame-content {{ $event->is_cancelled ? 'bg-content-cancelled' : 'bg-light'}} border-light text-green text-poppins">
    <section class="event-content-wrapper {{ $event->is_cancelled ? 'bg-content-cancelled' : ''}}">
        <div class="event-image-infos-wrapper">
            <div class="event-image-container">
                <div class="event-image-block">
                    @if(!$event->is_cancelled)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
                    @else
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="cancelled">
                    @endif
                    <div class="shadow-overlay"></div>
                </div>
            </div>
            <div class="event-links">
                <p class="italic text-light-green">"{{ $event->description }}"</p>
                @if(!$event->is_cancelled)
                @if ($event->file_path || $event->tickets_link || $event->server_link)
                    <p class="italic text-green">Liens utiles :</p>
                    <ul>
                        @if($event->file_path)
                            <li><a href="{{ asset('storage/' . $event->file_path) }}" class="text-green none semi-bold" target="_blank">Courrier d'invitation</a></li>
                        @endif
                        @if($event->tickets_link)
                            <li><a href="{{ $event->tickets_link }}" class="text-green none semi-bold" target="_blank">Billetterie</a></li>
                        @endif
                        @if($event->server_link)
                            <li><a href="{{ $event->server_link }}" class="text-green none semi-bold" target="_blank">Serveur Discord</a></li>
                        @endif
                    </ul>
                @endif
                @endif
            </div>
        </div>
        <div class="event-infos bg-light">
            <h4>
                @if ($event->end_date)
                    Du {{ $event->formatDate($event->start_date) }} au {{ $event->formatDate($event->end_date) }}
                @else
                    Le {{ $event->formatDate($event->start_date) }}
                @endif
            </h4>
            <h4 class="text-normal text-green">{{ $event->location->title }}
                <span class="uppercase"> - {{ $event->location->city_name }} {{ $event->location->zip_code }}</span>
            </h4>
            @if ($event->price)
                <p class="text-normal text-green">Montant de la Pàf : {{ $event->price }} €</p>
            @endif
            <p class="text-normal text-green">Inscrit·es : {{ $attendees->count() }} / {{ $event->max_attendees }}</p>
            <ul class="event-attendees">
                @if ($organizers !== null)
                    @foreach ($organizers as $organizer)
                        <li>
                            <a href=" {{ route('profile.show', $organizer->user->id) }}" class="text-green semi-bold">
                                {{ $organizer->user->login }}
                            </a>
                            <span class="text-small italic"> - orga</span>
                        </li>
                    @endforeach
                    @foreach ($attendees as $attendee)
                        @if (!in_array($attendee->user->id, $organizers->pluck('user_id')->toArray()))
                            <li>
                                <a href=" {{ route('profile.show', $attendee->user->id) }}" class="text-green">
                                    {{ $attendee->user->login }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </section>

    <div class="flex-row w-100">
        @if (auth()->user() && !$event->is_cancelled)
            @if (in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray()))
                <form method="post" action="{{ route('event.cancel', $event->id) }}" class="event-button-grid">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="transparent-button" id="delete">Annuler l'évènement</button>
                </form>
            @elseif (!in_array(auth()->user()->id, $attendees->pluck('user_id')->toArray()))
                <form method="POST" action="{{ route('attendee.subscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    <button type="submit" class="light-button">T'inscrire !</button>
                </form>
            @else
                <form method="post" action="{{ route('attendee.unsubscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="light-button" id="unsubscribe">Te désinscrire</button>
                </form>
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

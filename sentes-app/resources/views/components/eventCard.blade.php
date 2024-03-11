<header class="event-frame-header border-green-lg {{ $event->is_cancelled ? 'bg-head-cancelled' : ($event->start_date < now() ? 'bg-head-past' : 'bg-header') }} text-frame-title text-large ">
    <h2 class="text-large special-elite-regular {{ $event->is_cancelled ? 'text-line-through' : ''}}">{{ $event->title }}</h2>
    @if($event->is_cancelled)
        <p class="italic"> GN Annulé !</p>
    @elseif($event->start_date < now())
        <p> GN terminé !</p>
    @endif

</header>

<main class="event-frame-content {{ $event->is_cancelled ? 'bg-content-cancelled' : 'bg-light'}} border-light text-green ">
    <section class="event-content-wrapper {{ $event->is_cancelled ? 'bg-content-cancelled' : ''}}">
        <div class="event-image-infos-wrapper">
                <div class="event-image-block border-light">
                    @if(!$event->is_cancelled)
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
                    @else
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="cancelled">
                    @endif
                </div>
            <div class="event-links">
                <p class="italic special-elite-regular text-light-green">"{{ $event->description }}"</p>
                @if(!$event->is_cancelled)
                @if ($event->file_path || $event->tickets_link || $event->server_link)
                    <p class="text-green">Liens utiles :</p>
                    <ul class="list-none">
                        @if($event->file_path)
                            <li>
                                <a href="{{ asset('storage/' . $event->file_path) }}" class="text-green none event-link semi-bold link" target="_blank">
                                    <i class="fa-solid fa-scroll"></i>
                                    Courrier d'invitation
                                </a>
                            </li>
                        @endif
                        @if($event->tickets_link)
                            <li>
                                <a href="{{ $event->tickets_link }}" class="text-green none semi-bold event-link link" target="_blank">
                                    <i class="fa-solid fa-ticket"></i>
                                    Billetterie
                                </a>
                            </li>
                        @endif
                        @if($event->server_link)
                            <li>
                                <a href="{{ $event->server_link }}" class="text-green none semi-bold event-link link" target="_blank">
                                    <i class="fa-brands fa-discord"></i>
                                    Serveur Discord
                                </a>
                            </li>
                        @endif
                    </ul>
                @endif
                @endif
            </div>
        </div>
        <div class="event-infos bg-light border-light">
            <h4 class="special-elite-regular semi-bold">
                @if ($event->end_date)
                    Du {{ $event->formatDate($event->start_date) }} au {{ $event->formatDate($event->end_date) }}
                @else
                    Le {{ $event->formatDate($event->start_date) }}
                @endif
            </h4>
            <h4 class="text-normal special-elite-regular semi-bold text-green">{{ $event->location->title }}
                <span class="uppercase semi-bold special-elite-regular"> - {{ $event->location->city_name }} {{ $event->location->zip_code }}</span>
            </h4>
            <p class="text-normal text-green">
            @if ($event->price)
                Montant : {{ $event->price }} € -
            @endif
            Inscrit·es : {{ $attendees->count() }} / {{ $event->max_attendees }}</p>
            <h3 class="special-elite-regular text-green">Orgas :</h3>
            <ul class="event-attendees">
                @if ($organizers !== null)
                    @foreach ($organizers as $organizer)
                        <li>
                            <a href=" {{ route('profile.show', $organizer->user->id) }}" class="text-green special-elite-regular none event-link link semi-bold">
                                <i class="fa-solid fa-user"></i>{{ $organizer->user->login }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
            <h3 class="special-elite-regular text-green">Participant·es :</h3>
            <ul class="event-attendees">
                @if ($attendees !== null)
                    @foreach ($attendees as $attendee)
                        @if (!in_array($attendee->user->id, $organizers->pluck('user_id')->toArray()))
                            <li>
                                <a href=" {{ route('profile.show', $attendee->user->id) }}" class="text-green special-elite-regular event-link link none">
                                    <i class="fa-regular fa-user"></i>{{ $attendee->user->login }}
                                    @if(in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray()))
                                        @if($attendee->has_payed)<i class="fa-solid fa-euro-sign"></i>@endif
                                    @endif
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            </ul>
        </div>
    </section>

    <div class="flex-row w-100">
        @if (auth()->user() && !$event->is_cancelled && $event->start_date > now())
            @if (in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray()))
                <form method="post" action="{{ route('event.cancel', $event->id) }}" class="event-button-grid">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="transparent-button special-elite-regular" id="delete">Annuler l'évènement</button>
                </form>
            @elseif (!in_array(auth()->user()->id, $attendees->pluck('user_id')->toArray()))
                <form method="POST" action="{{ route('attendee.subscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    <button type="submit" class="light-button special-elite-regular">T'inscrire !</button>
                </form>
            @else
                <form method="post" action="{{ route('attendee.unsubscribe', $event->id) }}" class="event-button-grid">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="light-button special-elite-regular" id="unsubscribe">Te désinscrire</button>
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

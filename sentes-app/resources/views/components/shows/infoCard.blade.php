<div class="event-infos bg-light border-light">
    <h4 class="special-elite-regular semi-bold">
        @if ($event->end_date)
            Du {{ $event->formatDate($event->start_date) }} au {{ $event->formatDate($event->end_date) }}
        @else
            Le {{ $event->formatDate($event->start_date) }}
        @endif
    </h4>
    @if($event->location)
    <h4 class="text-normal special-elite-regular semi-bold text-green">{{ $event->location->title }}
        <span class="uppercase semi-bold special-elite-regular"> - {{ $event->location->city_name }} {{ $event->location->zip_code }}</span>
    </h4>
    @else
    <h4 class="text-normal special-elite-regular semi-bold text-green">Lieu à définir</h4>
    @endif
    <p class="text-normal text-green">
    @if ($event->price)
        Montant : {{ $event->price }} € -
    @endif
    Inscrit·es : {{ $event->attendee_count }} / {{ $event->max_attendees }}</p>
    <h3 class="special-elite-regular text-green">Orgas :</h3>
    <ul class="event-attendees">
        @if ($event->organizers->isNotEmpty())
            @foreach ($event->getOrganizersDataInArray() as $organizer)
            <li>
                <a href=" {{ route('profile.show', $organizer['id']) }}" class="text-green special-elite-regular none event-link link semi-bold">
                    <i class="fa-solid fa-user"></i>{{ $organizer['login'] }}
                    {{-- @if ( $organizer['has_paid'])
                    <i class="fa-solid fa-euro"></i>
                    @endif --}}
                </a>
            </li>
        @endforeach
        @endif
    </ul>
    <h3 class="special-elite-regular text-green">Participant·es :</h3>
    <ul class="event-attendees">
        @if ($event->attendees->isNotEmpty())
            @foreach ($event->getNonOrganizersDataInArray() as $attendee)
                <li>
                    <a href=" {{ route('profile.show', $attendee['id']) }}" class="text-green special-elite-regular event-link link none">
                        <i class="fa-regular fa-user"></i>{{ $attendee['login'] }}
                        {{-- @if ( $attendee['has_paid'])
                            <i class="fa-solid fa-euro"></i>
                        @endif --}}
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
    @auth
    @if ($event->getUnsubscribedAttendeesCount() > 0
    && $event->checkIfAuthIsOrganizerOrAdmin()
    )
    <h3 class="special-elite-regular text-green">Désistements :</h3>
    <ul class="event-attendees">
        @foreach ($event->getUnsubscribedAttendeesDataInArray() as $attendee)
            <li>
                <a href=" {{ route('profile.show', $attendee['id']) }}" class="text-light-green special-elite-regular event-link italic link none">
                        <i class="fa-solid fa-user"></i>{{ $attendee['login'] }}
                     @if ($attendee['has_paid'])
                        <i class="fa-solid fa-euro"></i>
                     @endif
                </a>
            </li>
        @endforeach
    </ul>
    @endif
    @endauth
</div>

<section class="event-content-wrapper {{ $event->is_cancelled ? 'bg-content-cancelled' : ''}}">
    <div class="event-image-infos-wrapper">
            <div class="event-image-block border-light">
                @if(!$event->is_cancelled)
                    @if($event->image_path === 'images/static/blank-event.png')
                        <img src="{{ asset('images/static/blank-event.png') }}" alt="{{ $event->title }}">
                    @else
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}">
                    @endif
                @else
                    @if($event->image_path === 'images/static/blank-event.png')
                        <img src="{{ asset('images/static/blank-event.png') }}" alt="{{ $event->title }}" class="cancelled">
                    @else
                        <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="cancelled">
                    @endif
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
                    @if($event->tickets_link && $event->start_date > now())
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
                    @if($event->photos_link)
                        <li>
                            <a href="{{ $event->photos_link }}" class="text-green none semi-bold event-link link" target="_blank">
                                <i class="fa-solid fa-images"></i>
                                Album photo du GN
                            </a>
                        </li>
                    @endif
                    @if($event->video_link)
                        <li>
                            <a href="{{ $event->video_link }}" class="text-green none semi-bold event-link link" target="_blank">
                                <i class="fa-solid fa-video"></i>
                                Vidéo du GN
                            </a>
                        </li>
                    @endif
                    @if($event->retex_form_link)
                        <li>
                            <a href="{{ $event->retex_form_link }}" class="text-green none semi-bold event-link link" target="_blank">
                                <i class="fa-solid fa-file-circle-question"></i>
                                Formulaire de débrief
                            </a>
                        </li>
                    @endif
                    @if($event->retex_document_path)
                        <li>
                            <a href="{{ asset('storage/' . $event->retex_document_path) }}" class="text-green none semi-bold event-link link" target="_blank">
                                <i class="fa-regular fa-file-pdf"></i>
                                Document de débrief
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
                @foreach ($event->organizers as $organizer)
                    <li>
                        <a href=" {{ route('profile.show', $organizer->user_id) }}" class="text-green special-elite-regular none event-link link semi-bold">
                            <i class="fa-solid fa-user"></i>{{ $organizer->getUserLogin() }}
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
        <h3 class="special-elite-regular text-green">Participant·es :</h3>
        <ul class="event-attendees">
            @if ($event->attendees->isNotEmpty())
                @foreach ($event->getNonOrganizersInfosInArray() as $attendee)
                    <li>
                        <a href=" {{ route('profile.show', $attendee['id']) }}" class="text-green special-elite-regular event-link link none">
                            <i class="fa-regular fa-user"></i>{{ $attendee['login'] }}
                            @auth
                            @if ($attendee['has_paid']
                             && auth()->user()->is_admin
                             || in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray())
                            && $attendee['has_paid'])
                                <i class="fa-solid fa-euro"></i>
                            @endif
                            @endauth
                        </a>
                    </li>
                @endforeach
            @endif
        </ul>
        @auth
        @if(in_array(auth()->user()->id, $organizers->pluck('user_id')->toArray())
        && $event->getUnsubscribedAttendeesCount() > 0
        || auth()->user()->is_admin
        && $event->getUnsubscribedAttendeesCount() > 0)
        <h3 class="special-elite-regular text-green">Désistements :</h3>
        <ul class="event-attendees">
            @foreach ($event->getUnsubscribedAttendeesInfos() as $attendee)
                <li>
                    <a href=" {{ route('profile.show', $attendee->user->id) }}" class="text-light-green special-elite-regular event-link italic link none">
                        @if ($attendee->is_organizer)
                            <i class="fa-solid fa-user"></i>{{ $attendee->user->login }}
                        @else
                            <i class="fa-regular fa-user"></i>{{ $attendee->user->login }}
                        @endif
                         @if ($attendee->has_paid)
                            <i class="fa-solid fa-euro"></i>
                         @endif
                    </a>
                </li>
            @endforeach
        </ul>
        @endif
        @endauth
    </div>
</section>

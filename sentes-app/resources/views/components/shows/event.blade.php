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
   @include('components.shows.infoCard', ['event' => $event])
</section>

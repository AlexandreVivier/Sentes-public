<div class="show-wrapper">
    <article class="show-article border-green">
        <h3 class="text-green">Infos Générales : </h3>
            <img src="{{ asset('storage/' . $event->image_path) }}" class="w-33 border-green" alt="{{ $event->title }}"/>
                @if ($event->end_date)
                    <p class="text-green">
                        <span class="semi-bold">Du </span>
                            {{ $event->formatDate($event->start_date) }}
                        <span class="semi-bold">au</span>
                            {{ $event->formatDate($event->end_date) }}
                    </p>
                @else
                    <p class="text-green">
                        <span class="semi-bold">Date du jeu:</span>
                        {{ $event->formatDate($event->start_date) }}
                    </p>
                @endif
                @if($event->location)
                    <p class="text-green">
                        <span class="semi-bold">Lieu: </span>
                        {{ $event->location->title }} - {{ $event->location->city_name }}
                    </p>
                @else
                <p class="text-green italic">Lieu: Supprimé</p>
                @endif
            <p class="text-green">
                <span class="semi-bold">ID:</span> {{ $event->id }}
            </p>
            <p class="text-green">
                <span class="semi-bold">Titre:</span>
                {{ $event->title }}
                </p>
            <p class="text-green">
                <span class="semi-bold">Entête:</span>
                <span class="italic">"{{ $event->description }}"</span>
            </p>

            @if ($event->organizers !== null)
                <p class="text-green">
                    <span class="semi-bold">Orga(s) :</span>
            @foreach ($event->organizers as $organizer)
                {{ $organizer->user->login }}
            @endforeach
            </p>
            @else
                <p class="text-green italic">Orga: Supprimé</p>
            @endif
            @if($event->price)
                <p class="text-green">
                    <span class="semi-bold">Pàf: </span>
                    {{ $event->price }} €</p>
            @else
                <p class="text-green">Pàf: Gratuit</p>
            @endif
    </article>
    <article class="show-article border-green">
        @if ($event->file_path)
        <p class="text-green">
            Courrier d'invitation:
            <a href="{{ asset('storage/' . $event->file_path) }}" class="text-green none semi-bold" target="_blank">
            Voir dans une autre page.
            </a>
        </p>
        @endif
        @if ($event->tickets_link)
        <p class="text-green">
            Lien de la billetterie:
            <a href="{{ $event->tickets_link }}" class="text-green none semi-bold" target="_blank">
            {{ $event->tickets_link}}
            </a>
        </p>
        @endif
        @if ($event->server_link)
        <p class="text-green">
            Lien du serveur Discord:
            <a href="{{ $event->server_link }}" class="text-green none semi-bold" target="_blank">
            {{ $event->server_link}}
            </a>
        </p>
        @endif
    </article>
    <article class="show-article border-green">
        <h3 class="text-green">Participations : </h3>
        <p class="text-green">Participantes : {{ $event->attendees->count() }} / {{ $event->max_attendees }}</p>
        <ul class="event-attendees">
            @if ($event->organizers !== null)
                @foreach ($event->organizers as $organizer)
                    <li class="text-green semi-bold">{{ $organizer->user->login }} <span class="text-small italic"> - orga</span></li>
                @endforeach
                @foreach ($event->attendees as $attendee)
                    @if (!in_array($attendee->user->id, $event->organizers->pluck('user_id')->toArray()))
                        <li class="text-green">{{ $attendee->user->login }}</li>
                    @endif
                @endforeach
            @endif
        </ul>
        <p class="text-green">
            <span class="semi-bold">Créé le: </span>
            {{ $event->created_at->format('d M Y') }}
        </p>
        <p class="text-green italic">Dernière modification le: {{ $event->updated_at->format('d M Y') }}</p>
        @if ($event->is_cancelled)
        <p class="text-green italic semi-bold">GN Annulé !</p>
        @endif
    </article>


        <div class="show-button-container">
            <div class="w-100">
                <a href="{{ route('admin.events.index') }}" class="light-button">
                    Retour
                </a>
            </div>
            <div class="w-100">
                <a href="{{ route('admin.events.edit', $event->id) }}" class="green-button">
                    Modifier
                </a>
            </div>
            <form action="{{ route('admin.events.destroy', $event->id) }}" method="post" class="w-100">
                @csrf
                @method('DELETE')
                <button type="submit" class="transparent-button" id="delete">
                Supprimer
                </button>
            </form>
        </div>


</div>
<dialog>
    @include('components.modals.deleteConfirm')
</dialog>

@include('components.scripts.deleteConfirm')

<div class="event-button-grid">
    <div class="button-col-1">
        <a href="#" class="light-button special-elite-regular">Voir le coffre à jouets</a>
        @if ($event->profile->character_relation)
        <a href="#" class="light-button special-elite-regular">Voir les relations</a>
        @endif
        @if ($event->profile->character_creation)
        <a href="#" class="light-button special-elite-regular">Créer ton personnage</a>
        @endif
    </div>
    <div class="button-col-2">
        <a href="{{ route('event.change', $event->id) }}" class="light-button special-elite-regular">Modifier les infos du GN</a>
        <a href="{{ route('event.content.index', $event->id) }}" class="light-button special-elite-regular">Modifier le contenu de jeu</a>
        <a href="{{ route('event.attendees.manage', $event->id) }}" class="light-button special-elite-regular">Gérer les participations</a>
        <form method="post" action="{{ route('attendee.unsubscribe', $event->id) }}" >
            @csrf
            @method('DELETE')
            <button type="submit" class="light-button special-elite-regular" id="unsubscribe">Te désinscrire</button>
        </form>
    </div>
</div>

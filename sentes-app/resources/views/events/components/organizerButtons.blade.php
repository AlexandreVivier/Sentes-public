<div class="event-button-grid">
    <div class="button-col-1">
        <a href="#" class="light-button special-elite-regular">Voir le coffre à jouets</a>
        <a href="#" class="light-button special-elite-regular">Voir les relations</a>
        <a href="#" class="light-button special-elite-regular">Créer ton personnage</a>
    </div>
    <div class="button-col-2">
        <a href="{{ route('event.change', $event->id) }}" class="light-button special-elite-regular">Modifier les infos du GN</a>
        <a href="#" class="light-button special-elite-regular">Modifier le contenu de jeu</a>
        <a href="{{ route('event.attendees.manage', $event->id) }}" class="light-button special-elite-regular">Gérer les participations</a>
        @if(in_array(auth()->user()->id, $organizers->where('is_subscribed', true)->pluck('user_id')->toArray()))
        <form method="post" action="{{ route('attendee.unsubscribe', $event->id) }}" >
            @csrf
            @method('DELETE')
            <button type="submit" class="light-button special-elite-regular" id="unsubscribe">Te désinscrire</button>
        </form>
        @elseif(in_array(auth()->user()->id, $attendees->where('is_subscribed', false)->pluck('user_id')->toArray()))
        <form method="post" action="{{ route('attendee.subscribe', $event->id) }}" >
            @csrf
            <button type="submit" class="light-button special-elite-regular">Te réinscrire !</button>
        </form>
        @endif
    </div>
</div>

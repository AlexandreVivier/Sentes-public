
<div class="event-button-grid">
    <div class="button-col-1">
        @if (in_array(auth()->user()->id, $attendees->where('is_subscribed', true)->pluck('user_id')->toArray()))
        {{-- <a href="#" class="light-button special-elite-regular">Voir le coffre à jouets</a> --}}
        {{-- <a href="#" class="light-button special-elite-regular">Voir les relations</a> --}}
        {{-- <a href="#" class="light-button special-elite-regular">Modifier ton personnage</a> --}}
        <a href="#" class="light-button special-elite-regular">Créer ton personnage</a>
        @else
        <div class="w-100 flex-row justify-center">
            <p class="text-green special-elite-regular text-large">Tu es bien désinscrit·e de ce GN.</p>
        </div>
        @endif
    </div>
    <div class="button-col-2">
            @if (in_array(auth()->user()->id, $attendees->where('is_subscribed', false)->pluck('user_id')->toArray()))
                <form method="POST" action="{{ route('attendee.subscribe', $event->id) }}">
                    @csrf
                    <button type="submit" class="light-button special-elite-regular">Te réinscrire !</button>
                </form>
            @else
                <form method="post" action="{{ route('attendee.unsubscribe', $event->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="light-button special-elite-regular" id="unsubscribe">Te désinscrire</button>
                </form>
            @endif
    </div>
</div>

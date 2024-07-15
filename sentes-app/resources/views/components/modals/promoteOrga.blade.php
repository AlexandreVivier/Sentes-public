<header class="bg-header border-green flex-row justify-center">
    <h1 class="text-frame-title special-elite-regular uppercase">
        Attention {{auth()->user()->login }} !
    </h1>
</header>

<main class="text-green">
    {{-- @dd($attendee) --}}
    <p>
        Tu es sur le point de nommer {{ $attendee['login'] }} orga du GN {{ $event->title }}.
    </p>
    <p>
        Tu ne pourras plus modifier ce statut toi-même.
    </p>
</main>

<footer >
    <div class="user-button-container">

        <div class="w-50">
            <button type="button" class="light-button special-elite-regular" onclick="window.history.back()">
                J'ai changé d'avis.
            </button>
        </div>

        <form action="{{ route('event.attendees.promote', $event->id) }}" method="post"  class="w-50">
            @csrf
            @method('PATCH')
            <input type="hidden" name="user_id" value="{{ $attendee['id'] }}">
            <button type="submit" class="green-button special-elite-regular w-33">
                Je nomme {{ $attendee['login'] }} orga.
            </button>
        </form>
    </div>
</footer>

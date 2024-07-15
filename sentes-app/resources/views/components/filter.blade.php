<div x-data="{ show: false }" class="" @click.away="show = false">
    <button class="light-button small-button special-elite-regular dropdown-toggle" @click="show = !show">
        {{ isset($pastsEvents) ? 'Passés' : (isset($cancelledEvents) ? 'Annulés' : 'A venir') }}
        <span class="chevron"><i class="fa-solid fa-chevron-down"></i></span>
    </button>
    <div x-show="show" class="dropdown-list small-button">
        @if(isset($pastsEvents) || isset($cancelledEvents))
        <a href="{{ $futureEventsRoute }}" class="text-green small-button text-normal semi-bold none">A venir</a>
        @endif
        @empty($pastsEvents)
        <a href="{{ $pastEventsRoute }}" class="text-green small-button text-normal semi-bold none">Passés</a>
        @endempty
        @empty($cancelledEvents)
        <a href="{{ $cancelledEventsRoute }}" class="text-green small-button text-normal semi-bold none">Annulés</a>
        @endempty
    </div>
</div>

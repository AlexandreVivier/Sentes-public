
<div class="card-wrapper">
    <div class="card-header border-green-lg text-frame-title  {{ $event->is_cancelled ? 'bg-head-cancelled' : ($event->start_date < now() ? 'bg-head-past' : 'bg-header') }}">
        <h2 class="special-elite-regular {{ $event->is_cancelled ? 'text-line-through' : ''}}">
            {{ $event->title }}
        </h2>
        <div class="index-author-list">
            <p class="special-elite-regular">Par :
                @if($event->organizers->isNotEmpty())
                    {{ $event->getOrganizersLogin() }}
                @else
                    <span> ???</span>
                @endif
            </p>
        </div>
    </div>
    <div class="card-content {{ $event->is_cancelled ? 'bg-content-cancelled' : ($event->start_date < now() ? 'bg-content-past' : 'bg-light') }} border-light text-green ">
        @if($event->is_cancelled)
            <p class="special-elite-regular"> GN Annulé !</p>
        @elseif($event->start_date < now())
            <p class="special-elite-regular"> GN terminé !</p>
        @endif
        <p class="semi-bold special-elite-regular">A {{ optional($event->location)->title ?? 'Définir' }} -
            <span class="uppercase">{{ optional($event->location)->city_name }}</span>
        </p>
        <p class="semi-bold">Du {{ $event->formatDate($event->start_date) }} au {{ $event->formatDate($event->end_date ?? $event->start_date) }}</p>
        <p class="text-normal text-green">Inscrit·es : {{ $event->attendee_count }} / {{ $event->max_attendees }}</p>
        <div class="w-100 flex-row justify-center">
            <p class="italic text-center w-75 text-light-green special-elite-regular">"{{ $event->description }}"</p>
        </div>
        <div>
            <a href="{{ route('events.show', $event->id) }}" class="{{ $event->is_cancelled ? 'transparent-button special-elite-regular' : ($event->start_date < now() ? 'transparent-button special-elite-regular' : 'light-button special-elite-regular') }}">Voir plus...</a>
        </div>
    </div>
</div>

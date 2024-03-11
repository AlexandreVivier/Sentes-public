
    <div class="card-wrapper">
        <div class="card-header border-green-lg text-frame-title text-roboto {{ $event->is_cancelled ? 'bg-head-cancelled' : 'bg-header' }}">
            <h2 class="{{ $event->is_cancelled ? 'text-line-through' : ''}}">
                {{ $event->title }}
            </h2>
            <div class="index-author-list">
                @if($event->is_cancelled)
                    <p class="italic"> GN Annulé !</p>
                @endif
                <p class="italic">Par :
                    @if($event->organizers->isNotEmpty())
                        {{ $event->organizers->pluck('user.login')->implode(', ') }}
                    @else
                        <span class="italic"> ???</span>
                    @endif
                </p>
            </div>
        </div>
        <div class="card-content {{ $event->is_cancelled ? 'bg-content-cancelled' : 'bg-light' }} border-light text-green text-roboto">
            <p class="semi-bold">A {{ optional($event->location)->title ?? 'Définir' }} -
                <span class="uppercase">{{ optional($event->location)->city_name }}</span>
            </p>
            <p class="semi-bold">Du {{ $event->formatDate($event->start_date) }} au {{ $event->formatDate($event->end_date ?? $event->start_date) }}</p>
            <p class="text-normal text-green">Inscrit·es : {{ $event->attendees->count() }} / {{ $event->max_attendees }}</p>
            <div class="w-100 flex-row justify-center">
                <p class="italic text-center w-75 text-light-green">"{{ $event->description }}"</p>
            </div>
            <div>
                <a href="{{ route('events.show', $event->id) }}" class="{{ $event->is_cancelled ? 'transparent-button' : 'light-button' }}">Voir plus...</a>
            </div>
        </div>
    </div>

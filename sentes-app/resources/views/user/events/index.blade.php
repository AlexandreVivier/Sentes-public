<x-layoutLight>

    <section>
        @include('components.filter', ['futureEventsRoute' => route('user.events.index', $userId),
         'pastEventsRoute' => route('user.events.past.index', $userId),
         'cancelledEventsRoute' => route('user.events.cancelled.index', $userId)])
         @if (isset($pastsEvents))
            <h1 class="index-title special-elite-regular">Les GN auxquels j'ai participé :</h1>
            @elseif(isset($cancelledEvents))
            <h1 class="index-title special-elite-regular">Les GN auxquels ou je suis inscrit·e qui ont été annulés :</h1>
            @else
        <h1 class="index-title special-elite-regular">Les GN auxquels je participerai :</h1>
        @endif
        <div class="index-grid">
            @auth
            @include('components.createEventButton', ['buttonText' => 'Encore un GN ?',
            'messageText' => 'Propose un nouveau GN à la communauté !',
             'link' =>  route('events.create') ])
            @endauth
       @isset($events)
        @foreach ($events as $event)

            @include('events.components.cardMyEvents', ['event' => $event])

        @endforeach
        @endisset


        </div>
        @if(isset($pastEvents) || isset($cancelledEvents))
            <aside>
                {{ $events->links() }}
            </aside>
        @endif
    </section>
<div class="h-70vh"></div>
</x-layoutLight>

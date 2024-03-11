<x-layoutLight>

    <section>
        <h1 class="index-title special-elite-regular">Les GN que j'ai organisés :</h1>
        <div class="index-grid">
            @empty($events)
            @auth
            @include('components.createEventButton', ['message' => 'Premier GN !', 'link' =>  route('events.create') ])
            @endauth
            @else
            @auth
                @include('components.createEventButton', ['message' => 'Encore un GN ?', 'link' =>  route('events.create') ])
            @endauth

        @foreach ($events as $event)

            @include('components.indexCard', ['event' => $event])

        @endforeach
        @endempty

        </div>
    </section>

</x-layoutLight>

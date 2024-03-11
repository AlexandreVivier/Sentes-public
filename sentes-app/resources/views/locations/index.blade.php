<x-layoutLight>

    <section>
        @include('components.dropdown', ['locations' => $locations])
        <h1 class="index-title">Les GN à {{ $location->title }} :</h1>

        <div class="index-grid">

                @include('components.createEventButton', ['message' => 'Créé ton GN !', 'link' =>  route('events.create') ])


        @foreach ($events as $event)

            @include('components.indexCard', ['event' => $event])

        @endforeach
        </div>
        <aside>
        {{ $events->links() }}
        </aside>
    </section>

</x-layoutLight>

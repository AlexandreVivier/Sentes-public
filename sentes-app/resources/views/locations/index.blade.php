<x-layoutLight>

    <section>
        @include('components.dropdown', ['locations' => $locations])
        <h1 class="index-title special-elite-regular">Les GN à {{ $location->title }} :</h1>

        <div class="index-grid">
            @auth
                @include('components.createEventButton', ['buttonText' => 'Propose un GN à ' . $location->title . '!',
                'messageText' => 'L\'application des Sentes contient tous les outils pour t\'accompagner dans la création de ton GN.',
                 'link' =>  route('events.create') ])
            @else
                @include('components.createEventButton', ['buttonText' => 'Inscription',
                'messageText' => 'Inscris-toi pour profiter des possibilités du site !',
                'link' => route('register')])
            @endauth

        @foreach ($events as $event)

            @include('components.indexCard', ['event' => $event])

        @endforeach
        </div>
        <aside>
        {{ $events->links() }}
        </aside>
    </section>

</x-layoutLight>

<x-layoutLight>

    <section>
       @include('components.dropdown', ['locations' => $locations])
        <div class="index-grid">
            @auth
                @include('components.createEventButton', ['message' => 'Créé ton GN !', 'link' =>  route('events.create') ])
            @else
                @include('components.createEventButton', ['message' => 'Inscris-toi pour créer ton GN !', 'link' => route('register')])
            @endauth

        @foreach ($pastsEvents as $event)
            @include('components.indexCard', ['event' => $event])
        @endforeach

        </div>
            @empty($pastsEvents->items())
            <div class="h-50vh">
            <div class="flex-row justify-center w-100">
                <h2 class="index-title special-elite-regular w-75 text-normal text-center">Désolé, ta recherche ne correspond à aucun GN à venir.</h2>
            </div>
            </div>
            @endempty
        <aside>
        {{ $pastsEvents->links() }}
        </aside>
    </section>

</x-layoutLight>

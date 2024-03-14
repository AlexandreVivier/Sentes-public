<x-layoutLight>

    <section>
        <h1 class="index-title special-elite-regular">Les GN que j'ai organisés :</h1>
        <div class="index-grid">
            @empty($events)
            @auth
            @include('components.createEventButton', ['buttonText' => 'Encore un GN ?',
            'messageText' => 'Propose encore plus de contenu à la communauté !',
             'link' =>  route('events.create') ])
            @endauth
            @else
            @auth
            <h2 class="text-green special-elite-regular w-100 text-normal text-center">Tu n'as pas encore organisé de GN.</h2>
            @include('components.createEventButton', ['buttonText' => 'Premier GN !',
            'messageText' => 'L\'application des Sentes contient tous les outils pour t\'accompagner dans la création de ton premier GN.',
            'link' =>  route('events.create') ])
            @endauth
        @foreach ($events as $event)

            @include('components.indexCard', ['event' => $event])

        @endforeach
        @endempty

        </div>
    </section>
<div class="h-70vh"></div>
</x-layoutLight>

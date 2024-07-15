<x-layoutDoom>
    <div class="bg-light flex-col justify-center w-75 border-light">
        <section class="admin-container">

            @isset($user)
                @include('admin.users.show', ['user' => $user])
            @endisset

            @isset($location)
                @include('admin.locations.show', ['location' => $location])
            @endisset

            @isset($event)
                @include('admin.events.show', ['event' => $event])
            @endisset

        </section>
    </div>
    <div class="h-70vh"></div>
</x-layoutDoom>

<x-layoutDoom>
    <div class="bg-light flex-col justify-center w-75 border-light">
        <div class="admin-container">

            @isset($user)
                @include('admin.users.edit', ['user' => $user])
            @endisset

            @isset($location)
                @include('admin.locations.edit', ['location' => $location])
            @endisset

            @isset($event)
                @include('admin.events.edit', ['event' => $event])
            @endisset

        </div>
    </div>
    <div class="h-70vh"></div>
</x-layoutDoom>

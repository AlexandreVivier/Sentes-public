<x-layoutDoom>

    <div class="bg-light dashboard-frame border-light">
        <div class="flex-row w-100 justify-center">
                <h1 class="index-title special-elite-regular">Menu Administration :</h1>
        </div>

        <div class="admin-container">
                <ul class="admin-menu">
                    <li class="w-30"><a href="{{ route('admin.users.index') }}" class="light-button special-elite-regular">Membres</a></li>
                    <li class="w-30"><a href="{{ route('admin.locations.index') }}" class="light-button special-elite-regular">Lieux</a></li>
                    <li class="w-30"><a href="{{ route('admin.events.index') }}" class="light-button special-elite-regular">GN</a></li>

                    @isset($users)
                    <li>
                        <a href="{{ route('admin.users.create') }}" class="green-button special-elite-regular">
                        Ajouter un membre
                        </a>
                    </li>
                    @endisset

                    @isset($locations)
                        <li>
                            <a href="{{ route('admin.locations.create') }}" class="green-button special-elite-regular">
                            Ajouter un lieu
                            </a>
                        </li>
                    @endisset

                    @isset($events)
                        <li>
                            <a href="{{ route('admin.events.create') }}" class="green-button special-elite-regular">
                            Ajouter un GN
                            </a>
                        </li>
                    @endisset
                </ul>
                @isset($users)
                    @include('admin.dashboard', ['users' => $users, 'titles' => $titles])
                @endisset

                @isset($locations)
                    @include('admin.dashboard', ['locations' => $locations, 'titles' => $titles])
                @endisset

                @isset($events)
                    @include('admin.dashboard', ['events' => $events, 'titles' => $titles ])
                @endisset
        </div>
    </div>
    <div class="h-70vh"></div>
</x-layoutDoom>

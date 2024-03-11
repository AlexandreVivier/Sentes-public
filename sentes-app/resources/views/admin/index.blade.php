<x-layoutDoom>

    <div class="bg-light dashboard-frame border-light">
        <div class="flex-row w-100 justify-center">
                <h1 class="text-green text-large">Menu Administration :</h1>
        </div>

        <div class="admin-container">
                <ul class="admin-menu">
                    <li class="w-30"><a href="{{ route('admin.users.index') }}" class="light-button">Membres</a></li>
                    <li class="w-30"><a href="{{ route('admin.locations.index') }}" class="light-button">Lieux</a></li>
                    <li class="w-30"><a href="{{ route('admin.events.index') }}" class="light-button">GN</a></li>

                    @isset($users)
                    <li>
                        <a href="{{ route('admin.users.create') }}" class="green-button">
                        Ajouter un membre
                        </a>
                    </li>
                    @endisset

                    @isset($locations)
                        <li>
                            <a href="{{ route('admin.locations.create') }}" class="green-button">
                            Ajouter un lieu
                            </a>
                        </li>
                    @endisset

                    @isset($events)
                        <li>
                            <a href="{{ route('admin.events.create') }}" class="green-button">
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
</x-layoutDoom>

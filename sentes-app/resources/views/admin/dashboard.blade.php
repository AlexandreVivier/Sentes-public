    <div class="wrapper">

    <table class="fixed_headers">
        <thead>
        <tr>
            <th class="td-mobile-none special-elite-regular">Id</th>
            @foreach($titles as $title)
            @if($title === 'Avatar' || $title === 'Nom' || $title === 'Orga(s)'  || $title === 'Pseudo'  || $title === 'Titre' || $title === 'Prénom' || $title === 'Nom' || $title === 'Ville' || $title === 'Date de début' || $title === 'Auteur' || $title === 'Code Postal')
            <th class="special-elite-regular">{{ $title }}</th>
            @else
            <th class="td-mobile-none special-elite-regular">{{ $title }}</th>
            @endif
            @endforeach
        </tr>
        </thead>

        <tbody>
                @isset($users)
                        @foreach($users as $user)
                        <tr>
                            <td class="td-mobile-none">{{ $user->id }}</td>
                            @if($user->avatar_path === 'images/static/blank-profile.png')
                            <td><img src="{{ asset('images/static/blank-profile.png') }}" class="avatar-crud user-photo" alt="{{ $user->login }}"/></td>
                            @else
                            <td ><img src="{{ asset('storage/' . $user->avatar_path) }}" class="avatar-crud user-photo" alt="{{ $user->login }}"/></td>
                            @endif
                            <td ><a href="{{ route('admin.users.show', $user->id) }}" class="semi-bold text-green italic">{{ $user->login }}</a></td>
                            <td >{{ $user->first_name }}</td>
                            <td >{{ $user->last_name }}</td>
                            <td class="td-mobile-none">{{ $user->email }}</td>
                            <td class="td-mobile-none">{{ $user->getFormatedDate($user->created_at) }}</td>
                        </tr>
                        @endforeach
                @endisset

                @isset($locations)
                        @foreach($locations as $location)
                        <tr>
                            <td class="td-mobile-none">{{ $location->id }}</td>
                            <td ><a href="{{ route('admin.locations.show', $location->id) }}" class="semi-bold text-green italic">{{ $location->title }}</a></td>
                            <td class="td-mobile-none">{{ $location->number }}</td>
                            <td class="td-mobile-none">{{ $location->street }}</td>
                            <td >{{ $location->city_name }}</td>
                            <td >{{ $location->zip_code }}</td>
                            <td class="td-mobile-none">{{ $location->getFormatedDate($location->created_at) }}</td>
                        </tr>
                        @endforeach
                @endisset

                @isset($events)
                        @foreach($events as $event)
                        <tr>
                            <td class="td-mobile-none">{{ $event->id }}</td>
                            <td>
                                <a href="{{ route('admin.events.show', $event->id) }}" class="semi-bold text-green italic">
                                    {{ $event->title }}
                                </a>
                                @if($event->is_cancelled)
                                <p class="italic text-small">- Annulé ! -</p>
                                @endif
                            </td>
                            <td class="td-mobile-none">{{ $event->description }}</td>
                            <td >{{ $event->formatDate($event->start_date) }}</td>
                            @if($event->location)
                            <td class="td-mobile-none">{{ $event->location->title }}</td>
                            @else
                            <td class="td-mobile-none italic">Lieu supprimé !</td>
                            @endif
                            @if($event->organizers->isNotEmpty())
                                <td>
                                        {{ $event->getOrganizersLogin() }}
                                </td>
                            @else
                                <td class="td-mobile-none italic">Orga supprimé !</td>
                            @endif
                        </tr>
                        @endforeach
                @endisset
        </tbody>
    </table>
</div>
<div>

</div>

<script>


</script>

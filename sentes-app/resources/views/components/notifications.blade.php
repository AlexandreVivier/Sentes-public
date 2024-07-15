<div class="notification-list-dropdown">
    @if(auth()->user()->notifications->isEmpty())
        <div class="notification-infos border-light bg-light">
            <p class="special-elite-regular text-green">Pas de notifications pour le moment.</p>
        </div>
    @else
    <aside class="notification-links-dropdown">
        <button class="special-elite-regular w-50 link" id="show-unread">
            Non lues
        </button>
        <button class="special-elite-regular w-50 link" id="show-read">
            Lues
        </button>
    </aside>

    <ul class="notification-list-ul">



        @if(auth()->user()->unreadNotifications->isEmpty())
        <li class="notification-infos border-light bg-light-opacity unread-notification">
            <p class="special-elite-regular text-green">Pas de notifications non lues.</p>
        </li>
        @endif

            @foreach(auth()->user()->unreadNotifications as $notification)
                <li class="notification-infos border-light bg-light-opacity unread-notification">
                <a href="{{ route('notifications.show', $notification->id) }}" class="text-green none event-link link bold">{{ $notification->data['title'] }}</a>
                    <p class="special-elite-regular text-green">{{ $notification->data['message'] }}</p>
                    <div class="notification-footer">
                        <p class="special-elite-regular text-small italic text-green">{{ $notification->created_at->diffForHumans() }}</p>
                            <div class="notification-button-grid">
                            <a href="{{ route('notifications.delete', $notification->id) }}" class="notification-button"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </div>
                </li>
            @endforeach

            @if(auth()->user()->readNotifications->isEmpty())
            <li class="notification-infos border-light bg-content-cancelled read-notification">
                <p class="special-elite-regular text-green">Pas de notifications lues.</p>
            </li>
            @endif
            @foreach(auth()->user()->readNotifications as $notification)
                <li class="notification-infos border-light bg-content-cancelled read-notification">
                    <a href="{{ route('notifications.show', $notification->id) }}" class="text-green none event-link link italic text-green">{{ $notification->data['title'] }}</a>
                    <p class="special-elite-regular text-light-green">{{ $notification->data['message'] }}</p>
                    <div class="notification-footer">
                        <p class="special-elite-regular text-small italic text-light-green">{{ $notification->created_at->diffForHumans() }}</p>
                            <div class="notification-button-grid">
                            <a href="{{ route('notifications.delete', $notification->id) }}" class="notification-button bold"><i class="fa-solid fa-trash"></i></a>
                        </div>
                    </div>
                </li>
            @endforeach

        <aside class="notification-links-dropdown">
            <button class="green-button special-elite-regular w-50" onclick="window.location.href='{{ route('notifications.deleteAll') }}'">
                Effacer toutes les notifications
            </button>
            <button class="light-button special-elite-regular w-50" onclick="window.location.href='{{ route('notifications.markAllAsRead') }}'">
                Tout marquer comme lu
            </button>
        </aside>
    </ul>
    @endif
</div>

@include('components.scripts.notificationFilteringToggle')

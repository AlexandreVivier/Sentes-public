<nav class="nav">
    <input type="checkbox" id="nav-check">
    <input type="checkbox" id="nav-check-profile">
    <input type="checkbox" id="nav-check-bell">
    <div class="nav-header">
        <div class="nav-title">
            <a href="{{ route('home') }}" class="special-elite-regular">
                Les Sentes
            </a>
        </div>
        <div class="profile-bell">
            @auth
            <div class="nav-btn-profile">
                <label for="nav-check-profile">
                    <div>
                    @if(auth()->user()->avatar_path === 'images/static/blank-profile.png')
                        <img src="{{ asset('images/static/blank-profile.png') }}" class="profile-mini user-photo" alt="{{ auth()->user()->login }}"/>
                    @else
                        <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" class="profile-mini user-photo" alt="{{ auth()->user()->login }}"/>
                    @endif
                    </div>
                        <i class="fa-solid fa-caret-down"></i>
                </label>
            </div>
            <div class="nav-btn-bell-mobile">
                <a href="{{ route('notifications.index') }}">
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="notification-counter">{{ auth()->user()->unreadNotifications->count() }}</span>
                    @endif
                    <i class="fa-solid fa-bell"></i>
                </a>
            </div>
            <div class="nav-btn-bell-desktop">
                <label for="nav-check-bell">
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <span class="notification-counter">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
                <i class="fa-solid fa-bell"></i>
                </label>
            </div>
            @endauth
        </div>
    </div>

    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>
    <ul class="nav-list">
        <li>
            <a href="{{ route('events.index') }}" class="special-elite-regular">
                Tous les GN
            </a>
        </li>
        <li>
            <a href="{{ route('about') }}" class="special-elite-regular">
                A propos
            </a>
        </li>
      @guest
        <li>
            <a href="{{ route('register') }}" class="special-elite-regular">
                Inscription
            </a>
        </li>
        <li>
            <a href="{{ route('login') }}" class="special-elite-regular">
                Connexion
            </a>
        </li>
      @else
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="special-elite-regular">
                Déconnexion
            </button>
        </form>
      @endguest
    </ul>
    @auth
    <ul class="nav-list-profile">
        @if (Auth::user()->is_admin)
        <li>
            <a href="{{ route('admin.index') }}" class="special-elite-regular">
                Admin
            </a>
        </li>
      @endif
        <li>
            <a href="{{ route('profile.myProfile')}}" class="special-elite-regular">
                Mon Profil
            </a>
        </li>
        <li>
            <a href="{{ route('user.organisations.index', auth()->user()->id) }}" class="special-elite-regular">
                Mes Organisations
            </a>
        </li>
        <li>
            <a href="{{ route('user.events.index', auth()->user()->id) }}" class="special-elite-regular">
                Mes Participations
            </a>
        </li>
    </ul>
        <div class="nav-list-bell">
            @include('components.notifications')
        </div>
    </div>
    @endauth

    <span class="fungi-texture"></span>
  </nav>

  @include('components.scripts.navScript')

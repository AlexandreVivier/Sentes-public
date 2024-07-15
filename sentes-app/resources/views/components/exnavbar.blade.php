<nav class="nav">
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="nav-title">
            <a href="{{ route('home') }}" class="special-elite-regular">
                Les Sentes
            </a>
        </div>
        <div class="about-bell">
        <div class="nav-about">
            <a href="{{ route('about') }}">
                A propos
            </a>
        </div>
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
        <form method="POST" action="/logout">
            @csrf
            <button type="submit" class="special-elite-regular">
                Déconnexion
            </button>
        </form>
      @endguest
    </ul>
    <span class="fungi-texture"></span>
  </nav>

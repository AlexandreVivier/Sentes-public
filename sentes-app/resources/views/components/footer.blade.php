<footer class="footer-container" x-data="{ show: false }"  @click.away="show = false">
    <section class="footer-main" x-show="show">
        <button class="footer-text footer-button" @click="show = false">
            <i class="fa-solid fa-angles-down"></i>
        </button>
        <div class="footer-show">
            <div class="footer-sitemap">
                <h2 class="footer-text italic">
                    Plan du site :
                </h2>
                <ul class="footer-list">
                    <li>
                        <a href="{{ route('home') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Accueil
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Tous les GN
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>A propos
                        </a>
                    </li>
                    @guest
                    <li>
                        <a href="{{ route('register') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Inscription
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Connexion
                        </a>
                    </li>
                    @else
                    <li>
                        <a href="{{ route('profile.myProfile') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Mon Profil
                        </a>
                    </li>
                    @if(auth()->user()->isOrganiser() != null)
                    <li>
                        <a href="{{ route('user.organisations.index', auth()->user()->id) }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Mes Orgas
                        </a>
                    </li>
                    @endif
                    @if (Auth::user()->is_admin)
                    <li>
                        <a href="{{ route('admin.index') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Admin
                        </a>
                    </li>
                    @endif
                    <li>
                        <a href="{{ route('events.create') }}" class="footer-text">
                            <i class="fa-solid fa-plus"></i>Créer un GN
                        </a>
                    </li>
                    @endguest
                </ul>
            </div>

            <div class="footer-about">
                <h2 class="footer-text italic">
                    A propos :
                </h2>
                <ul class="footer-list">
                    <li>
                        <a href="{{ asset('storage/events/files/sentes.pdf') }}" class="footer-text" target="_blank">
                            <i class="fa-brands fa-pagelines"></i>Les Sentes
                        </a>
                    </li>
                    <li>
                        <a href="https://outsiderart.blog/" class="footer-text" target="_blank">
                            <i class="fa-solid fa-link"></i>Le Blog de Thomas Munier
                        </a>
                    </li>
                    <li>
                        <a href="mailto:alexandre.vivier.krill@gmail.com" class="footer-text" target="_blank">
                            <i class="fa-solid fa-at"></i>Contacter le webmaster
                        </a>
                    </li>
                    <li>
                        <a href="https://www.ovhcloud.com/fr/" class="footer-text" target="_blank">
                            <i class="fa-solid fa-link"></i>Hébergeur - OVH
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('terms') }}" class="footer-text">
                            <i class="fa-solid fa-eye"></i>Conditions générales d'utilisation
                        </a>
                </ul>
            </div>
            <div class="footer-social">
                <h2 class="footer-text italic">
                    Suis-nous :
                </h2>
                <ul class="footer-list">
                    <li>
                        <a href="https://www.facebook.com/folkloreoutsider/?locale=fr_FR" target="_blank" class="footer-text">
                            <i class="fa-brands fa-facebook"></i> sur Facebook
                        </a>
                    </li>
                    <li>
                        <a href="https://www.youtube.com/@ThomasMunier" target="_blank" class="footer-text">
                            <i class="fa-brands fa-youtube"></i> sur Youtube
                        </a>
                    </li>
                    <li>
                        <a href="https://discord.gg/bHP6D3q9fR" target="_blank" class="footer-text">
                            <i class="fa-brands fa-discord"></i> sur Discord
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <aside class="footer-aside">
        <button class="footer-text footer-button" @click="show = !show">
            <i class="fa-solid fa-angles-up"></i>
        </button>
        <p class="footer-text">
            @php
                $currentYear = date('Y');
            @endphp
            Les Sentes - 2024 @if($currentYear != 2024)- {{ $currentYear }} @endif  -
            <a href="{{ route('legals') }}" class="footer-text">
                Mentions légales
            </a>
        </p>

    </aside>

</footer>

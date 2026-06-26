<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand d-flex align-items-center ps-4" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block me-2">
        Bibliothèque Sonnore de Blois
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
            @auth
                @if(Auth::user()->is_voice_donor)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/Donneurs-Voix') }}">Donneurs Voix</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/Trésorerie') }}">Trésorerie</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/Secrétariat') }}">Secrétariat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/Président') }}">Président</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/Donneurs-Voix') }}">Donneurs Voix</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/Donneurs-Temps') }}">Donneurs Temps</a>
                    </li>
                @endif
            @endauth
        </ul>

        <!-- Ajout des éléments à droite -->
        <ul class="navbar-nav ms-auto">
            <!-- Lien "Ajouter discussion" visible pour les masters et le président -->
            @auth
                @if(Auth::user()->is_master || Auth::user()->is_president)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('discussion.create') }}">Ajouter discussion</a>
                    </li>
                @endif
            @endauth

            <!-- Lien "Ajouter actualité" visible pour les masters et le président -->
            @auth
                @if(Auth::user()->is_master || Auth::user()->is_president)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('actualite.create') }}">Ajouter actualité</a>
                    </li>
                @endif
            @endauth

            <!-- Affichage du nom de l'utilisateur connecté ou lien de connexion -->
            @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Mon profil</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Déconnexion</button>
                            </form>
                        </li>
                    </ul>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</nav>

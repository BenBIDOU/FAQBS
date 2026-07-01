@php
use Illuminate\Support\Facades\Auth;
@endphp
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand d-flex align-items-center ps-4" href="@auth /espace-membre @else / @endauth">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block me-2">
        Bibliothèques sonores du Centre val de Loire
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
        </ul>

        <!-- Éléments à droite -->
        <ul class="navbar-nav ms-auto">
            @auth
                @if(!Auth::user()->is_master)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('discussion.create') }}">Ajouter discussion</a>
                    </li>
                @endif
                @if(Auth::user()->is_master)
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('discussions.manage') }}" style="color: #0dcaf0;">Gérer discussions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('a-faire') }}" style="color: #0dcaf0;">À faire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('membres.manage') }}" style="color: #0dcaf0;">Gestion membres</a>
                    </li>
                @endif
            @endauth

            <!-- Affichage du nom de l'utilisateur connecté ou lien de connexion -->
            @auth
                @php
                    $unreadCount = \App\Models\Question::where('email', Auth::user()->email)
                        ->whereNotNull('answer')
                        ->where('answer', '!=', '')
                        ->count();
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Mon profil</a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('profile.edit') }}#messagerieCollapse">
                                Mes messages
                                @if($unreadCount > 0)
                                    <span class="badge bg-danger">{{ $unreadCount }}</span>
                                @endif
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
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

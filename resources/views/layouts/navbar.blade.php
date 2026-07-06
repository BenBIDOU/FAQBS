@php
use Illuminate\Support\Facades\Auth;
@endphp
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(to right, #2c3e50, #1a1a1a);">
    <a class="navbar-brand d-flex align-items-center ps-4" href="@auth /agora @else / @endauth">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" width="30" height="30" class="d-inline-block me-2">
        Bibliothèques sonores de la région Centre - Val de Loire
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
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gestion-questions') }}" style="color: #0dcaf0;">Gestion questions</a>
                    </li>
                @endif
            @endauth

            <!-- Affichage du nom de l'utilisateur connecté ou lien de connexion -->
            @auth
                @php
                    // Compter les questions avec réponse non lues
                    $unreadQuestions = \App\Models\Question::where('email', Auth::user()->email)
                        ->whereNotNull('answer')
                        ->where('answer', '!=', '')
                        ->count();
                    
                    // Compter les messages non lus
                    $unreadMessages = \App\Models\Message::where('receiver_id', Auth::user()->id)
                        ->where('is_read', false)
                        ->count();
                    
                    $totalUnread = $unreadQuestions + $unreadMessages;
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                        @if($totalUnread > 0)
                            <span class="badge bg-danger ms-2">{{ $totalUnread }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">Mon profil</a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('messages.inbox') }}">
                                Boîte de réception
                                @if($unreadMessages > 0)
                                    <span class="badge bg-danger">{{ $unreadMessages }}</span>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center" href="{{ route('profile.edit') }}#messagerieCollapse">
                                Mes questions
                                @if($unreadQuestions > 0)
                                    <span class="badge bg-danger">{{ $unreadQuestions }}</span>
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

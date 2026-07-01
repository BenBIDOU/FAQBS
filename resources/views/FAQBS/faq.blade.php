@extends('layouts.app')
@section('title', 'Agora Blibliothèques Sonores - Centre val de Loire')
@section('content')
<!-- Bandeau supérieur -->
<div class="bg-white py-3 shadow-sm">
    <div class="container-fluid">
        <div class="row align-items-start">
            <!-- Logo à gauche -->
            <div class="col-md-3 text-start mb-3 mb-md-0">
                <img src="{{ asset('images/logo.png') }}" alt="Bibliothèques Sonores de France" class="img-fluid" style="max-height: 100px;">
            </div>
            
            <!-- Bogo au centre sur 2/3 -->
            <div class="col-md-6 text-center mb-3 mb-md-0">
                <img src="{{ asset('images/bogobibsonores.png') }}" alt="Les Bibliothèques Sonores" class="img-fluid" style="max-height: 360px; max-width: 200%;">
            </div>
            
            <!-- Module de connexion à droite -->
            <div class="col-md-3 text-end">
                <div class="d-flex flex-column align-items-end">
                    <p class="mb-1" style="font-size: 1.1rem;">Se connecter</p>
                    @guest
                    <form method="POST" action="{{ route('login') }}" class="mb-2">
                        @csrf
                        <div class="mb-2">
                            <input type="email" class="form-control form-control-sm" name="email" placeholder="Mon adresse email" required>
                        </div>
                        <div class="mb-2">
                            <input type="password" class="form-control form-control-sm" name="password" placeholder="Mon mot de passe" required>
                        </div>
                        <button type="submit" class="btn btn-bordeaux text-uppercase text-white" style="font-weight: bold; font-size: 0.9rem; padding: 0.3rem;">Connexion</button>
                        <p class="small text-danger mb-0 mt-1">Mot de passe oublié ?</p>
                    </form>
                    @endguest
                    @auth
                    <div class="text-end">
                        <p class="mb-2" style="font-size: 1.1rem;">Bonjour, {{ Auth::user()->name }}</p>
                        <a href="{{ route('logout') }}" class="btn btn-bordeaux text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Déconnexion</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                    @endauth
                    
                    <!-- Icônes Accessibilité et Contact -->
                    <div class="d-flex gap-3 mt-2">
                        <div class="d-flex align-items-center gap-1">
                            <span class="small">ACCESSIBILITÉ</span>
                            <i class="bi bi-universal-access-circle" style="font-size: 1.5rem; color: #6D071A;"></i>
                        </div>
                        <div class="d-flex align-items-center gap-1">
                            <span class="small">CONTACT</span>
                            <i class="bi bi-envelope-fill" style="font-size: 1.5rem; color: #6D071A;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <!-- Titre principal -->
    <div class="text-center">
        <h1>Agora Bibliothèques Sonores du Centre val de Loire</h1>
    </div>
    
    <!-- Carousel des villes -->
    <div class="mt-3">
        <div id="villeCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('images/Blois.jpg') }}" alt="Blois - Centre Val de Loire" class="d-block w-100" style="max-height: 400px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/Tours.jpg') }}" alt="Tours - Centre Val de Loire" class="d-block w-100" style="max-height: 400px; object-fit: cover;">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('images/Orleans.jpg') }}" alt="Orléans - Centre Val de Loire" class="d-block w-100" style="max-height: 400px; object-fit: cover;">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#villeCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Précédent</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#villeCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Suivant</span>
            </button>
            <div class="carousel-indicators" style="bottom: -30px;">
                <button type="button" data-bs-target="#villeCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Blois"></button>
                <button type="button" data-bs-target="#villeCarousel" data-bs-slide-to="1" aria-label="Tours"></button>
                <button type="button" data-bs-target="#villeCarousel" data-bs-slide-to="2" aria-label="Orléans"></button>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <!-- Laius -->
    <div class="justify-center text-center align-middle mb-5">
        <h2>-- Laius --</h2>
    </div>
</div>

<!-- Second module de connexion - centré et plus grand -->
<div class="container-fluid mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-bordeaux text-white text-center">
                    <h4 class="mb-0">Se connecter à votre espace</h4>
                </div>
                <div class="card-body p-4">
                    @guest
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">Se souvenir de moi</label>
                        </div>
                        <button type="submit" class="btn btn-bordeaux w-100 text-white text-uppercase" style="font-weight: bold;">
                            Connexion
                        </button>
                        <div class="mt-3 text-center">
                            <p class="mb-0 small text-muted">Mot de passe oublié ? <a href="#">Réinitialiser</a></p>
                            @if (Route::has('register'))
                                <p class="mb-0 small mt-1">Pas encore de compte ? <a href="{{ route('register') }}">S'inscrire</a></p>
                            @endif
                        </div>
                    </form>
                    @endguest
                    @auth
                    <div class="text-center">
                        <p class="mb-3">Bonjour, <strong>{{ Auth::user()->name }}</strong> !</p>
                        <a href="{{ route('logout') }}" class="btn btn-bordeaux btn-lg text-white" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnexion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .bg-bordeaux-light {
        background-color: #96637B;
    }
    .btn-bordeaux {
        background-color: #6D071A;
        border-color: #6D071A;
    }
    .btn-bordeaux:hover {
        background-color: #5a0514;
        border-color: #5a0514;
    }
    .chat-body {
        display: flex;
        flex-direction: column;
    }
    /* Styles pour le carrousel */
    #villeCarousel {
        max-height: 400px;
        overflow: hidden;
    }
    #villeCarousel .carousel-item img {
        max-height: 400px;
        object-fit: cover;
        width: 100%;
    }
    #villeCarousel .carousel-control-prev,
    #villeCarousel .carousel-control-next {
        width: 5%;
        background: rgba(0, 0, 0, 0.3);
        border-radius: 50%;
    }
    #villeCarousel .carousel-indicators [data-bs-target] {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: #6D071A;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #6D071A;
    }
    #villeCarousel .carousel-indicators .active {
        background-color: white;
        border-color: #6D071A;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 2rem;
        height: 2rem;
        background-size: 100%, 100%;
    }
</style>
@endsection

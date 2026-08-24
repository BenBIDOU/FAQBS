@extends('layouts.app')

@section('title')
FAQ - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%); min-height: 100vh;">
    <!-- Bandeau avec logo, bogo et connexion - Responsive -->
    <div class="banner-container" style="background: #FFFFFF; margin-bottom: 2rem; border-bottom: 2px solid #002D5D;">
        <div class="row align-items-stretch g-0">
            <!-- Logo - Mobile: plein large, Desktop: 2 colonnes -->
            <div class="col-12 col-md-2 d-flex align-items-center justify-content-start justify-content-md-start ps-4 ps-md-4">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="header-logo" style="width: auto; max-width: 100%;">
            </div>
            
            <!-- Bogo - Mobile: plein large, Desktop: 8 colonnes -->
            <div class="col-12 col-md-8 d-flex align-items-center justify-content-center order-md-1">
                <img src="{{ asset('images/bogobibsonores.png') }}" alt="Bogo" class="header-bogo" style="width: auto; max-width: 100%;">
            </div>
            
            <!-- Connexion/Formulaire - Mobile: plein large, Desktop: 2 colonnes -->
            <div class="col-12 col-md-2 d-flex align-items-center justify-content-end justify-content-md-end pe-4 pe-md-4 order-md-2">
                @auth
                    <div class="d-flex flex-column align-items-end align-items-md-end text-end">
                        <span class="mb-2" style="font-weight: 500; color: #002D5D;">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; white-space: nowrap;">
                                <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                            </button>
                        </form>
                    </div>
                @else
                    <div class="w-100 text-end">
                        <form method="POST" action="{{ route('login') }}" class="login-form-compact d-inline-block text-start">
                            @csrf
                            <div class="mb-2">
                                <input type="email" name="email" class="form-control form-control-sm" placeholder="Email" required style="border: 1px solid #E9ECEF; border-radius: 6px; padding: 6px 10px; font-size: 0.85rem;">
                            </div>
                            <div class="mb-2">
                                <input type="password" name="password" class="form-control form-control-sm" placeholder="Mot de passe" required style="border: 1px solid #E9ECEF; border-radius: 6px; padding: 6px 10px; font-size: 0.85rem;">
                            </div>
                            <div class="mb-2 d-flex align-items-center">
                                <input type="checkbox" name="remember" id="remember-faq" class="form-check-input me-2" style="margin-top: 0;">
                                <label for="remember-faq" class="form-check-label small" style="color: #495057; font-size: 0.8rem; white-space: nowrap;">Se souvenir</label>
                            </div>
                            <button type="submit" class="btn btn-sm w-100 mb-1" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; white-space: nowrap;">
                                <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                            </button>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="btn btn-link btn-sm p-0 d-block text-end" style="color: #002D5D; font-size: 0.8rem;">
                                    Mot de passe oublié ?
                                </a>
                            @endif
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Titre principal -->
    <div class="text-center mb-4 mt-4">
        <h1 class="mb-2" style="color: #002D5D; font-weight: 700; font-size: 2.5rem;">Bienvenue à l'Agora</h1>
        <p class="mb-0" style="color: #495057; font-size: 1.2rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
    </div>

    <!-- Carrousel des villes -->
    <div class="mb-4">
        <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div class="card-body p-0">
                <div id="villeCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
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
                <div class="carousel-text-overlay text-center px-4" style="position: absolute; bottom: 60px; left: 0; right: 0; background: rgba(0, 0, 0, 0.6); padding: 20px 0; z-index: 10;">
                    <h2 class="fs-4 text-white mb-0" style="text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8); font-weight: 500;">
                        L'Agora des Bibliothèques sonores de la région Centre - Val de Loire est un espace de discussion
                        et de partage entre tous les bénévoles. 
                        Retrouvez ici tous les échanges et les informations utiles, pour une plus grande efficacité, au bénéfice de nos audiolecteurs.
                    </h2>
                </div>
            </div>
        </div>
    </div>


<!-- Styles spécifiques pour le carrousel -->
<style>
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
        background-color: #990000;
        border: 2px solid white;
        box-shadow: 0 0 0 2px #990000;
    }
    #villeCarousel .carousel-indicators .active {
        background-color: white;
        border-color: #990000;
    }
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
        width: 2rem;
        height: 2rem;
        background-size: 100%, 100%;
    }
    
    @media (max-width: 767.98px) {
        #villeCarousel {
            max-height: 300px;
        }
        #villeCarousel .carousel-item img {
            max-height: 300px;
        }
        .carousel-text-overlay {
            bottom: 40px;
            padding: 15px 0;
        }
        .carousel-text-overlay h2 {
            font-size: 1.1rem !important;
        }
    }
</style>

<!-- Script pour la recherche dans la FAQ -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('faqSearch');
        const searchButton = document.getElementById('searchButton');
        
        if (!searchInput || !searchButton) return;
        
        function filterFAQ() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            const faqLinks = document.querySelectorAll('.accordion-body a.list-group-item-action');
            let hasResults = false;
            
            faqLinks.forEach(link => {
                const fullText = link.textContent.toLowerCase();
                const isVisible = fullText.includes(searchTerm);
                link.classList.toggle('d-none', !isVisible);
                if (isVisible) hasResults = true;
            });
            
            // Ouvrir les accordéons avec résultats
            document.querySelectorAll('.accordion-collapse').forEach(collapse => {
                const body = collapse.querySelector('.accordion-body');
                if (!body) return;
                
                const visibleLinks = Array.from(body.querySelectorAll('a.list-group-item-action'))
                    .some(link => !link.classList.contains('d-none'));
                
                const buttonId = collapse.getAttribute('id');
                const button = buttonId ? document.querySelector(`[data-bs-target="#${buttonId}"]`) : null;
                
                if (visibleLinks) {
                    collapse.classList.add('show');
                    if (button) {
                        button.classList.remove('collapsed');
                        button.setAttribute('aria-expanded', 'true');
                    }
                } else {
                    collapse.classList.remove('show');
                    if (button) {
                        button.classList.add('collapsed');
                        button.setAttribute('aria-expanded', 'false');
                    }
                }
            });
            
            if (searchTerm === '') {
                faqLinks.forEach(link => link.classList.remove('d-none'));
                document.querySelectorAll('.accordion-collapse').forEach(c => c.classList.remove('show'));
                document.querySelectorAll('.accordion-button').forEach(b => {
                    b.classList.add('collapsed');
                    b.setAttribute('aria-expanded', 'false');
                });
            }
        }
        
        searchInput.addEventListener('input', filterFAQ);
        searchButton.addEventListener('click', filterFAQ);
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                filterFAQ();
            }
        });
    });
</script>

<!-- Styles spécifiques pour la page FAQ -->
<style>
    /* Styles pour le bandeau */
    .banner-container {
        min-height: 200px;
    }
    .banner-container .row {
        min-height: 200px;
        align-items: center;
    }
    .header-logo, .header-bogo {
        width: auto;
        max-width: 100%;
        height: auto;
    }
    
    /* Style pour le formulaire de connexion compact */
    .login-form-compact {
        width: 405px;
        min-width: 338px;
    }
    .login-form-compact .form-control {
        border: 1px solid #E9ECEF;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 0.85rem;
    }
    .login-form-compact .form-control:focus {
        border-color: #990000;
        box-shadow: 0 0 0 0.2rem rgba(153, 0, 0, 0.15);
    }
    
    /* Responsive adjustments pour le bandeau */
    @media (max-width: 767.98px) {
        .banner-container {
            min-height: auto;
            padding: 0.5rem 0;
        }
        .banner-container .row {
            min-height: auto;
        }
        
            /* Mobile: centrer tous les éléments avec espaces */
        .banner-container .col-12.d-flex.align-items-center:not(:last-child) {
            justify-content: center !important;
            text-align: center;
            margin-bottom: 1.5rem !important;
        }
        .banner-container .col-12.d-flex.align-items-center:last-child {
            justify-content: center !important;
            text-align: center;
        }
        
        .header-logo {
            width: auto;
            max-width: 60%;
            height: auto;
            margin: 0.5rem auto;
        }
        
        .header-bogo {
            width: auto;
            max-width: 70%;
            height: auto;
            margin: 0.5rem auto;
            display: block;
        }
        
        /* Mobile: formulaire centré et pleine largeur */
        .login-form-compact {
            width: 100% !important;
            max-width: 563px;
            margin: 0.5rem auto;
        }
        
        /* Espacement des éléments du formulaire en mobile */
        .login-form-compact .mb-2 {
            margin-bottom: 0.5rem !important;
        }
    }
    
    @media (min-width: 768px) {
        /* Desktop et tablette */
        .banner-container {
            min-height: 200px;
        }
        .banner-container .row {
            min-height: 200px;
        }
        .header-logo, .header-bogo {
            width: auto;
            max-width: 100%;
            height: auto;
        }
    }
    
    @media (min-width: 992px) {
        /* Desktop large */
        .banner-container {
            min-height: 250px;
        }
        .banner-container .row {
            min-height: 250px;
        }
        .header-logo, .header-bogo {
            width: auto;
            max-width: 100%;
            height: auto;
        }
    }
    
    @media (min-width: 1200px) {
        /* Desktop très large */
        .banner-container {
            min-height: 270px;
        }
        .banner-container .row {
            min-height: 270px;
        }
        .header-logo, .header-bogo {
            width: auto;
            max-width: 100%;
            height: auto;
        }
    }
</style>
</div>
@endsection

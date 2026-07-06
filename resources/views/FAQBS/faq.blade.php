@extends('layouts.app')

@section('title')
FAQ - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')

    <!-- Bandeau avec logo, bogo et connexion -->
    <div class="row align-items-stretch" style="min-height: 270px; background: #FFFFFF; margin-bottom: 2rem; border-bottom: 2px solid #002D5D;">
        <div class="col-md-2 d-flex align-items-center justify-content-start ps-4">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="header-logo" style="height: 100%; max-height: 270px;">
        </div>
        <div class="col-md-8 d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/bogobibsonores.png') }}" alt="Bogo" class="header-bogo" style="height: 100%; max-height: 270px;">
        </div>
        <div class="col-md-2 d-flex align-items-center justify-content-end pe-4">
            @auth
                <div class="d-flex flex-column align-items-end">
                    <span class="mb-2" style="font-weight: 500; color: #002D5D;">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem;">
                            <i class="bi bi-box-arrow-right me-1"></i> Déconnexion
                        </button>
                    </form>
                </div>
            @else
                <div class="d-flex flex-column align-items-end gap-2">
                    <a href="{{ route('login') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; white-space: nowrap;">
                        <i class="bi bi-box-arrow-in-right me-1"></i> Connexion
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-sm" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); color: white; border: none; border-radius: 6px; padding: 6px 12px; font-size: 0.85rem; white-space: nowrap;">
                            <i class="bi bi-person-plus me-1"></i> Inscription
                        </a>
                    @endif
                </div>
            @endauth
        </div>
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
                        L'Agora des Bibliothèques sonores de la région Centre - Val de Loire est un espace d'échange 
                        et de partage dédié à la communauté des Bibliothèques sonores de la région Centre - Val de Loire. 
                        Retrouvez ici les questions fréquentes et les informations utiles.
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
    .header-logo {
        height: 100%;
        max-height: 270px;
        object-fit: contain;
    }
    .header-bogo {
        height: 100%;
        max-height: 270px;
        object-fit: contain;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        /* Mobile view - stack elements vertically */
        .row.align-items-stretch {
            min-height: auto;
        }
        
        /* Remove the left shift on bogo for mobile */
        .header-bogo {
            transform: none !important;
            height: auto !important;
        }
        
        /* Adjust logo height for mobile */
        .header-logo {
            height: auto !important;
            max-height: 150px;
        }
        
        /* Mobile banner adjustments */
        .container-fluid.mt-5 {
            margin-top: 2rem !important;
        }
        
        /* Mobile login container */
        .col-md-2.d-flex.align-items-center.justify-content-end {
            margin-top: 1rem;
        }
    }
    
    @media (min-width: 768px) {
        /* Desktop: ensure banner row has fixed height */
        .row.align-items-stretch {
            min-height: 270px;
        }
    }
</style>
@endsection

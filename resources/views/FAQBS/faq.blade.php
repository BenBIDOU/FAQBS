@extends('layouts.app')

@section('title')
FAQ - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container-fluid" style="background: linear-gradient(135deg, #fafafa 0%, #f0dfdf 100%); min-height: 100vh;">
    <!-- Header moderne -->
    <div class="page-header mb-4" style="background-color: #FFFFFF; border-bottom: 2px solid #002D5D; padding: 1.5rem 0; margin-bottom: 1.5rem !important;">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 120px; margin-left: 6px;">
            </div>
            <div class="col text-center">
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">FAQ - Foire Aux Questions</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <!-- Message de bienvenue -->
    <div class="alert mb-4" style="background: #FFFFFF; border-left: 4px solid #002D5D; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill me-2" style="color: #002D5D; font-size: 1.2rem;"></i>
            <div>
                <h4 class="mb-1" style="color: #002D5D;">Bienvenue dans l'espace FAQ</h4>
                <p class="mb-0" style="color: #495057;">Retrouvez ici les questions fréquentes et les réponses des Bibliothèques sonores de la région Centre - Val de Loire.</p>
            </div>
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

    <!-- Zone de recherche -->
    <div class="mb-4">
        <div style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; padding: 1.2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="input-group">
                <span class="input-group-text" style="background: transparent; border: none; color: #002D5D;">
                    <i class="bi bi-search"></i>
                </span>
                <input type="text" class="form-control" placeholder="Rechercher dans la FAQ..." id="faqSearch" autocomplete="off" style="border: none; box-shadow: none; background: transparent;">
                <button class="btn" type="button" id="searchButton" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border-radius: 8px; transition: all 0.3s ease;">
                    <i class="bi bi-search me-1"></i> Rechercher
                </button>
            </div>
        </div>
    </div>

    <!-- Section FAQ par catégories -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-question-circle-fill me-2"></i> Questions Fréquentes
                    </h5>
                </div>
                <div class="card-body">
                    <div class="accordion" id="faqAccordion">
                        @foreach($faqs ?? [] as $category => $items)
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-transparent border-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ str_replace(' ', '_', $category) }}" aria-expanded="false" aria-controls="collapse{{ str_replace(' ', '_', $category) }}" style="color: #002D5D; font-weight: 500; padding: 12px 16px; border-radius: 6px; margin: 4px 8px; transition: all 0.2s ease;">
                                    <i class="bi bi-folder me-2"></i> {{ $category }}
                                </button>
                            </h2>
                            <div id="collapse{{ str_replace(' ', '_', $category) }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    @foreach($items as $faq)
                                    <a href="#" class="list-group-item list-group-item-action border-0 ps-4 discussion-link" style="display: block; padding: 8px 12px; margin: 4px 0; transition: all 0.2s ease; color: #495057; border-bottom: 1px solid rgba(0, 45, 93, 0.1);">
                                        <i class="bi bi-record-circle me-2" style="font-size: 0.7rem;"></i>{{ $faq['question'] ?? $faq }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation rapide -->
    <div class="row mb-4">
        <div class="col-md-12 text-center">
            <a href="/agora" class="btn btn-lg text-white px-5 py-3 shadow-lg" style="font-size: 1.2rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); box-shadow: 0 4px 15px rgba(0, 45, 93, 0.3); transition: all 0.3s ease; margin: 0 10px;">
                <i class="bi bi-chat-left me-2"></i> Aller à l'Agora
            </a>
            <a href="/poser-question" class="btn btn-lg text-white px-5 py-3 shadow-lg" style="font-size: 1.2rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #990000 0%, #A00000 100%); box-shadow: 0 4px 15px rgba(153, 0, 0, 0.3); transition: all 0.3s ease; margin: 0 10px;">
                <i class="bi bi-envelope me-2"></i> Poser une question
            </a>
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
@endsection
    /* Styles hérités du design Agora - couleurs mises à jour */
    .bg-bordeaux {
        background: linear-gradient(135deg, #990000 0%, #A00000 100%);
    }
    .text-bordeaux {
        color: #990000;
    }
    /* Styles pour le carrousel */
    #villeCarousel {
        max-height: 400px;
        overflow: hidden;
    }
    .carousel-text-overlay {
        position: absolute;
        bottom: 60px;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.6);
        padding: 20px 0;
        z-index: 10;
    }
    .carousel-text-overlay h2 {
        margin-bottom: 0;
        text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.8);
        font-weight: 500;
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
        }
        
        /* Make bogo image responsive in mobile */
        .bogo-img {
            max-height: 200px !important;
            height: auto !important;
        }
        
        /* Logo image mobile */
        .logo-img {
            max-height: 150px !important;
        }
        
        /* Mobile carousel adjustments */
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
        
        /* Mobile text spacing */
        .container-fluid.mt-5 {
            margin-top: 2rem !important;
        }
        .text-center.mb-4 {
            margin-bottom: 2rem !important;
        }
        
        /* Mobile login container */
        .col-12.d-md-none {
            margin-top: 1rem;
        }
    }
    
    @media (min-width: 768px) {
        /* Desktop: ensure bogo image fills the height */
        .bogo-img {
            height: 270px !important;
            max-height: 270px !important;
        }
        
        /* Desktop logo fills height */
        .logo-img {
            height: 270px;
            max-height: 270px;
        }
        
        /* Ensure banner row has fixed height */
        .row.align-items-stretch {
            min-height: 270px;
        }
        

    }
</style>


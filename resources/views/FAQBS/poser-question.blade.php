@extends('layouts.app')

@section('title')
Je pose ma question - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Poser une question</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <!-- Message d'introduction -->
    <div class="alert mb-4" style="background: #FFFFFF; border-left: 4px solid #002D5D; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div class="d-flex align-items-center">
            <i class="bi bi-info-circle-fill me-2" style="color: #002D5D; font-size: 1.2rem;"></i>
            <div>
                <h4 class="mb-1" style="color: #002D5D;">Posez votre question</h4>
                <p class="mb-0" style="color: #495057;">Utilisez ce formulaire pour poser votre question à la communauté. Nous vous répondrons dans les plus brefs délais.</p>
            </div>
        </div>
    </div>

    <!-- Formulaire de question -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-envelope me-2"></i> Je pose ma question
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('questions.store') }}" id="questionForm">
                        @csrf
                        
                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="name" class="form-label" style="color: #002D5D; font-weight: 500;">Votre nom</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label" style="color: #002D5D; font-weight: 500;">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <!-- Equipe concernée -->
                        <div class="mb-3">
                            <label for="team" class="form-label" style="color: #002D5D; font-weight: 500;">Équipe concernée</label>
                            <select class="form-select" id="team" name="team" required style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                                <option value="" selected disabled>Sélectionnez une équipe</option>
                                <option value="Président">Président</option>
                                <option value="Secrétariat">Secrétariat</option>
                                <option value="Trésorerie">Trésorerie</option>
                                <option value="Donneurs de Voix">Donneurs de Voix</option>
                                <option value="Donneurs de Temps">Donneurs de Temps</option>
                            </select>
                        </div>
                        
                        <!-- Message -->
                        <div class="mb-3">
                            <label for="message" class="form-label" style="color: #002D5D; font-weight: 500;">Ma question</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;"></textarea>
                        </div>

                        <!-- Boutons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-between mt-4">
                            <a href="/agora" class="btn btn-outline-primary text-primary" style="border: 1px solid #002D5D; color: #002D5D !important; border-radius: 8px; transition: all 0.2s ease;">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>
                            <button type="reset" class="btn btn-outline-secondary" style="border-radius: 8px; transition: all 0.2s ease;">
                                <i class="bi bi-x-circle me-1"></i> Réinitialiser
                            </button>
                            <button type="submit" class="btn text-white" style="border-radius: 8px; transition: all 0.3s ease; background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none;">
                                <i class="bi bi-send me-1"></i> Envoyer ma question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Style des champs de formulaire */
    .form-control:focus, .form-select:focus {
        border-color: #990000;
        box-shadow: 0 0 0 0.25rem rgba(153, 0, 0, 0.15);
    }
    
    /* Style des boutons */
    .btn-outline-primary:hover {
        background: #002D5D;
        color: white !important;
        border-color: #002D5D;
    }
    
    .btn-outline-secondary:hover {
        background: #6c757d;
        color: white;
        border-color: #6c757d;
    }
    
    /* Responsive */
    @media (max-width: 767.98px) {
        .d-grid.gap-2.d-md-flex.justify-content-md-between {
            grid-template-columns: 1fr;
        }
        .d-grid.gap-2.d-md-flex.justify-content-md-between > * {
            width: 100%;
            margin-bottom: 10px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('questionForm');
        if (form) {
            form.addEventListener('submit', function() {
                // Désactiver le bouton et afficher un indicateur de chargement
                const submitBtn = form.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Envoi en cours...';
                }
            });
        }
    });
</script>

<!-- Redirection automatique après soumission réussie -->
@if(session('success'))
    <script>
        window.location.href = '{{ route("agora") }}';
    </script>
@endif
@endsection

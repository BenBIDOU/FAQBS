@extends('layouts.app')

@section('title', 'Je pose ma question - Bibliothèques Sonores')

@section('content')
<div class="container-fluid">
    <!-- Logo et titre -->
    <div class="row align-items-center mb-4">
        <div class="col-auto">
            <img src="{{ asset('images/logo.png') }}" alt="Bibliothèques Sonores de France" class="img-fluid" style="max-height: 100px;">
        </div>
        <div class="col">
            <h1 class="mb-1">Poser une question</h1>
        </div>
    </div>

    <!-- Message d'introduction -->
    <div class="alert alert-info mb-4">
        <p>Utilisez ce formulaire pour poser votre question à l'association. Nous vous répondrons dans les plus brefs délais.</p>
    </div>

    <!-- Je pose ma question -->
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-bordeaux text-white">
                    <h4 class="mb-0">Je pose ma question</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('questions.store') }}" id="questionForm">
                        @csrf
                        
                        <!-- Nom -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Votre nom</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email }}" required>
                        </div>

                        <!-- Equipe concernée -->
                        <div class="mb-3">
                            <label for="team" class="form-label">Equipe concernée</label>
                            <select class="form-select" id="team" name="team" required>
                                <option value="" selected disabled>Sélectionnez une équipe</option>
                                <option value="Donneurs de Voix">Donneurs de Voix</option>
                                <option value="Donneurs de Temps">Donneurs de Temps</option>
                                <option value="Secrétariat">Secrétariat</option>
                                <option value="Président">Président</option>
                            </select>
                        </div>

                        <!-- Objet -->
                        <div class="mb-3">
                            <label for="subject" class="form-label">Objet</label>
                            <textarea class="form-control" id="subject" name="subject" rows="1" required></textarea>
                        </div>

                        <!-- Message -->
                        <div class="mb-3">
                            <label for="message" class="form-label">Votre message</label>
                            <textarea class="form-control" id="message" name="message" rows="6" required></textarea>
                        </div>

                        <!-- Boutons -->
                        <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                            <a href="/agora" class="btn btn-outline-bordeaux text-bordeaux">
                                <i class="bi bi-arrow-left me-1"></i> Retour
                            </a>
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-bordeaux text-white" style="box-shadow: 0 4px 8px rgba(0,0,0,0.3); transition: all 0.3s ease;">
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
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .btn-bordeaux {
        background-color: #6D071A;
        border-color: #6D071A;
    }
    .btn-bordeaux:hover {
        background-color: #5a0514;
        border-color: #5a0514;
    }
    .btn-outline-bordeaux {
        border-color: #6D071A;
        color: #6D071A;
    }
    .btn-outline-bordeaux:hover {
        background-color: #6D071A;
        color: white;
        border-color: #6D071A;
    }
</style>
@endsection

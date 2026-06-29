@extends('layouts.app')

@section('title', 'Répondre à la question - Bibliothèques Sonores')

@section('content')
<div class="container-fluid">
    <!-- Logo et titre -->
    <div class="row align-items-center mb-4">
        <div class="col-auto">
            <img src="{{ asset('images/logo.png') }}" alt="Bibliothèques Sonores de France" class="img-fluid" style="max-height: 100px;">
        </div>
        <div class="col">
            <h1 class="mb-1">Répondre à la question</h1>
            <h2 class="text-muted mb-0">Bibliothèques Sonores - Centre Val de Loire</h2>
        </div>
    </div>

    <!-- Carte de la question originale -->
    <div class="row justify-content-center mb-4">
        <div class="col-12">
            <div class="card border-bordeaux">
                <div class="card-header bg-bordeaux-light text-white">
                    <h5 class="mb-0">Question originale #{{ $question->id }}</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>De :</strong> {{ $question->name }} ({{ $question->email }})</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Équipe :</strong> {{ $question->team }}</p>
                        </div>
                    </div>
                    <p><strong>Objet :</strong> {{ $question->subject }}</p>
                    <div class="bg-light p-3 rounded-3">
                        <p class="mb-0">{{ $question->message }}</p>
                    </div>
                    <p class="text-muted small"><em>Posée le {{ $question->created_at->format('d/m/Y H:i') }}</em></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulaire de réponse -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Votre réponse</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="#">
                        @csrf
                        <input type="hidden" name="question_id" value="{{ $question->id }}">
                        
                        <div class="mb-3">
                            <label for="response" class="form-label">Votre réponse</label>
                            <textarea class="form-control" id="response" name="response" rows="8" required></textarea>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i> Réinitialiser
                            </button>
                            <button type="submit" class="btn btn-primary text-white">
                                <i class="bi bi-send me-1"></i> Envoyer la réponse
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Boutons de retour -->
    <div class="row justify-content-center mt-4">
        <div class="col-md-8 col-lg-6">
            <div class="d-flex gap-3">
                <a href="/questions-en-attente/{{ $question->team }}" class="btn btn-bordeaux text-white">
                    <i class="bi bi-folder me-2"></i> Retour aux questions de l'équipe
                </a>
                <a href="/questions-en-attente/{{ $question->id }}/details" class="btn btn-outline-bordeaux text-bordeaux">
                    <i class="bi bi-arrow-left me-2"></i> Retour aux détails
                </a>
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
    .bg-primary {
        background-color: #007bff;
    }
    .btn-bordeaux {
        background-color: #6D071A;
        border-color: #6D071A;
        color: white;
    }
    .btn-bordeaux:hover {
        background-color: #5a0514;
        border-color: #5a0514;
    }
    .btn-outline-bordeaux {
        color: #6D071A;
        border-color: #6D071A;
    }
    .btn-outline-bordeaux:hover {
        background-color: #6D071A;
        color: white;
    }
    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@endsection

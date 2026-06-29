@extends('layouts.app')

@section('title', 'Détails de la question - Bibliothèques Sonores')

@section('content')
<div class="container-fluid">
    <!-- Logo et titre -->
    <div class="row align-items-center mb-4">
        <div class="col-auto">
            <img src="{{ asset('images/logo.png') }}" alt="Bibliothèques Sonores de France" class="img-fluid" style="max-height: 100px;">
        </div>
        <div class="col">
            <h1 class="mb-1">Détails de la question</h1>
        </div>
    </div>

    <!-- Carte des détails de la question -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg">
                <div class="card-header bg-bordeaux text-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Question #{{ $question->id }}</h4>
                    <span class="badge bg-light text-dark">{{ $question->team }}</span>
                </div>
                <div class="card-body">
                    <!-- Nom et Email -->
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-person me-2"></i>Nom :</label>
                                    <p class="mb-0">{{ $question->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-envelope me-2"></i>Email :</label>
                                    <p class="mb-0">{{ $question->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold"><i class="bi bi-people me-2"></i>Équipe concernée :</label>
                                    <p class="mb-0">{{ $question->team }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-calendar me-2"></i>Date :</label>
                        <p class="mb-0">{{ $question->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <!-- Objet -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-chat-square-text me-2"></i>Objet :</label>
                        <p class="mb-0">{{ $question->subject }}</p>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-file-text me-2"></i>Message :</label>
                        <div class="p-3 bg-light rounded-3">
                            <p class="mb-0">{{ $question->message }}</p>
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-check-circle me-2"></i>Statut :</label>
                        <p class="mb-0">
                            @if($question->resolved)
                                <span class="badge bg-success">Résolue</span>
                            @else
                                <span class="badge bg-warning text-dark">En attente</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="row justify-content-center mt-2">
        <div class="col-md-8 col-lg-6">
            <div class="d-flex gap-3 mb-4">
                <a href="{{ route('questions.reply', ['question' => $question->id]) }}" class="btn btn-primary btn-lg text-white w-50" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
                    <i class="bi bi-reply me-1"></i> Répondre
                </a>
                <a href="{{ route('discussion.create') }}?title={{ urlencode($question->subject) }}&group={{ urlencode($question->team) }}&content={{ urlencode($question->message) }}" class="btn btn-success btn-lg text-white w-50" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
                    <i class="bi bi-chat-square-text me-1"></i> Ouvrir la discussion
                </a>
            </div>
            <div class="d-flex gap-3">
                <a href="/questions-en-attente/{{ $question->team }}" class="btn btn-outline-bordeaux text-bordeaux">
                    <i class="bi bi-folder me-2"></i> Retour aux questions de l'équipe
                </a>
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
</style>
@endsection

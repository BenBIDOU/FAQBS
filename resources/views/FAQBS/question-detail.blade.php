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
                    
                    <!-- Résolue par -->
                    @if($question->resolved && $question->resolver)
                    <div class="mb-4">
                        <label class="form-label fw-bold"><i class="bi bi-person-check me-2"></i>Résolue par :</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-2" alt="Résolveur" width="24" height="24">
                            <p class="mb-0">{{ $question->resolver->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        </div>
    </div>

    <!-- Boutons d'action -->
    <div class="row justify-content-center mt-2">
        <div class="col-md-8 col-lg-6">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="d-flex gap-3 mb-4">
                <a href="{{ route('questions.reply', ['question' => $question->id]) }}" class="btn btn-lg text-white w-50 gemme-btn-primary" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
                    <i class="bi bi-reply me-1"></i> Répondre
                </a>
                <a href="{{ route('discussion.create', ['subject' => $question->subject, 'group' => $question->team, 'content' => $question->message]) }}" class="btn btn-lg text-white w-50 gemme-btn-success" style="padding-top: 1.5rem; padding-bottom: 1.5rem;">
                    <i class="bi bi-chat-square-text me-1"></i> Ouvrir la discussion
                </a>
            </div>
            <div class="d-flex gap-3">
                @if(!$question->resolved)
                    <form action="{{ route('questions.resolve', ['question' => $question->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" title="Marquer comme résolue">
                            <i class="bi bi-check-circle me-2"></i> Marquer comme résolue
                        </button>
                    </form>
                @endif
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
    /* Effet Gemme pour les boutons */
    .gemme-btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 50%, #007bff 100%);
        background-size: 200% 200%;
        border: none;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.4);
    }
    .gemme-btn-primary:hover {
        background-position: 100% 100%;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 123, 255, 0.6);
    }
    .gemme-btn-primary::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .gemme-btn-primary:hover::before {
        left: 100%;
    }
    .gemme-btn-success {
        background: linear-gradient(135deg, #28a745 0%, #218838 50%, #28a745 100%);
        background-size: 200% 200%;
        border: none;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
    }
    .gemme-btn-success:hover {
        background-position: 100% 100%;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(40, 167, 69, 0.6);
    }
    .gemme-btn-success::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s ease;
    }
    .gemme-btn-success:hover::before {
        left: 100%;
    }
</style>
@endsection

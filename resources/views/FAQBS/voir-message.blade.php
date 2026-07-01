@extends('layouts.app')

@section('title', 'Message - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-envelope-open me-2"></i>
                        {{ $message->subject }}
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Informations sur l'expéditeur et la date -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if($message->sender->photo)
                                <img src="{{ asset('storage/' . $message->sender->photo) }}" alt="Photo" 
                                     class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px;">
                                    <i class="bi bi-person text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            @endif
                            <div>
                                <strong class="d-block">{{ $message->sender->name ?? 'Inconnu' }}</strong>
                                <small class="text-muted">{{ $message->sender->email ?? '' }}</small>
                            </div>
                        </div>
                        <div class="text-muted small">
                            {{ $message->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>

                    <!-- Statut du message -->
                    @if($message->is_read)
                        <div class="alert alert-info mb-4" style="background-color: rgba(40, 167, 69, 0.1); border-color: #28a745; color: #28a745;">
                            <i class="bi bi-check-circle me-2"></i>
                            Message marqué comme lu
                        </div>
                    @else
                        <div class="alert alert-warning mb-4" style="background-color: rgba(255, 193, 7, 0.1); border-color: #ffc107; color: #ffc107;">
                            <i class="bi bi-exclamation-circle me-2"></i>
                            Nouveau message
                        </div>
                    @endif

                    <!-- Contenu du message -->
                    <div class="card bg-light mb-4">
                        <div class="card-body" style="white-space: pre-line;">
                            {{ $message->content }}
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('messages.inbox') }}" class="btn btn-outline-bordeaux text-bordeaux">
                            <i class="bi bi-arrow-left me-1"></i> Retour à la boîte de réception
                        </a>
                        <form action="{{ route('messages.destroy', $message->id) }}" method="POST"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" style="color: #dc3545; border-color: #dc3545;">
                                <i class="bi bi-trash me-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
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
        color: white;
    }
    .btn-bordeaux:hover {
        background-color: #8a091e;
        border-color: #8a091e;
    }
    .btn-outline-bordeaux {
        color: #ff9999;
        border-color: #6D071A;
    }
    .btn-outline-bordeaux:hover {
        background-color: #6D071A;
        color: white;
        border-color: #6D071A;
    }
    .text-bordeaux {
        color: #ff9999;
    }
    .card {
        background-color: #252525;
        border-color: #444;
    }
    .card-body {
        background-color: #252525;
        color: #e0e0e0;
    }
    .card-header {
        background-color: #1a1a1a;
    }
    .text-muted {
        color: #999 !important;
    }
    .bg-light {
        background-color: #2d2d2d !important;
        color: #e0e0e0 !important;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

@endsection
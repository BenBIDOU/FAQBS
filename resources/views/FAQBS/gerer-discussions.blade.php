@extends('layouts.app')

@section('title', 'Gérer les discussions - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-chat-square-text me-2"></i>
                        Gestion des discussions
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #28a745; color: white; border: none;">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dc3545; color: white; border: none;">
                            {{ session('error') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="text-muted mb-0">Liste de toutes les discussions</p>
                        <a href="/agora" class="btn btn-outline-bordeaux text-bordeaux">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                    
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="{{ route('discussion.create') }}" class="btn btn-bordeaux text-white">
                            <i class="bi bi-plus-circle me-2"></i> Ajouter une discussion
                        </a>
                    </div>

                    @if($discussions->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-chat-square-text text-muted" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mt-3">Aucune discussion trouvée</h5>
                            <p class="text-muted">Commencez par ajouter une nouvelle discussion.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light" style="background-color: #2d2d2d; color: #e0e0e0;">
                                    <tr>
                                        <th>Titre</th>
                                        <th>Groupe</th>
                                        <th>Auteur</th>
                                        <th>Date de création</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($discussions as $discussion)
                                        <tr style="background-color: #2d2d2d; color: #e0e0e0; border-color: #444;">
                                            <td>
                                                <strong>{{ $discussion->title }}</strong>
                                                @if($discussion->link)
                                                    <div class="text-muted small">
                                                        <i class="bi bi-link-45deg"></i> 
                                                        <a href="{{ $discussion->link }}" target="_blank" class="text-decoration-none" style="color: #999;">Lien</a>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $discussion->group }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($discussion->user)
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-1" alt="Auteur" width="20" height="20">
                                                        <small>{{ $discussion->user->name }}</small>
                                                    </div>
                                                @else
                                                    <small class="text-muted">Inconnu</small>
                                                @endif
                                            </td>
                                            <td>{{ $discussion->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('discussions.show', $discussion->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Voir" style="color: #0dcaf0; border-color: #0dcaf0;">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('discussions.edit', $discussion->id) }}" 
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Modifier" style="color: #ffc107; border-color: #ffc107;">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette discussion ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Supprimer" style="color: #dc3545; border-color: #dc3545;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
    .btn-outline-info {
        color: #0dcaf0;
        border-color: #0dcaf0;
    }
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #1a1a1a;
        border-color: #0dcaf0;
    }
    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #1a1a1a;
        border-color: #ffc107;
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
    .table {
        --bs-table-bg: transparent;
        --bs-table-color: #e0e0e0;
        --bs-table-border-color: #444;
        --bs-table-hover-bg: #3a3a3a;
        --bs-table-hover-color: #e0e0e0;
    }
    .table-light {
        --bs-table-bg-type: rgba(255, 255, 255, 0.05);
        color: #e0e0e0;
        background-color: #2d2d2d;
    }
    .badge {
        font-size: 0.85em;
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

@endsection

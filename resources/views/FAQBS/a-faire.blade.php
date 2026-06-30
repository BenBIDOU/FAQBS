@extends('layouts.app')

@section('title', 'À faire - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-clipboard-check me-2"></i>
                        Liste des tâches à faire
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #28a745; color: white; border: none;">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="text-muted mb-0">Tâches à réaliser pour l'administration</p>
                        <a href="/espace-membre" class="btn btn-outline-bordeaux text-bordeaux">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    <!-- Liste des tâches -->
                    @if($tasks->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mt-3">Aucune tâche trouvée</h5>
                            <p class="text-muted">Ajoutez votre première tâche avec le formulaire ci-dessous.</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($tasks as $task)
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">{{ $task->title }}</h6>
                                            @if($task->description)
                                                <small class="text-muted d-block">{{ Str::limit($task->description, 60) }}</small>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <!-- Bouton Modifier -->
                                            <button class="btn btn-sm btn-outline-warning" 
                                                    title="Modifier"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTaskModal-{{ $task->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            
                                            <!-- Bouton Supprimer -->
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        title="Supprimer"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal pour modifier la tâche -->
                                    <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="background-color: #252525; color: #e0e0e0;">
                                                <div class="modal-header" style="border-bottom-color: #444;">
                                                    <h5 class="modal-title">Modifier la tâche</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="title-{{ $task->id }}" class="form-label">Titre</label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="title-{{ $task->id }}"
                                                                   name="title"
                                                                   value="{{ old('title', $task->title) }}"
                                                                   required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description-{{ $task->id }}" class="form-label">Description</label>
                                                            <textarea class="form-control" 
                                                                      id="description-{{ $task->id }}"
                                                                      name="description"
                                                                      rows="3">{{ old('description', $task->description) }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="order-{{ $task->id }}" class="form-label">Ordre</label>
                                                            <input type="number" 
                                                                   class="form-control"
                                                                   id="order-{{ $task->id }}"
                                                                   name="order"
                                                                   value="{{ old('order', $task->order) }}"
                                                                   min="0">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="border-top-color: #444;">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                                            Annuler
                                                        </button>
                                                        <button type="submit" class="btn btn-bordeaux text-white">
                                                            <i class="bi bi-check-lg me-1"></i> Enregistrer
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Formulaire pour ajouter une tâche -->
                    <div class="mt-4 card border-0">
                        <div class="card-body" style="background-color: #2d2d2d;">
                            <h6 class="mb-3 d-flex align-items-center">
                                <i class="bi bi-plus-circle me-2 text-bordeaux"></i>
                                Ajouter une nouvelle tâche
                            </h6>
                            <form method="POST" action="{{ route('tasks.store') }}">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" 
                                               placeholder="Titre de la tâche..." 
                                               name="title" 
                                               value="{{ old('title') }}" 
                                               required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" 
                                               placeholder="Ordre (0, 1, 2...)" 
                                               name="order" 
                                               value="{{ old('order', 0) }}" 
                                               min="0">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-bordeaux text-white w-100">
                                            <i class="bi bi-check-lg me-1"></i> Ajouter
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <textarea class="form-control" 
                                              placeholder="Description (optionnelle)..." 
                                              name="description" 
                                              rows="2">{{ old('description') }}</textarea>
                                </div>
                            </form>
                        </div>
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
    .list-group-item {
        background-color: #2d2d2d;
        border-color: #444;
        color: #e0e0e0;
        transition: all 0.2s;
    }
    .list-group-item:hover {
        background-color: #3a3a3a;
        cursor: pointer;
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
    .btn-outline-warning {
        color: #ffc107;
        border-color: #ffc107;
    }
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #1a1a1a;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
    }
    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
    }
    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
    }
    .btn-outline-light {
        color: #f8f9fa;
        border-color: #f8f9fa;
    }
    .btn-outline-light:hover {
        background-color: #f8f9fa;
        color: #1a1a1a;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
    .btn-outline-secondary:disabled {
        opacity: 0.5;
    }
    .bg-light {
        background-color: #2d2d2d !important;
        color: #e0e0e0 !important;
    }
    .form-control {
        background-color: #333;
        border-color: #555;
        color: #e0e0e0;
    }
    .form-control:focus {
        background-color: #333;
        border-color: #6D071A;
        color: #e0e0e0;
        box-shadow: 0 0 0 0.25rem rgba(109, 7, 26, 0.25);
    }
    .form-control::placeholder {
        color: #888;
    }
    .modal-content {
        background-color: #252525;
        color: #e0e0e0;
    }
    .modal-header, .modal-footer {
        border-color: #444;
    }
    .form-check-input {
        background-color: #333;
        border-color: #555;
    }
    .form-check-input:checked {
        background-color: #6D071A;
        border-color: #6D071A;
    }
</style>
@endsection

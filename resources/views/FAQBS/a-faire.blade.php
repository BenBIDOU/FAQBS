@extends('layouts.app')

@section('title')
À faire - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Tâches à faire</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h4 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-clipboard-check me-2"></i>
                        Liste des tâches à faire
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert mb-4" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 12px 16px;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle me-2" style="color: #28A745; font-size: 1.2rem;"></i>
                                <span style="color: #155724; font-weight: 500;">{{ session('success') }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="mb-0" style="color: #6c757d;">Tâches à réaliser pour l'administration</p>
                        <a href="/agora" class="btn btn-outline-primary text-primary">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    <!-- Liste des tâches -->
                    @if($tasks->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-clipboard-x text-muted" style="font-size: 4rem; color: #6c757d !important;"></i>
                            <h5 class="text-muted mt-3" style="color: #6c757d !important;">Aucune tâche trouvée</h5>
                            <p class="text-muted" style="color: #6c757d !important;">Ajoutez votre première tâche avec le formulaire ci-dessous.</p>
                        </div>
                    @else
                        <div class="list-group">
                            @foreach($tasks as $task)
                                <div class="list-group-item" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px; margin-bottom: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1" style="color: #002D5D;">{{ $task->title }}</h6>
                                            @if($task->description)
                                                <small class="text-muted d-block" style="color: #6c757d !important;">{{ Str::limit($task->description, 60) }}</small>
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2">
                                            <!-- Bouton Modifier -->
                                            <button class="btn btn-sm" 
                                                    title="Modifier"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#editTaskModal-{{ $task->id }}"
                                                    style="background: rgba(255, 193, 7, 0.1); border: 1px solid #FFC107; color: #856404; border-radius: 6px; transition: all 0.2s ease;">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            
                                            <!-- Bouton Supprimer -->
                                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm"
                                                        title="Supprimer"
                                                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette tâche ?')"
                                                        style="background: rgba(220, 53, 69, 0.1); border: 1px solid #dc3545; color: #721c24; border-radius: 6px; transition: all 0.2s ease;">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    
                                    <!-- Modal pour modifier la tâche -->
                                    <div class="modal fade" id="editTaskModal-{{ $task->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="background: #FFFFFF; border-radius: 10px; border: 1px solid #E9ECEF; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                                <div class="modal-header" style="border-bottom: 1px solid #E9ECEF; padding: 16px 24px;">
                                                    <h5 class="modal-title" style="color: #002D5D;">Modifier la tâche</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="filter: none;"></button>
                                                </div>
                                                <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body" style="padding: 24px;">
                                                        <div class="mb-3">
                                                            <label for="title-{{ $task->id }}" class="form-label" style="color: #002D5D; font-weight: 500;">Titre</label>
                                                            <input type="text" 
                                                                   class="form-control" 
                                                                   id="title-{{ $task->id }}"
                                                                   name="title"
                                                                   value="{{ old('title', $task->title) }}"
                                                                   required
                                                                   style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description-{{ $task->id }}" class="form-label" style="color: #002D5D; font-weight: 500;">Description</label>
                                                            <textarea class="form-control" 
                                                                      id="description-{{ $task->id }}"
                                                                      name="description"
                                                                      rows="3"
                                                                      style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">{{ old('description', $task->description) }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="order-{{ $task->id }}" class="form-label" style="color: #002D5D; font-weight: 500;">Ordre</label>
                                                            <input type="number" 
                                                                   class="form-control"
                                                                   id="order-{{ $task->id }}"
                                                                   name="order"
                                                                   value="{{ old('order', $task->order) }}"
                                                                   min="0"
                                                                   style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer" style="border-top: 1px solid #E9ECEF; padding: 16px 24px;">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="color: #6c757d; border-color: #6c757d; border-radius: 6px; padding: 8px 16px;">
                                                            Annuler
                                                        </button>
                                                        <button type="submit" class="btn" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border: none; border-radius: 6px; padding: 8px 24px; transition: all 0.3s ease;">
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
                    <div class="mt-4 card border-0" style="background: transparent;">
                        <div class="card-body" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px; padding: 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
                            <h6 class="mb-3 d-flex align-items-center" style="color: #002D5D; font-weight: 600;">
                                <i class="bi bi-plus-circle me-2" style="color: #990000;"></i>
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
                                               required
                                               style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="number" class="form-control" 
                                               placeholder="Ordre (0, 1, 2...)" 
                                               name="order" 
                                               value="{{ old('order', 0) }}" 
                                               min="0"
                                               style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn w-100" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white; border: none; border-radius: 6px; padding: 12px 16px; transition: all 0.3s ease; font-weight: 500;">
                                            <i class="bi bi-check-lg me-1"></i> Ajouter
                                        </button>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <textarea class="form-control" 
                                              placeholder="Description (optionnelle)..." 
                                              name="description" 
                                              rows="2"
                                              style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">{{ old('description') }}</textarea>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
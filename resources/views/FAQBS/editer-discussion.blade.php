@extends('layouts.app')

@section('title', 'Modifier la discussion - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier la discussion
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('discussions.update', $discussion->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label">Titre *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title', $discussion->title) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="group" class="form-label">Groupe *</label>
                            <select class="form-select" id="group" name="group" required>
                                <option value="">Sélectionnez un groupe</option>
                                <option value="Secrétariat" {{ old('group', $discussion->group) == 'Secrétariat' ? 'selected' : '' }}>Secrétariat</option>
                                <option value="Président" {{ old('group', $discussion->group) == 'Président' ? 'selected' : '' }}>Président</option>
                                <option value="Donneurs Temps" {{ old('group', $discussion->group) == 'Donneurs Temps' ? 'selected' : '' }}>Donneurs Temps</option>
                                <option value="Donneurs Voix" {{ old('group', $discussion->group) == 'Donneurs Voix' ? 'selected' : '' }}>Donneurs Voix</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label">Lien (optionnel)</label>
                            <input type="url" class="form-control" id="link" name="link" 
                                   value="{{ old('link', $discussion->link) }}">
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu *</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required>{{ old('content', $discussion->content) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optionnelle)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            @if($discussion->image_path)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $discussion->image_path) }}" alt="Image actuelle" 
                                         style="max-width: 100px; max-height: 100px; border-radius: 4px;" class="img-thumbnail">
                                    <small class="text-muted d-block">Image actuelle</small>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('discussions.manage') }}" class="btn btn-outline-bordeaux text-bordeaux">
                                <i class="bi bi-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-bordeaux text-white">
                                <i class="bi bi-check-lg me-1"></i> Enregistrer les modifications
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
    .form-control, .form-select {
        background-color: #333;
        border-color: #555;
        color: #e0e0e0;
    }
    .form-control:focus, .form-select:focus {
        background-color: #333;
        border-color: #6D071A;
        color: #e0e0e0;
        box-shadow: 0 0 0 0.25rem rgba(109, 7, 26, 0.25);
    }
    .form-control::placeholder {
        color: #888;
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

@endsection
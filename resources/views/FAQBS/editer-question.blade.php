@extends('layouts.app')

@section('title', 'Modifier une question - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card" style="background-color: #252525; border-color: #444;">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier une question
                    </h4>
                </div>
                <div class="card-body" style="background-color: #252525; color: #e0e0e0;">
                    <form method="POST" action="{{ route('questions.update', $question->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $question->name) }}" required
                                   style="background-color: #333; color: #e0e0e0; border-color: #444;">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $question->email) }}" required
                                   style="background-color: #333; color: #e0e0e0; border-color: #444;">
                        </div>

                        <div class="mb-3">
                            <label for="team" class="form-label">Équipe *</label>
                            <select class="form-select" id="team" name="team" required
                                    style="background-color: #333; color: #e0e0e0; border-color: #444;">
                                <option value="" disabled>Sélectionnez une équipe</option>
                                <option value="Président" {{ old('team', $question->team) == 'Président' ? 'selected' : '' }}>Président</option>
                                <option value="Secrétariat" {{ old('team', $question->team) == 'Secrétariat' ? 'selected' : '' }}>Secrétariat</option>
                                <option value="Donneurs de Voix" {{ old('team', $question->team) == 'Donneurs de Voix' ? 'selected' : '' }}>Donneurs de Voix</option>
                                <option value="Donneurs de Temps" {{ old('team', $question->team) == 'Donneurs de Temps' ? 'selected' : '' }}>Donneurs de Temps</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet *</label>
                            <input type="text" class="form-control" id="subject" name="subject" 
                                   value="{{ old('subject', $question->subject) }}" required
                                   style="background-color: #333; color: #e0e0e0; border-color: #444;">
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required
                                      style="background-color: #333; color: #e0e0e0; border-color: #444;">{{ old('message', $question->message) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('gestion-questions') }}" class="btn btn-outline-secondary"
                               style="color: #6c757d; border-color: #6c757d;">
                                <i class="bi bi-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-bordeaux">
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
    .form-control:focus, .form-select:focus {
        background-color: #333;
        color: #e0e0e0;
        border-color: #6D071A;
        box-shadow: 0 0 0 0.25rem rgba(109, 7, 26, 0.25);
    }
    .form-label {
        color: #e0e0e0;
    }
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }
</style>
@endsection

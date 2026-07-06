@extends('layouts.app')

@section('title')
Modifier une question - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Modifier une question</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier une question
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('questions.update', $question->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label" style="color: #002D5D; font-weight: 500;">Nom *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $question->name) }}" required
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" style="color: #002D5D; font-weight: 500;">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $question->email) }}" required
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="mb-3">
                            <label for="team" class="form-label" style="color: #002D5D; font-weight: 500;">Équipe *</label>
                            <select class="form-select" id="team" name="team" required
                                    style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                                <option value="" disabled>Sélectionnez une équipe</option>
                                <option value="Président" {{ old('team', $question->team) == 'Président' ? 'selected' : '' }}>Président</option>
                                <option value="Secrétariat" {{ old('team', $question->team) == 'Secrétariat' ? 'selected' : '' }}>Secrétariat</option>
                                <option value="Trésorerie" {{ old('team', $question->team) == 'Trésorerie' ? 'selected' : '' }}>Trésorerie</option>
                                <option value="Donneurs de Voix" {{ old('team', $question->team) == 'Donneurs de Voix' ? 'selected' : '' }}>Donneurs de Voix</option>
                                <option value="Donneurs de Temps" {{ old('team', $question->team) == 'Donneurs de Temps' ? 'selected' : '' }}>Donneurs de Temps</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="message" class="form-label" style="color: #002D5D; font-weight: 500;">Message *</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required
                                      style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">{{ old('message', $question->message) }}</textarea>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('gestion-questions') }}" class="btn btn-outline-primary text-primary"
                               style="border: 1px solid #002D5D; color: #002D5D !important; border-radius: 8px; transition: all 0.2s ease;">
                                <i class="bi bi-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-main text-white" style="border-radius: 8px;">
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
    /* Style des champs de formulaire */
    .form-control:focus, .form-select:focus {
        border-color: #990000;
        box-shadow: 0 0 0 0.25rem rgba(153, 0, 0, 0.15);
    }
    
    /* Style des boutons */
    .btn-outline-primary:hover {
        background: #002D5D;
        color: white !important;
        border-color: #002D5D;
    }
</style>
@endsection

@extends('layouts.app')

@section('title', 'Modifier un membre - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier un membre
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('membres.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Nom *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $user->name) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" 
                                   value="{{ old('telephone', $user->telephone) }}">
                        </div>

                        <div class="mb-3">
                            <label for="ville_bs" class="form-label">Ville</label>
                            <input type="text" class="form-control" id="ville_bs" name="ville_bs" 
                                   value="{{ old('ville_bs', $user->ville_bs) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rôles</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_master" name="is_master" 
                                           value="1" {{ old('is_master', $user->is_master) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_master">Master</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_voice_donor" name="is_voice_donor" 
                                           value="1" {{ old('is_voice_donor', $user->is_voice_donor) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_voice_donor">Donneur de voix</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_president" name="is_president" 
                                           value="1" {{ old('is_president', $user->is_president) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_president">Président</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Accès actif</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    {{ $user->is_active ?? true ? 'Accès autorisé' : 'Accès suspendu' }}
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('membres.manage') }}" class="btn btn-outline-bordeaux text-bordeaux">
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
    .form-check-input {
        background-color: #333;
        border-color: #555;
    }
    .form-check-input:checked {
        background-color: #6D071A;
        border-color: #6D071A;
    }
    .form-switch .form-check-input {
        width: 2em;
        height: 1em;
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

@endsection
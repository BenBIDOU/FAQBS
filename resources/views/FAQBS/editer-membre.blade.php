@extends('layouts.app')

@section('title')
Modifier un membre - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Modifier un membre</h1>
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
                        Modifier un membre
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('membres.update', $user->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label" style="color: #002D5D; font-weight: 500;">Nom *</label>
                            <input type="text" class="form-control" id="name" name="name" 
                                   value="{{ old('name', $user->name) }}" required
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label" style="color: #002D5D; font-weight: 500;">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="{{ old('email', $user->email) }}" required
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="mb-3">
                            <label for="telephone" class="form-label" style="color: #002D5D; font-weight: 500;">Téléphone</label>
                            <input type="text" class="form-control" id="telephone" name="telephone" 
                                   value="{{ old('telephone', $user->telephone) }}"
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="mb-3">
                            <label for="ville_bs" class="form-label" style="color: #002D5D; font-weight: 500;">Ville</label>
                            <input type="text" class="form-control" id="ville_bs" name="ville_bs" 
                                   value="{{ old('ville_bs', $user->ville_bs) }}"
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #002D5D; font-weight: 500;">Rôles</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_master" name="is_master" 
                                           value="1" {{ old('is_master', $user->is_master) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_master" style="color: #495057;">Master</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_voice_donor" name="is_voice_donor" 
                                           value="1" {{ old('is_voice_donor', $user->is_voice_donor) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_voice_donor" style="color: #495057;">Donneur de voix</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_president" name="is_president" 
                                           value="1" {{ old('is_president', $user->is_president) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_president" style="color: #495057;">Président</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #002D5D; font-weight: 500;">Accès actif</label>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                       value="1" {{ old('is_active', $user->is_active ?? true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active" style="color: #495057;">
                                    {{ $user->is_active ?? true ? 'Accès autorisé' : 'Accès suspendu' }}
                                </label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label" style="color: #002D5D; font-weight: 500;">Nouveau mot de passe (laisser vide pour ne pas changer)</label>
                            <input type="password" class="form-control" id="password" name="password"
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label" style="color: #002D5D; font-weight: 500;">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                   style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('membres.manage') }}" class="btn btn-outline-primary text-primary"
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
    
    /* Style des checkboxes */
    .form-check-input {
        width: 18px;
        height: 18px;
        margin-top: 0.25rem;
    }
    
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.25em;
    }
</style>
@endsection
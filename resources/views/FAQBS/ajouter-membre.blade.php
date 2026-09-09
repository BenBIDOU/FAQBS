@extends('layouts.app')

@section('title')
Ajouter un membre - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Ajouter un membre</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h4 class="mb-0" style="height: 100%;">Ajouter un nouveau membre</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('membres.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Nom et Email -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label" style="color: #002D5D; font-weight: 500;">Nom *</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label" style="color: #002D5D; font-weight: 500;">Email *</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                        </div>

                        <!-- Téléphone et Ville -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="telephone" class="form-label" style="color: #002D5D; font-weight: 500;">Téléphone</label>
                                <input type="text" class="form-control" id="telephone" name="telephone" value="{{ old('telephone') }}"
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                            <div class="col-md-6">
                                <label for="ville_bs" class="form-label" style="color: #002D5D; font-weight: 500;">Ville</label>
                                <input type="text" class="form-control" id="ville_bs" name="ville_bs" value="{{ old('ville_bs') }}"
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                        </div>

                        <!-- Mot de passe -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="form-label" style="color: #002D5D; font-weight: 500;">Mot de passe *</label>
                                <input type="password" class="form-control" id="password" name="password" required
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label" style="color: #002D5D; font-weight: 500;">Confirmer le mot de passe *</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                        </div>

                        <!-- Rôles -->
                        <div class="mb-3">
                            <label class="form-label" style="color: #002D5D; font-weight: 500;">Rôles</label>
                            <div class="d-flex gap-4 flex-wrap">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_master" name="is_master" value="1" {{ old('is_master') ? 'checked' : '' }}
                                           style="width: 18px; height: 18px; margin-top: 6px;">
                                    <label class="form-check-label" for="is_master" style="color: #495057; padding-left: 8px;">Master</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_president" name="is_president" value="1" {{ old('is_president') ? 'checked' : '' }}
                                           style="width: 18px; height: 18px; margin-top: 6px;">
                                    <label class="form-check-label" for="is_president" style="color: #495057; padding-left: 8px;">Président</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="is_voice_donor" name="is_voice_donor" value="1" {{ old('is_voice_donor') ? 'checked' : '' }}
                                           style="width: 18px; height: 18px; margin-top: 6px;">
                                    <label class="form-check-label" for="is_voice_donor" style="color: #495057; padding-left: 8px;">Donneur de voix</label>
                                </div>
                            </div>
                        </div>

                        <!-- Statut -->
                        <div class="mb-3">
                            <label class="form-label" style="color: #002D5D; font-weight: 500;">Statut</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked
                                       style="width: 18px; height: 18px; margin-top: 6px;">
                                <label class="form-check-label" for="is_active" style="color: #495057; padding-left: 8px;">Actif</label>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                            <a href="{{ route('membres.manage') }}" class="btn btn-outline-secondary me-md-2" style="color: #6c757d; border-color: #6c757d; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease;">
                                Annuler
                            </a>
                            <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease; font-weight: 600;">
                                Ajouter le membre
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lien pour retourner -->
            <div class="my-4 text-center">
                <a href="{{ route('membres.manage') }}" class="btn text-white" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease; font-weight: 600;">
                    <i class="bi bi-arrow-left me-2"></i> Retour à la gestion des membres
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

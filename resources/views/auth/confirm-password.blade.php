@extends('layouts.app')

@section('title')
Confirmer mot de passe - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 text-center">
                        <i class="bi bi-shield-lock me-2"></i>
                        Confirmer votre mot de passe
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        Ceci est une zone sécurisée. Veuillez confirmer votre mot de passe pour continuer.
                    </div>

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required autocomplete="current-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-bordeaux text-white text-uppercase" style="font-weight: bold;">
                                <i class="bi bi-check-lg me-1"></i> Confirmer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

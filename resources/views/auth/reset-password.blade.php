@extends('layouts.app')

@section('title')
Réinitialiser mot de passe - Bibliothèques sonores de la région Centre - Val de Loire
@endsection)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 text-center">
                        <i class="bi bi-key-fill me-2"></i>
                        Réinitialiser votre mot de passe
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.store') }}">
                        @csrf

                        <!-- Password Reset Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email Address -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Nouveau mot de passe</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required autocomplete="new-password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" 
                                   id="password_confirmation" name="password_confirmation" required autocomplete="new-password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-bordeaux text-white text-uppercase" style="font-weight: bold;">
                                <i class="bi bi-key me-1"></i> Réinitialiser le mot de passe
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

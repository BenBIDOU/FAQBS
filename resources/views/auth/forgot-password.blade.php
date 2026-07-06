@extends('layouts.app')

@section('title')
Mot de passe oublié - Bibliothèques sonores de la région Centre - Val de Loire
@endsection)

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 text-center">
                        <i class="bi bi-key me-2"></i>
                        Mot de passe oublié ?
                    </h4>
                </div>
                <div class="card-body">
                    <div class="mb-4 text-center">
                        Indiquez votre adresse email et nous vous enverrons un lien de réinitialisation.
                    </div>

                    @if(session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Adresse Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-bordeaux text-white text-uppercase" style="font-weight: bold;">
                                <i class="bi bi-envelope me-1"></i> Envoyer le lien de réinitialisation
                            </button>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary text-center">
                                <i class="bi bi-arrow-left me-1"></i> Retour à la connexion
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title')
Envoyer un message - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Envoyer un message</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-envelope-plus me-2"></i>
                        Envoyer un message à {{ $user->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('messages.store', $user->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="content" class="form-label" style="color: #002D5D; font-weight: 500;">Message *</label>
                            <textarea class="form-control" id="content" name="content" rows="8" required style="border: 1px solid #E9ECEF; border-radius: 8px; padding: 0.75rem;">{{ old('content') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label" style="color: #002D5D; font-weight: 500;">Destinataire</label>
                            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px; overflow: hidden;">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        @if($user->photo)
                                            <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo" 
                                                 class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-person text-white" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong style="color: #495057;">{{ $user->name }}</strong>
                                            <div class="text-muted small">{{ $user->email }}</div>
                                            @if($user->telephone)
                                                <div class="text-muted small">{{ $user->telephone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('membres.manage') }}" class="btn btn-outline-primary text-primary"
                               style="border: 1px solid #002D5D; color: #002D5D !important; border-radius: 8px; transition: all 0.2s ease;">
                                <i class="bi bi-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-main text-white" style="border-radius: 8px;">
                                <i class="bi bi-send me-1"></i> Envoyer le message
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
    .form-control:focus {
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
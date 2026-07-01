@extends('layouts.app')

@section('title', 'Envoyer un message - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-envelope-plus me-2"></i>
                        Envoyer un message à {{ $receiver->name }}
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('messages.store', $receiver->id) }}">
                        @csrf

                        <div class="mb-3">
                            <label for="subject" class="form-label">Sujet *</label>
                            <input type="text" class="form-control" id="subject" name="subject" 
                                   value="{{ old('subject') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Message *</label>
                            <textarea class="form-control" id="content" name="content" rows="8" required>{{ old('content') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Destinataire</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        @if($receiver->photo)
                                            <img src="{{ asset('storage/' . $receiver->photo) }}" alt="Photo" 
                                                 class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                                 style="width: 50px; height: 50px;">
                                                <i class="bi bi-person text-white" style="font-size: 1.5rem;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $receiver->name }}</strong>
                                            <div class="text-muted small">{{ $receiver->email }}</div>
                                            @if($receiver->telephone)
                                                <div class="text-muted small">{{ $receiver->telephone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('membres.manage') }}" class="btn btn-outline-bordeaux text-bordeaux">
                                <i class="bi bi-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn btn-bordeaux text-white">
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
    .bg-light {
        background-color: #2d2d2d !important;
        color: #e0e0e0 !important;
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
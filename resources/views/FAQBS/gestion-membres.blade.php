@extends('layouts.app')

@section('title', 'Gestion des membres - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-people me-2"></i>
                        Gestion des membres
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #28a745; color: white; border: none;">
                            {{ session('success') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="background-color: #dc3545; color: white; border: none;">
                            {{ session('error') }}
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="text-muted mb-0">Liste de tous les membres</p>
                        <a href="/espace-membre" class="btn btn-outline-bordeaux text-bordeaux">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    @if($users->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mt-3">Aucun membre trouvé</h5>
                            <p class="text-muted">Aucun utilisateur n'est enregistré.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light" style="background-color: #2d2d2d; color: #e0e0e0;">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Rôle</th>
                                        <th>Téléphone</th>
                                        <th>Ville</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr style="background-color: #2d2d2d; color: #e0e0e0; border-color: #444;">
                                            <td>
                                                <strong>{{ $user->name }}</strong>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->is_master)
                                                    <span class="badge bg-warning text-dark">Master</span>
                                                @endif
                                                @if($user->is_voice_donor)
                                                    <span class="badge bg-info text-dark">Donneur de voix</span>
                                                @endif
                                                @if($user->is_president)
                                                    <span class="badge bg-primary">Président</span>
                                                @endif
                                                @if(!($user->is_master || $user->is_voice_donor || $user->is_president))
                                                    <span class="badge bg-secondary">Membre</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->telephone ?? 'Non renseigné' }}</td>
                                            <td>{{ $user->ville_bs ?? 'Non renseigné' }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('membres.edit', $user->id) }}" 
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Modifier" style="color: #ffc107; border-color: #ffc107;">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('membres.destroy', $user->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Supprimer" style="color: #dc3545; border-color: #dc3545;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('membres.toggleSuspend', $user->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-{{ $user->is_active ? 'success' : 'secondary' }}"
                                                                title="{{ $user->is_active ? 'Réactiver l\'accès' : 'Suspendre l\'accès' }}"
                                                                style="color: {{ $user->is_active ? '#28a745' : '#6c757d' }}; border-color: {{ $user->is_active ? '#28a745' : '#6c757d' }};">
                                                            <i class="bi bi-{{ $user->is_active ? 'slash-circle' : 'check-circle' }}"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
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
    .btn-outline-info {
        color: #0dcaf0;
        border-color: #0dcaf0;
    }
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #1a1a1a;
        border-color: #0dcaf0;
    }
    .btn-outline-success {
        color: #28a745;
        border-color: #28a745;
    }
    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
        border-color: #6c757d;
    }
    .table {
        --bs-table-bg: transparent;
        --bs-table-color: #e0e0e0;
        --bs-table-border-color: #444;
        --bs-table-hover-bg: #3a3a3a;
        --bs-table-hover-color: #e0e0e0;
    }
    .table-light {
        --bs-table-bg-type: rgba(255, 255, 255, 0.05);
        color: #e0e0e0;
        background-color: #2d2d2d;
    }
    .badge {
        font-size: 0.85em;
    }
    .btn-close-white {
        filter: invert(1) grayscale(100%) brightness(200%);
    }
</style>

@endsection
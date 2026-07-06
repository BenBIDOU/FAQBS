@extends('layouts.app')

@section('title')
Gestion des membres - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Gestion des membres</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <!-- Messages d'alerte -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); color: #28A745;">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="background: rgba(220, 53, 69, 0.1); border-left: 4px solid #DC3545; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); color: #DC3545;">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Carte principale -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-people me-2"></i> Gestion des membres
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="mb-0" style="color: #495057;">Liste de tous les membres</p>
                        <a href="/agora" class="btn btn-outline-primary text-primary" style="border: 1px solid #002D5D; color: #002D5D !important; border-radius: 8px; transition: all 0.2s ease;">
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
                            <table class="table table-hover" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white;">
                                    <tr>
                                        <th style="padding: 12px; white-space: nowrap;">Nom</th>
                                        <th style="padding: 12px; white-space: nowrap;">Email</th>
                                        <th style="padding: 12px; white-space: nowrap;">Rôle</th>
                                        <th style="padding: 12px; white-space: nowrap;">Téléphone</th>
                                        <th style="padding: 12px; white-space: nowrap;">Ville</th>
                                        <th style="padding: 12px; white-space: nowrap;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr style="border-bottom: 1px solid #E9ECEF; transition: all 0.2s ease;">
                                            <td style="padding: 12px; color: #495057;">
                                                <strong>{{ $user->name }}</strong>
                                            </td>
                                            <td style="padding: 12px; color: #495057;">{{ $user->email }}</td>
                                            <td style="padding: 12px;">
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
                                            <td style="padding: 12px; color: #495057;">{{ $user->telephone ?? 'Non renseigné' }}</td>
                                            <td style="padding: 12px; color: #495057;">{{ $user->ville_bs ?? 'Non renseigné' }}</td>
                                            <td style="padding: 12px;">
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <a href="{{ route('messages.create', $user->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Écrire un message" style="color: #0dcaf0; border-color: #0dcaf0; border-radius: 6px; padding: 6px 10px;">
                                                        <i class="bi bi-envelope"></i>
                                                    </a>
                                                    <a href="{{ route('membres.edit', $user->id) }}" 
                                                       class="btn btn-sm btn-outline-warning"
                                                       title="Modifier" style="color: #ffc107; border-color: #ffc107; border-radius: 6px; padding: 6px 10px;">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('membres.destroy', $user->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce membre ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Supprimer" style="color: #dc3545; border-color: #dc3545; border-radius: 6px; padding: 6px 10px;">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('membres.toggleSuspend', $user->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-{{ $user->is_active ? 'success' : 'secondary' }}"
                                                                title="{{ $user->is_active ? 'Suspendre l\'accès' : 'Réactiver l\'accès' }}"
                                                                style="color: {{ $user->is_active ? '#28a745' : '#6c757d' }}; border-color: {{ $user->is_active ? '#28a745' : '#6c757d' }}; border-radius: 6px; padding: 6px 10px;">
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
    /* Style des boutons */
    .btn-outline-primary:hover {
        background: #002D5D;
        color: white !important;
        border-color: #002D5D;
    }
    
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #FFFFFF;
        border-color: #0dcaf0;
    }
    
    .btn-outline-warning:hover {
        background-color: #ffc107;
        color: #000;
        border-color: #ffc107;
    }
    
    .btn-outline-success:hover {
        background-color: #28a745;
        color: white;
        border-color: #28a745;
    }
    
    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
        border-color: #6c757d;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    /* Style des badges */
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
        border-radius: 20px;
        font-weight: 500;
    }
    
    /* Style du tableau */
    .table th, .table td {
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: rgba(0, 45, 93, 0.03);
    }
    
    .table-responsive {
        overflow-x: auto;
    }
</style>

@endsection
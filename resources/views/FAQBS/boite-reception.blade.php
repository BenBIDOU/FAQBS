@extends('layouts.app')

@section('title')
Boîte de réception - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container-fluid">
    {{-- Header --}}
    <div class="page-header-custom mb-4">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 120px; margin-left: 6px;">
            </div>
            <div class="col text-center">
                <h1 class="mb-1 text-primary fw-700" style="font-size: 2rem;">Boîte de réception</h1>
                <p class="mb-0 text-secondary-muted" style="font-size: 1.1rem;">
                    Bibliothèques sonores de la région Centre - Val de Loire
                </p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card card-custom">
                <div class="card-header card-header-custom card-header-red">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-inbox me-2"></i> Boîte de réception
                    </h5>
                </div>
                <div class="card-body">
                    {{-- Messages de succès/erreur --}}
                    @if(session('success'))
                        <div class="alert alert-success-custom alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-custom alert-dismissible fade show mb-4" role="alert" 
                             style="background: rgba(220, 53, 69, 0.1); border-left: 4px solid #DC3545;">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- En-tête de la liste --}}
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="mb-0 text-secondary-muted">Liste de vos messages reçus</p>
                        <a href="/agora" class="btn btn-custom btn-outline-custom">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    {{-- Liste vide --}}
                    @if($receivedMessages->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">Aucun message reçu</h5>
                            <p class="text-muted">Vous n'avez aucun message pour le moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="gradient-red" style="color: white;">
                                    <tr>
                                        <th style="padding: 12px; white-space: nowrap;">Expéditeur</th>
                                        <th style="padding: 12px; white-space: nowrap;">Date</th>
                                        <th style="padding: 12px; white-space: nowrap;">Statut</th>
                                        <th style="padding: 12px; white-space: nowrap;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receivedMessages as $message)
                                        <tr class="{{ !$message->is_read ? 'table-active' : '' }}" style="border-bottom: 1px solid #E9ECEF;">
                                            <td style="padding: 12px; color: #495057;">
                                                <strong>{{ $message->sender->name ?? 'Inconnu' }}</strong>
                                            </td>
                                            <td style="padding: 12px; color: #495057;">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                            <td style="padding: 12px;">
                                                @if($message->is_read)
                                                    <span class="badge badge-custom bg-success">Lu</span>
                                                @else
                                                    <span class="badge badge-custom bg-warning text-dark">Non lu</span>
                                                @endif
                                            </td>
                                            <td style="padding: 12px;">
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('messages.show', $message->id) }}" 
                                                       class="btn btn-sm btn-outline-info btn-custom"
                                                       title="Lire">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST"
                                                          onsubmit="return confirmDialog('Confirmation', 'Êtes-vous sûr de vouloir supprimer ce message ?', function() { return true; })">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger btn-custom"
                                                                title="Supprimer">
                                                            <i class="bi bi-trash"></i>
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

{{-- Styles spécifiques --}}
@push('styles')
<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .table tbody tr:hover {
        background: rgba(0, 45, 93, 0.03);
    }
    .table-active {
        background-color: rgba(0, 123, 255, 0.1) !important;
    }
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #FFFFFF;
        border-color: #0dcaf0;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
</style>
@endpush

@endsection
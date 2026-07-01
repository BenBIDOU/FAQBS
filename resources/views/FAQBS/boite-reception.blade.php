@extends('layouts.app')

@section('title', 'Boîte de réception - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="shadow card">
                <div class="card-header bg-bordeaux text-white">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-inbox me-2"></i>
                        Boîte de réception
                    </h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="text-muted mb-0">Liste de vos messages reçus</p>
                        <a href="/agora" class="btn btn-outline-bordeaux">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    @if($receivedMessages->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">Aucun message reçu</h5>
                            <p class="text-muted">Vous n'avez aucun message pour le moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Expéditeur</th>
                                        <th>Sujet</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receivedMessages as $message)
                                        <tr class="{{ !$message->is_read ? 'table-active' : '' }}">
                                            <td>
                                                <strong>{{ $message->sender->name ?? 'Inconnu' }}</strong>
                                            </td>
                                            <td>{{ $message->subject }}</td>
                                            <td>{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                @if($message->is_read)
                                                    <span class="badge bg-success">Lu</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Non lu</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('messages.show', $message->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Lire">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
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
        color: #6D071A;
        border-color: #6D071A;
    }
    .btn-outline-bordeaux:hover {
        background-color: #6D071A;
        color: white;
    }
</style>

@endsection
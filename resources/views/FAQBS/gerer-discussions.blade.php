@extends('layouts.app')

@section('title', 'Gérer les discussions')

@section('content')
<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0">Gestion des discussions</h4>
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <p class="text-muted mb-0">Liste de toutes les discussions</p>
                        <a href="{{ route('discussion.create') }}" class="btn btn-bordeaux text-white">
                            <i class="bi bi-plus-circle me-2"></i> Ajouter une discussion
                        </a>
                    </div>

                    @if($discussions->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-chat-square-text text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">Aucune discussion trouvée</h5>
                            <p class="text-muted">Commencez par ajouter une nouvelle discussion.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Titre</th>
                                        <th>Groupe</th>
                                        <th>Auteur</th>
                                        <th>Date de création</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($discussions as $discussion)
                                        <tr>
                                            <td>
                                                <strong>{{ $discussion->title }}</strong>
                                                @if($discussion->link)
                                                    <div class="text-muted small">
                                                        <i class="bi bi-link-45deg"></i> 
                                                        <a href="{{ $discussion->link }}" target="_blank" class="text-decoration-none">Lien</a>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-primary">
                                                    {{ $discussion->group }}
                                                </span>
                                            </td>
                                            <td>
                                                @if($discussion->user)
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-1" alt="Auteur" width="20" height="20">
                                                        <small>{{ $discussion->user->name }}</small>
                                                    </div>
                                                @else
                                                    <small class="text-muted">Inconnu</small>
                                                @endif
                                            </td>
                                            <td>{{ $discussion->created_at->format('d/m/Y H:i') }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('discussions.show', $discussion->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Voir">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="{{ route('discussions.duplicate', $discussion->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Dupliquer">
                                                            <i class="bi bi-files"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette discussion ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer">
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

            <!-- Lien pour retourner à l'espace membre -->
            <div class="my-4">
                <a href="/espace-membre" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left me-2"></i> Retour à l'espace membre
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-bordeaux {
        background-color: #6D071A;
    }
    
    .btn-bordeaux:hover {
        background-color: #5a0515;
    }
    
    .badge {
        font-size: 0.85em;
    }
</style>

@endsection

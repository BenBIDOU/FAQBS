@extends('layouts.app')

@section('title', 'Gestion des questions - Bibliothèques Sonores')

@section('content')
<div class="container-fluid py-4" style="background-color: #1a1a1a; min-height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-question-circle me-2"></i>
                        Gestion des questions
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
                        <p class="text-muted mb-0">Liste de toutes les questions posées</p>
                        <a href="/espace-membre" class="btn btn-outline-bordeaux text-bordeaux">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    @if($questions->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 4rem;"></i>
                            <h5 class="text-muted mt-3">Aucune question trouvée</h5>
                            <p class="text-muted">Aucune question n'a été posée pour le moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light" style="background-color: #2d2d2d; color: #e0e0e0;">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Équipe</th>
                                        <th>Sujet</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr style="background-color: #2d2d2d; color: #e0e0e0; border-color: #444;">
                                            <td>
                                                <strong>{{ $question->name }}</strong>
                                            </td>
                                            <td>{{ $question->email }}</td>
                                            <td>
                                                <span class="badge" style="background-color: #6c757d; color: white;">
                                                    {{ $question->team }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ Str::limit($question->subject, 50) }}
                                                @if(strlen($question->subject) > 50)
                                                    <span class="text-muted">...</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $question->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if($question->resolved)
                                                    <span class="badge bg-success">Résolue</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">En attente</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('questions-details', $question->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Voir" style="color: #0dcaf0; border-color: #0dcaf0;">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Supprimer" style="color: #dc3545; border-color: #dc3545;">
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
    .btn-outline-bordeaux {
        border-color: #6D071A;
        color: #6D071A;
    }
    .btn-outline-bordeaux:hover {
        background-color: #6D071A;
        color: white;
    }
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .text-bordeaux {
        color: #6D071A;
    }
</style>
@endsection

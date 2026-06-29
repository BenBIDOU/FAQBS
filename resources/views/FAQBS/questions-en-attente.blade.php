@extends('layouts.app')

@section('title', 'Questions en attente - Bibliothèques Sonores')

@section('content')
<div class="container-fluid">
    <!-- Logo et titre -->
    <div class="row align-items-center mb-4">
        <div class="col-auto">
            <img src="{{ asset('images/logo.png') }}" alt="Bibliothèques Sonores de France" class="img-fluid" style="max-height: 100px;">
        </div>
        <div class="col">
            <h1 class="mb-1">
                Questions en attente
                @if($team)
                    <span class="text-muted">- {{ $team }}</span>
                @endif
            </h1>
        </div>
    </div>

    <!-- Message de retour -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtres par équipe -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2">
                        <a href="{{ route('questions-en-attente') }}" class="btn @if (!$team) btn-bordeaux text-white @else btn-outline-bordeaux text-bordeaux @endif">
                            <i class="bi bi-inbox me-1"></i> Toutes les questions
                        </a>
                        <a href="{{ route('questions-en-attente.team', ['team' => 'Président']) }}" class="btn @if($team === 'Président') btn-bordeaux text-white @else btn-outline-bordeaux text-bordeaux @endif">
                            <i class="bi bi-person me-1"></i> Président
                        </a>
                        <a href="{{ route('questions-en-attente.team', ['team' => 'Secrétariat']) }}" class="btn @if($team === 'Secrétariat') btn-bordeaux text-white @else btn-outline-bordeaux text-bordeaux @endif">
                            <i class="bi bi-file-earmark-text me-1"></i> Secrétariat
                        </a>
                        <a href="{{ route('questions-en-attente.team', ['team' => 'Donneurs de Voix']) }}" class="btn @if($team === 'Donneurs de Voix') btn-bordeaux text-white @else btn-outline-bordeaux text-bordeaux @endif">
                            <i class="bi bi-mic me-1"></i> Donneurs de Voix
                        </a>
                        <a href="{{ route('questions-en-attente.team', ['team' => 'Donneurs de Temps']) }}" class="btn @if($team === 'Donneurs de Temps') btn-bordeaux text-white @else btn-outline-bordeaux text-bordeaux @endif">
                            <i class="bi bi-clock me-1"></i> Donneurs de Temps
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tableau des questions -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-bordeaux text-white">
                    <h4 class="mb-0">Liste des questions en attente de réponse</h4>
                </div>
                <div class="card-body">
                    @if($questions->isEmpty())
                        <div class="alert alert-info">
                            Aucune question en attente.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Nom</th>
                                        <th>Email</th>
                                        <th>Objet</th>
                                        <th>Message</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr>
                                            <td>{{ $question->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $question->name }}</td>
                                            <td>{{ $question->email }}</td>
                                            <td>{{ $question->subject }}</td>
                                            <td>{{ Str::limit($question->message, 50) }}</td>
                                            <td>
                                                <a href="{{ route('questions-details', ['question' => $question->id]) }}" class="btn btn-sm btn-outline-bordeaux">
                                                    <i class="bi bi-eye me-1"></i> Voir
                                                </a>
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

    <!-- Lien pour retourner à l'espace membre -->
    <div class="my-4">
        <a href="/espace-membre" class="btn btn-bordeaux text-white">
            <i class="bi bi-arrow-left me-2"></i> Retour à l'espace membre
        </a>
    </div>
</div>

<style>
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .bg-bordeaux-light {
        background-color: #96637B;
    }
    .btn-bordeaux {
        background-color: #6D071A;
        border-color: #6D071A;
        color: white;
    }
    .btn-bordeaux:hover {
        background-color: #5a0514;
        border-color: #5a0514;
    }
    .btn-bordeaux-light {
        background-color: #96637B;
        border-color: #96637B;
        color: white;
    }
    .btn-bordeaux-light:hover {
        background-color: #85556d;
        border-color: #85556d;
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

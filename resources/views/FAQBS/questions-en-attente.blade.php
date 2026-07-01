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

    <!-- Questions en attente -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="bi bi-clock me-2"></i> Questions en attente
                    </h4>
                </div>
                <div class="card-body">
                    @if($pendingQuestions->isEmpty())
                        <div class="alert alert-info mb-0">
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
                                    @foreach($pendingQuestions as $question)
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

    <!-- Questions résolues (rétractable) -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-header bg-light text-dark cursor-pointer" 
                     data-bs-toggle="collapse" 
                     data-bs-target="#resolvedQuestionsCollapse" 
                     aria-expanded="true">
                    <h5 class="mb-0 d-flex align-items-center">
                        <i class="bi bi-check-circle-fill text-success me-2"></i> Questions résolues
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </h5>
                </div>
                <div id="resolvedQuestionsCollapse" class="collapse show" data-bs-parent="#questionsAccordion">
                    <div class="card-body">
                        @if($resolvedQuestions->isEmpty())
                            <div class="alert alert-info mb-0">
                                Aucune question résolue.
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
                                            <th>Résolue par</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($resolvedQuestions as $question)
                                            <tr class="table-success">
                                                <td>{{ $question->created_at->format('d/m/Y H:i') }}</td>
                                                <td>{{ $question->name }}</td>
                                                <td>{{ $question->email }}</td>
                                                <td>{{ $question->subject }}</td>
                                                <td>{{ Str::limit($question->message, 50) }}</td>
                                                <td>
                                                    @if($question->resolver)
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-1" alt="Résolveur" width="20" height="20">
                                                            <small>{{ $question->resolver->name }}</small>
                                                        </div>
                                                    @else
                                                        <small class="text-muted">Inconnu</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        // Chercher une discussion avec un titre correspondant au sujet de la question (comparaison flexible)
                                                        $matchingDiscussion = null;
                                                        $questionSubject = trim(strtolower($question->subject));
                                                        foreach($discussions as $discussion) {
                                                            $discussionTitle = trim(strtolower($discussion->title));
                                                            // Vérifier si le titre contient le sujet ou vice versa
                                                            if (str_contains($discussionTitle, $questionSubject) || str_contains($questionSubject, $discussionTitle)) {
                                                                $matchingDiscussion = $discussion;
                                                                break;
                                                            }
                                                        }
                                                    @endphp
                                                    @if($matchingDiscussion)
                                                        <a href="{{ route('discussions.show', $matchingDiscussion->id) }}" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           target="_blank">
                                                            <i class="bi bi-eye me-1"></i> Voir le forum
                                                        </a>
                                                    @else
                                                        <button class="btn btn-sm btn-outline-secondary" 
                                                                onclick="alert('Aucun forum correspondant trouvé pour : {{ addslashes($question->subject) }}');"
                                                                title="Aucun forum trouvé">
                                                            <i class="bi bi-eye me-1"></i> Voir le forum
                                                        </button>
                                                    @endif
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
    .cursor-pointer {
        cursor: pointer;
    }
    .card-header[aria-expanded="false"] .bi-chevron-down {
        transform: rotate(-90deg);
    }
    .card-header[aria-expanded="true"] .bi-chevron-down {
        transform: rotate(0deg);
    }
    #resolvedQuestionsCollapse {
        transition: all 0.3s ease;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion de l'icône chevron pour l'accordéon
        const resolvedHeader = document.querySelector('.card-header[data-bs-target="#resolvedQuestionsCollapse"]');
        if (resolvedHeader) {
            resolvedHeader.addEventListener('click', function() {
                const chevron = this.querySelector('.bi-chevron-down');
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                if (isExpanded) {
                    chevron.style.transform = 'rotate(-90deg)';
                } else {
                    chevron.style.transform = 'rotate(0deg)';
                }
            });
        }
    });
</script>
@endsection

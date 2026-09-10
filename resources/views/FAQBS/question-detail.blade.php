@extends('layouts.app')

@section('title')
Détails de la question - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Détails de la question</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
            </div>
    <!-- Carte des détails de la question -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-question-circle-fill me-2"></i> Question #{{ $question->id }}
                        <span class="badge bg-light text-dark ms-2">{{ $question->team }}</span>
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Nom et Email -->
                    <div class="mb-2">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-person me-2"></i>Nom :</label>
                                    <p class="mb-0" style="color: #495057;">{{ $question->name }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-envelope me-2"></i>Email :</label>
                                    <p class="mb-0" style="color: #495057;">{{ $question->email }}</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-people me-2"></i>Équipe concernée :</label>
                                    <p class="mb-0" style="color: #495057;">{{ $question->team }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-calendar me-2"></i>Date :</label>
                        <p class="mb-0" style="color: #495057;">{{ $question->created_at->format('d/m/Y H:i') }}</p>
                    </div>

                    <!-- Message -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-file-text me-2"></i>Question :</label>
                        <div class="p-3 bg-light rounded-3" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px;">
                            <p class="mb-0" style="color: #495057;">{{ $question->message }}</p>
                        </div>
                    </div>

                    <!-- Statut -->
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-check-circle me-2"></i>Statut :</label>
                        <p class="mb-0">
                            @if($question->resolved)
                                <span class="badge bg-success">Résolue</span>
                            @else
                                <span class="badge bg-warning text-dark">En attente</span>
                            @endif
                        </p>
                    </div>
                    
                    <!-- Titre de la discussion -->
                    @if($question->discussion_title)
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-chat-square-text me-2"></i>Titre de la discussion :</label>
                        <p class="mb-0" style="color: #495057;">{{ $question->discussion_title }}</p>
                    </div>
                    @endif
                    
                    <!-- Résolue par -->
                    @if($question->resolved && $question->resolver)
                    <div class="mb-4">
                        <label class="form-label fw-bold" style="color: #002D5D;"><i class="bi bi-person-check me-2"></i>Résolue par :</label>
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-2" alt="Résolveur" width="24" height="24">
                            <p class="mb-0" style="color: #495057;">{{ $question->resolver->name }}</p>
                        </div>
                    </div>
                    @endif
                </div>
                <div class="card-footer" style="background: transparent; border-top: none; padding-top: 0;">
                    <div class="d-flex gap-3 mb-4">
                        <form action="{{ route('questions.resolve', ['question' => $question->id]) }}" method="POST" class="w-50">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ route('questions.reply', ['question' => $question->id]) }}">
                            <button type="submit" class="btn btn-lg text-white px-4 py-3 shadow-lg w-100" style="font-size: 1.1rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); box-shadow: 0 4px 15px rgba(0, 45, 93, 0.3); transition: all 0.3s ease;">
                                <i class="bi bi-reply me-1"></i> Répondre
                            </button>
                        </form>
                        <form action="{{ route('questions.resolve', ['question' => $question->id]) }}" method="POST" class="w-50">
                            @csrf
                            <input type="hidden" name="redirect" value="{{ route('discussion.create', ['group' => $question->team, 'title' => $question->subject ?? $question->discussion_title ?? '', 'content' => $question->message, 'question_id' => $question->id]) }}">
                            <button type="submit" class="btn btn-lg text-white px-4 py-3 shadow-lg w-100" style="font-size: 1.1rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #28A745 0%, #20C997 100%); box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3); transition: all 0.3s ease;">
                                <i class="bi bi-chat-square-text me-1"></i> Ouvrir la discussion
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>


    <!-- Boutons d'action -->
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @php
            // Trouver la discussion associée pour le bouton "Voir le forum"
            $discussionId = null;
            $questionTeam = $question->team ?? $question->destination ?? $question->group ?? 'Président';
            
            $teamToAccordion = [
                'Président' => 'collapsePresident',
                'Secrétariat' => 'collapseSecretariat',
                'Trésorerie' => 'collapseTresorerie',
                'Donneurs de Voix' => 'collapseDonneursVoix',
                'Donneurs de Temps' => 'collapseDonneursTemps',
            ];
            $accordionId = $teamToAccordion[$questionTeam] ?? 'collapsePresident';
            
            // Vérifier les champs directs
            $possibleFields = ['discussion_id', 'thread_id', 'forum_post_id', 'related_discussion_id', 'forum_id', 'post_id'];
            foreach ($possibleFields as $field) {
                if (!empty($question->$field)) {
                    $discussionId = $question->$field;
                    break;
                }
            }
            
            // Vérifier les relations
            if (!$discussionId) {
                $possibleRelations = ['discussion', 'discussions', 'thread', 'threads', 'forumPost', 'forumPosts'];
                foreach ($possibleRelations as $relation) {
                    if (isset($question->$relation) && $question->$relation) {
                        if (is_iterable($question->$relation) && !is_array($question->$relation)) {
                            $first = $question->$relation->first();
                            if ($first) {
                                $discussionId = $first->id;
                                break;
                            }
                        } else {
                            $discussionId = $question->$relation->id;
                            break;
                        }
                    }
                }
            }
            
            // Chercher dans les discussions passées par le contrôleur
            if (!$discussionId && isset($discussions)) {
                foreach ($discussions as $discussion) {
                    $discussionGroup = $discussion->group ?? ($discussion->team ?? null);
                    
                    // Vérifier les références directes par ID
                    if (str_contains($discussion->title, '#'.$question->id) || 
                        str_contains($discussion->title, 'Question '.$question->id) ||
                        str_contains($discussion->content, '#'.$question->id) ||
                        str_contains($discussion->content, 'Question '.$question->id)) {
                        $discussionId = $discussion->id;
                        break;
                    }
                    // Vérifier si le groupe correspond et que le titre ou contenu correspond
                    elseif ($discussionGroup && $discussionGroup === $questionTeam) {
                        // Vérifier si le titre correspond au sujet ou titre de discussion
                        if ((!empty($question->subject) && str_contains($discussion->title, $question->subject)) ||
                            (!empty($question->discussion_title) && str_contains($discussion->title, $question->discussion_title))) {
                            $discussionId = $discussion->id;
                            break;
                        }
                        // Vérifier si le contenu correspond au message
                        elseif (str_contains($discussion->content, $question->message)) {
                            $discussionId = $discussion->id;
                            break;
                        }
                        // Vérifier les mots-clés
                        elseif ($question->created_at && $discussion->created_at >= $question->created_at) {
                            $questionKeywords = [
                                $question->subject ?? '',
                                $question->discussion_title ?? '',
                                Str::limit($question->message, 50)
                            ];
                            foreach ($questionKeywords as $keyword) {
                                if (!empty($keyword) && 
                                    (str_contains($discussion->title, $keyword) || 
                                     str_contains($discussion->content, $keyword))) {
                                    $discussionId = $discussion->id;
                                    break 2;
                                }
                            }
                        }
                    }
                }
            }
            
            // Vérifier dans les données JSON
            if (!$discussionId) {
                if (!empty($question->meta) && is_array($question->meta)) {
                    $discussionId = $question->meta['discussion_id'] ?? null;
                }
                if (!$discussionId && !empty($question->extra_data) && is_array($question->extra_data)) {
                    $discussionId = $question->extra_data['discussion_id'] ?? null;
                }
                if (!$discussionId && !empty($question->meta) && is_string($question->meta)) {
                    $meta = json_decode($question->meta, true);
                    $discussionId = $meta['discussion_id'] ?? null;
                }
                if (!$discussionId && !empty($question->extra_data) && is_string($question->extra_data)) {
                    $extra = json_decode($question->extra_data, true);
                    $discussionId = $extra['discussion_id'] ?? null;
                }
            }
            @endphp
            <div class="d-flex gap-3 flex-wrap">
                <a href="/agora" class="btn btn-outline-primary" style="border: 1px solid #990000; color: #990000 !important; border-radius: 8px;">
                    <i class="bi bi-arrow-left me-2"></i> Retour
                </a>
                @if($discussionId)
                <a href="{{ route('discussions.show', ['discussion' => $discussionId]) }}" class="btn btn-outline-success" target="_blank" style="border: 1px solid #28a745; color: #28a745 !important; border-radius: 8px;">
                    <i class="bi bi-eye me-2"></i> Voir le forum
                </a>
                @endif
                @if(!$question->resolved)
                    <form action="{{ route('questions.resolve', ['question' => $question->id]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success" title="Marquer comme résolue" style="border-radius: 8px;">
                            <i class="bi bi-check-circle me-2"></i> Marquer comme résolue
                        </button>
                    </form>
                @endif
                <a href="/questions-en-attente/{{ $question->team }}" class="btn btn-outline-primary text-primary" style="border: 1px solid #002D5D; color: #002D5D !important; border-radius: 8px;">
                    <i class="bi bi-folder me-2"></i> Retour aux questions de l'équipe
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-outline-primary:hover {
        background: #002D5D;
        color: white !important;
        border-color: #002D5D;
    }
    
    /* Style des badges */
    .badge {
        padding: 0.35em 0.65em;
        border-radius: 20px;
        font-weight: 500;
    }
</style>
@endsection

@extends('layouts.app')

@section('title')
Questions en attente - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Questions en attente</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <!-- Message de retour -->
    @if(session('success'))
        <div class="alert alert-success mb-4" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            {{ session('success') }}
        </div>
    @endif

    <!-- Filtres par équipe -->
    <div class="mb-4">
        <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('questions-en-attente') }}" class="btn btn-outline-primary" style="border: 1px solid #002D5D; color: white !important; background: @if (!$team) #0056B3 @else #002D5D @endif; border-radius: 8px; transition: all 0.2s ease;">
                        <i class="bi bi-inbox me-1"></i> Toutes
                    </a>
                    <a href="{{ route('questions-en-attente.team', ['team' => 'Président']) }}" class="btn btn-outline-primary" style="border: 1px solid #002D5D; color: white !important; background: @if($team === 'Président') #0056B3 @else #002D5D @endif; border-radius: 8px; transition: all 0.2s ease;">
                        <i class="bi bi-person me-1"></i> Président
                    </a>
                    <a href="{{ route('questions-en-attente.team', ['team' => 'Secrétariat']) }}" class="btn btn-outline-primary" style="border: 1px solid #002D5D; color: white !important; background: @if($team === 'Secrétariat') #0056B3 @else #002D5D @endif; border-radius: 8px; transition: all 0.2s ease;">
                        <i class="bi bi-file-earmark-text me-1"></i> Secrétariat
                    </a>
                    <a href="{{ route('questions-en-attente.team', ['team' => 'Trésorerie']) }}" class="btn btn-outline-primary" style="border: 1px solid #002D5D; color: white !important; background: @if($team === 'Trésorerie') #0056B3 @else #002D5D @endif; border-radius: 8px; transition: all 0.2s ease;">
                        <i class="bi bi-cash-coin me-1"></i> Trésorerie
                    </a>
                    <a href="{{ route('questions-en-attente.team', ['team' => 'Donneurs de Voix']) }}" class="btn btn-outline-primary" style="border: 1px solid #002D5D; color: white !important; background: @if($team === 'Donneurs de Voix') #0056B3 @else #002D5D @endif; border-radius: 8px; transition: all 0.2s ease;">
                        <i class="bi bi-mic me-1"></i> Donneurs de Voix
                    </a>
                    <a href="{{ route('questions-en-attente.team', ['team' => 'Donneurs de Temps']) }}" class="btn btn-outline-primary" style="border: 1px solid #002D5D; color: white !important; background: @if($team === 'Donneurs de Temps') #0056B3 @else #002D5D @endif; border-radius: 8px; transition: all 0.2s ease;">
                        <i class="bi bi-clock me-1"></i> Donneurs de Temps
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Questions en attente -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #FFC107 0%, #FFB300 100%); border: none; color: #000; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-clock me-2"></i> Questions en attente
                    </h5>
                </div>
                <div class="card-body">
                    @php
                    $teamIcons = [
                        'Président' => 'bi bi-person-circle',
                        'Secrétariat' => 'bi bi-file-text',
                        'Trésorerie' => 'bi bi-cash-coin',
                        'Donneurs de Voix' => 'bi bi-mic',
                        'Donneurs de Temps' => 'bi bi-clock',
                    ];
                    
                    $teamToAccordion = [
                        'Président' => 'collapsePresidentResolues',
                        'Secrétariat' => 'collapseSecretariatResolues',
                        'Trésorerie' => 'collapseTresorerieResolues',
                        'Donneurs de Voix' => 'collapseDonneursVoixResolues',
                        'Donneurs de Temps' => 'collapseDonneursTempsResolues',
                    ];
                    @endphp
                    @if($pendingQuestions->isEmpty())
                        <div class="alert alert-info mb-0" style="background: rgba(0, 123, 255, 0.1); border-left: 4px solid #0DC5FF; border-radius: 8px;">
                            Aucune question en attente.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover" id="pendingQuestionsTable" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); color: white;">
                                    <tr>
                                        <th class="sortable" data-sort="date" style="padding: 12px; white-space: nowrap; cursor: pointer; user-select: none;">
                                            Date <i class="bi bi-arrow-down-up ms-1"></i>
                                        </th>
                                        <th class="sortable" data-sort="nom" style="padding: 12px; white-space: nowrap; cursor: pointer; user-select: none;">
                                            Nom <i class="bi bi-arrow-down-up ms-1"></i>
                                        </th>
                                        <th class="sortable" data-sort="email" style="padding: 12px; white-space: nowrap; cursor: pointer; user-select: none;">
                                            Email <i class="bi bi-arrow-down-up ms-1"></i>
                                        </th>
                                        <th style="padding: 12px; white-space: nowrap;">Forum concerné</th>
                                        <th class="sortable" data-sort="question" style="padding: 12px; cursor: pointer; user-select: none;">
                                            Question <i class="bi bi-arrow-down-up ms-1"></i>
                                        </th>
                                        <th style="padding: 12px; white-space: nowrap;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingQuestions as $question)
                                        <tr style="border-bottom: 1px solid #E9ECEF; transition: all 0.2s ease;" data-date="{{ $question->created_at ? $question->created_at->timestamp : 0 }}" data-nom="{{ $question->name ? e($question->name) : '' }}" data-email="{{ $question->email ? e($question->email) : '' }}" data-question="{{ $question->message ? e($question->message) : '' }}">
                                            <td style="padding: 12px; color: #495057;">{{ $question->created_at->format('d/m/Y H:i') }}</td>
                                            <td style="padding: 12px; color: #495057;">{{ $question->name }}</td>
                                            <td style="padding: 12px; color: #495057;">{{ $question->email }}</td>
                                            <td style="padding: 12px; color: #495057;">
                                                @php
                                                $questionTeam = $question->team ?? $question->destination ?? $question->group ?? 'Président';
                                                $discussionTitle = $question->discussion_title ?? null;
                                                
                                                if (!$discussionTitle && isset($question->discussion) && $question->discussion) {
                                                    $discussionTitle = $question->discussion->title ?? null;
                                                }
                                                
                                                $forumLabel = $discussionTitle ? Str::limit($discussionTitle, 30) : $questionTeam;
                                                @endphp
                                                <i class="{{ $teamIcons[$questionTeam] ?? 'bi bi-question-circle' }} me-1"></i>
                                                {{ $forumLabel }}
                                            </td>
                                            <td style="padding: 12px; color: #495057;">{{ Str::limit($question->message, 50) }}</td>
                                            <td style="padding: 12px;">
                                                @php
                                                $questionTeam = $question->team ?? $question->destination ?? $question->group ?? 'Président';
                                                $accordionId = $teamToAccordion[$questionTeam] ?? 'collapsePresidentResolues';
                                                $questionTitle = $question->subject ?? $question->discussion_title ?? '';
                                                @endphp
                                                <a href="{{ route('questions-details', ['question' => $question->id]) }}" class="btn btn-sm btn-main text-white" style="font-size: 0.85rem; padding: 6px 12px; border-radius: 6px;">
                                                    <i class="bi bi-eye me-1"></i> Détails
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
    <div class="row mb-4">
        <div class="col-12">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header cursor-pointer" 
                     data-bs-toggle="collapse" 
                     data-bs-target="#resolvedQuestionsCollapse" 
                     aria-expanded="false" 
                     style="background: linear-gradient(135deg, #28A745 0%, #20C997 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-check-circle-fill me-2"></i> Questions résolues
                        <i class="bi bi-chevron-down ms-auto"></i>
                    </h5>
                </div>
                <div id="resolvedQuestionsCollapse" class="collapse" data-bs-parent="#questionsAccordion">
                    <div class="card-body">
                        @if($resolvedQuestions->isEmpty())
                            <div class="alert alert-info mb-0" style="background: rgba(0, 123, 255, 0.1); border-left: 4px solid #0DC5FF; border-radius: 8px;">
                                Aucune question résolue.
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table table-hover" id="resolvedQuestionsTable" style="border-collapse: separate; border-spacing: 0;">
                                    <thead style="background: linear-gradient(135deg, #28A745 0%, #20C997 100%); color: white;">
                                        <tr>
                                            <th class="sortable" data-sort="date" style="padding: 12px; white-space: nowrap; cursor: pointer; user-select: none;">
                                                Date <i class="bi bi-arrow-down-up ms-1"></i>
                                            </th>
                                            <th class="sortable" data-sort="nom" style="padding: 12px; white-space: nowrap; cursor: pointer; user-select: none;">
                                                Nom <i class="bi bi-arrow-down-up ms-1"></i>
                                            </th>
                                            <th class="sortable" data-sort="email" style="padding: 12px; white-space: nowrap; cursor: pointer; user-select: none;">
                                                Email <i class="bi bi-arrow-down-up ms-1"></i>
                                            </th>
                                            <th style="padding: 12px; white-space: nowrap;">Forum concerné</th>
                                            <th class="sortable" data-sort="message" style="padding: 12px; cursor: pointer; user-select: none;">
                                                Message <i class="bi bi-arrow-down-up ms-1"></i>
                                            </th>
                                            <th style="padding: 12px; white-space: nowrap;">Résolue par</th>
                                            <th style="padding: 12px; white-space: nowrap;">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($resolvedQuestions as $question)
                                            <tr class="table-success" style="border-bottom: 1px solid #E9ECEF;" data-date="{{ $question->created_at ? $question->created_at->timestamp : 0 }}" data-nom="{{ $question->name ? e($question->name) : '' }}" data-email="{{ $question->email ? e($question->email) : '' }}" data-question="{{ $question->message ? e($question->message) : '' }}">
                                                <td style="padding: 12px; color: #495057;">{{ $question->created_at->format('d/m/Y H:i') }}</td>
                                                <td style="padding: 12px; color: #495057;">{{ $question->name }}</td>
                                                <td style="padding: 12px; color: #495057;">{{ $question->email }}</td>
                                                <td style="padding: 12px; color: #495057;">
                                                    @php
                                                    $questionTeam = $question->team ?? $question->destination ?? $question->group ?? 'Président';
                                                    $discussionTitle = $question->discussion_title ?? null;
                                                    
                                                    if (!$discussionTitle && isset($question->discussion) && $question->discussion) {
                                                        $discussionTitle = $question->discussion->title ?? null;
                                                    }
                                                    
                                                    $forumLabel = $discussionTitle ? Str::limit($discussionTitle, 30) : $questionTeam;
                                                    @endphp
                                                    <i class="{{ $teamIcons[$questionTeam] ?? 'bi bi-question-circle' }} me-1"></i>
                                                    {{ $forumLabel }}
                                                </td>
                                                <td style="padding: 12px; color: #495057;">{{ Str::limit($question->message, 50) }}</td>
                                                <td style="padding: 12px; color: #495057;">
                                                    @if($question->resolver)
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-1" alt="Résolveur" width="20" height="20">
                                                            <small>{{ $question->resolver->name }}</small>
                                                        </div>
                                                    @else
                                                        <small class="text-muted">Inconnu</small>
                                                    @endif
                                                </td>
                                                <td style="padding: 12px;">
                                                    @if($question->answered_by)
                                                        <span class="text-muted small">Réponse directe</span>
                                                    @else
                                                        @php
                                                        // Essayer de trouver la discussion associée
                                                        $discussionId = null;
                                                        $questionTeam = $question->destination ?? $question->team ?? $question->group ?? $team ?? '';
                                                        
                                                        // Vérifier les champs directs de la question
                                                        $possibleFields = ['discussion_id', 'thread_id', 'forum_post_id', 'related_discussion_id', 'forum_id', 'post_id'];
                                                        foreach ($possibleFields as $field) {
                                                            if (!empty($question->$field)) {
                                                                $discussionId = $question->$field;
                                                                break;
                                                            }
                                                        }
                                                        
                                                        // Vérifier les relations de la question
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
                                                        
                                                        // Si pas trouvé, chercher dans la liste des discussions passées par le contrôleur
                                                        if (!$discussionId && isset($discussions)) {
                                                            foreach ($discussions as $discussion) {
                                                                // Chercher l'ID de la question dans le titre ou le contenu de la discussion
                                                                if (str_contains($discussion->title, '#'.$question->id) || 
                                                                    str_contains($discussion->title, 'Question '.$question->id) ||
                                                                    str_contains($discussion->content, '#'.$question->id) ||
                                                                    str_contains($discussion->content, 'Question '.$question->id)) {
                                                                    $discussionId = $discussion->id;
                                                                    break;
                                                                }
                                                                // Vérifier si le message de la question est dans la discussion
                                                                elseif (str_contains($discussion->content, $question->message) && 
                                                       $discussion->team === $questionTeam) {
                                                                    $discussionId = $discussion->id;
                                                                    break;
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
                                                        
                                                        $accordionId = $teamToAccordion[$questionTeam] ?? $teamToAccordion['Président'];
                                                        @endphp
                                                        @if($discussionId)
                                                        <a href="{{ route('discussions.show', ['discussion' => $discussionId]) }}" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           target="_blank" style="font-size: 0.8rem; padding: 4px 8px; border-radius: 6px;">
                                                            <i class="bi bi-eye me-1"></i> Voir le forum
                                                        </a>
                                                        @else
                                                        <!-- Si pas de discussion trouvée, pointer vers le groupe avec filtre -->
                                                        <a href="/agora?group={{ urlencode($questionTeam) }}#{{ $accordionId }}" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           target="_blank" style="font-size: 0.8rem; padding: 4px 8px; border-radius: 6px;">
                                                            <i class="bi bi-eye me-1"></i> Voir le forum
                                                        </a>
                                                        @endif
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

    <!-- Lien pour retourner à Agora -->
    <div class="text-center my-4">
        <a href="/agora" class="btn btn-lg text-white px-5 py-3 shadow-lg" style="font-size: 1.2rem; font-weight: 700; border: none; border-radius: 10px; background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); box-shadow: 0 4px 15px rgba(0, 45, 93, 0.3); transition: all 0.3s ease;">
            <i class="bi bi-arrow-left me-2"></i> Retour à l'Agora
        </a>
    </div>
</div>

<style>
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
    
    /* Style des boutons de filtre */
    .btn-outline-primary:hover {
        background: #002D5D;
        color: white !important;
        border-color: #002D5D;
    }
    
    /* Style des cellules du tableau */
    .table th, .table td {
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: rgba(0, 45, 93, 0.03);
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

        // Fonction utilitaire pour trier un tableau
        function setupTableSorting(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;
            
            const sortableHeaders = table.querySelectorAll('th.sortable');
            
            sortableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const sortKey = this.getAttribute('data-sort');
                    const tbody = table.querySelector('tbody');
                    const rows = Array.from(tbody.querySelectorAll('tr'));
                    
                    // Déterminer la direction de tri
                    const currentDir = this.getAttribute('data-dir') || 'asc';
                    const newDir = currentDir === 'asc' ? 'desc' : 'asc';
                    this.setAttribute('data-dir', newDir);
                    
                    // Mettre à jour les icônes de tri
                    sortableHeaders.forEach(h => {
                        const icon = h.querySelector('.bi-arrow-down-up, .bi-arrow-up, .bi-arrow-down');
                        if (icon) {
                            if (h === this) {
                                icon.className = newDir === 'asc' ? 'bi bi-arrow-up' : 'bi bi-arrow-down';
                            } else {
                                icon.className = 'bi bi-arrow-down-up';
                            }
                        }
                    });
                    
                    // Trier les lignes
                    rows.sort((a, b) => {
                        let aValue = a.getAttribute(`data-${sortKey}`);
                        let bValue = b.getAttribute(`data-${sortKey}`);
                        
                        // Gestion des valeurs numériques (pour la date)
                        if (sortKey === 'date') {
                            return newDir === 'asc' ? parseInt(aValue) - parseInt(bValue) : parseInt(bValue) - parseInt(aValue);
                        }
                        
                        // Gestion des valeurs textuelles
                        aValue = aValue ? aValue.toLowerCase() : '';
                        bValue = bValue ? bValue.toLowerCase() : '';
                        
                        if (aValue < bValue) return newDir === 'asc' ? -1 : 1;
                        if (aValue > bValue) return newDir === 'asc' ? 1 : -1;
                        return 0;
                    });
                    
                    // Réinsérer les lignes triées
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        }
        
        // Activer le tri pour les deux tableaux
        setupTableSorting('pendingQuestionsTable');
        setupTableSorting('resolvedQuestionsTable');
    });
</script>
@endsection

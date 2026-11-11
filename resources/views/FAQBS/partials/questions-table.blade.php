@php
    $teamIcons = [
        'Président' => 'bi-person-circle',
        'Secrétariat' => 'bi-file-earmark-text',
        'Trésorerie' => 'bi-cash-coin',
        'Donneurs de Voix' => 'bi-mic',
        'Donneurs de Temps' => 'bi-clock',
    ];
    
    $teamToAccordion = [
        'Président' => 'collapsePresidentResolues',
        'Secrétariat' => 'collapseSecretariatResolues',
        'Trésorerie' => 'collapseTresorerieResolues',
        'Donneurs de Voix' => 'collapseDonneursVoixResolues',
        'Donneurs de Temps' => 'collapseDonneursTempsResolues',
    ];
@endphp

<div class="table-responsive">
    <table class="table table-hover" id="{{ $tableId }}" style="border-collapse: separate; border-spacing: 0;">
        <thead class="gradient-red" style="color: white;">
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
                @if($showResolutionDate)
                    <th class="sortable" data-sort="resolved_at" style="padding: 12px; white-space: nowrap; cursor: pointer; user-select: none;">
                        Date résolution <i class="bi bi-arrow-down-up ms-1"></i>
                    </th>
                @endif
                @if($showResolver)
                    <th style="padding: 12px; white-space: nowrap;">Résolue par</th>
                @endif
                <th style="padding: 12px; white-space: nowrap;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
                @php
                    $questionTeam = $question->team ?? $question->destination ?? $question->group ?? 'Président';
                    $discussionTitle = $question->discussion_title ?? null;
                    
                    if (!$discussionTitle && isset($question->discussion) && $question->discussion) {
                        $discussionTitle = $question->discussion->title ?? null;
                    }
                    
                    $forumLabel = $discussionTitle ? Str::limit($discussionTitle, 30) : $questionTeam;
                    
                    // Trouver la discussion associée
                    $discussionId = null;
                    $possibleFields = ['discussion_id', 'thread_id', 'forum_post_id', 'related_discussion_id', 'forum_id', 'post_id'];
                    foreach ($possibleFields as $field) {
                        if (!empty($question->$field)) {
                            $discussionId = $question->$field;
                            break;
                        }
                    }
                    
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
                    
                    if (!$discussionId && isset($discussions)) {
                        foreach ($discussions as $discussion) {
                            if (str_contains($discussion->title, '#'.$question->id) || 
                                str_contains($discussion->title, 'Question '.$question->id) ||
                                str_contains($discussion->content, '#'.$question->id) ||
                                str_contains($discussion->content, 'Question '.$question->id)) {
                                $discussionId = $discussion->id;
                                break;
                            }
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
                
                <tr style="border-bottom: 1px solid #E9ECEF;" 
                    data-date="{{ $question->created_at ? $question->created_at->timestamp : 0 }}"
                    data-nom="{{ $question->name ? e($question->name) : '' }}"
                    data-email="{{ $question->email ? e($question->email) : '' }}"
                    data-question="{{ $question->message ? e($question->message) : '' }}"
                    @if($showResolutionDate)
                        data-resolved-at="{{ $question->resolved_at ? $question->resolved_at->timestamp : 0 }}"
                    @endif>
                    <td style="padding: 12px; color: #495057;">{{ $question->created_at->format('d/m/Y H:i') }}</td>
                    <td style="padding: 12px; color: #495057;">{{ $question->name }}</td>
                    <td style="padding: 12px; color: #495057;">{{ $question->email }}</td>
                    <td style="padding: 12px; color: #495057;">
                        <i class="bi {{ $teamIcons[$questionTeam] ?? 'bi-question-circle' }} me-1"></i>
                        {{ $forumLabel }}
                    </td>
                    <td style="padding: 12px; color: #495057;">{{ Str::limit($question->message, 50) }}</td>
                    @if($showResolutionDate)
                        <td style="padding: 12px; color: #495057;">
                            {{ $question->resolved_at ? $question->resolved_at->format('d/m/Y H:i') : 'Non résolue' }}
                        </td>
                    @endif
                    @if($showResolver)
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
                    @endif
                    <td style="padding: 12px;">
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('questions-details', ['question' => $question->id]) }}" 
                               class="btn btn-sm btn-gradient-red btn-custom" style="font-size: 0.85rem; padding: 6px 12px; border-radius: 6px;">
                                <i class="bi bi-eye me-1"></i> {{ $actionLabel }}
                            </a>
                            @if($discussionId)
                                <a href="{{ route('discussions.show', ['discussion' => $discussionId]) }}" 
                                   class="btn btn-sm btn-outline-success btn-custom" style="font-size: 0.8rem; padding: 4px 8px; border-radius: 6px;">
                                    <i class="bi bi-eye me-1"></i> Voir la discussion
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

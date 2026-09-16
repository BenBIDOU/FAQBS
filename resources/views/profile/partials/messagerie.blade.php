<div class="mb-4">
    <h3 class="mb-2">Questions que j'ai posées</h3>
    <p class="text-muted">
        Ici s'affichent les réponses à vos questions.
    </p>
</div>

<div class="row">
    @forelse($answeredQuestions as $question)
        <div class="col-12 mb-3" id="question-{{ $question->id }}">
            <div class="card border-start border-3 border-bordeaux h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="bi bi-envelope-open me-2"></i>
                                {{ Str::limit($question->message, 50) }}
                            </h5>
                            <p class="text-muted small mb-1">
                                Question posée le {{ $question->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-bordeaux">
                                {{ $question->team }}
                            </span>
                            <button type="button" class="btn btn-sm btn-outline-danger p-1 delete-question-btn" 
                                    title="Supprimer la question"
                                    data-question-id="{{ $question->id }}"
                                    data-route="{{ route('questions.destroy', $question->id) }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <strong>Votre question :</strong>
                        <p class="mb-2">{{ $question->message }}</p>
                    </div>
                    
                    @if($question->answer)
                        <div class="bg-light p-3 rounded-3 mt-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <strong>Réponse :</strong>
                                @if($question->answerer)
                                    <span class="text-muted small">
                                        Répondu par {{ $question->answerer->name }} 
                                        le {{ $question->answered_at ? $question->answered_at->format('d/m/Y à H:i') : $question->resolved_at->format('d/m/Y à H:i') }}
                                    </span>
                                @endif
                            </div>
                            <p class="mb-0">{{ $question->answer }}</p>
                        </div>
                    @else
                        <div class="alert alert-info small mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            En attente de réponse...
                        </div>
                    @endif
                    
                    <!-- Discussions associées -->
                    @php
                        $relatedDiscussions = [];
                        if (isset($discussions)) {
                            foreach ($discussions as $discussion) {
                                // Vérifier si la discussion est liée à cette question
                                if (($discussion->title && str_contains($discussion->title, '#'.$question->id)) ||
                                    ($discussion->title && str_contains($discussion->title, 'Question '.$question->id)) ||
                                    ($discussion->content && str_contains($discussion->content, '#'.$question->id)) ||
                                    ($discussion->content && str_contains($discussion->content, 'Question '.$question->id)) ||
                                    ($discussion->question_id == $question->id) ||
                                    ($discussion->id == $question->discussion_id)) {
                                    $relatedDiscussions[] = $discussion;
                                }
                            }
                        }
                    @endphp
                    
                    @if(!empty($relatedDiscussions))
                        <div class="mt-3">
                            <strong><i class="bi bi-chat-left-text me-1"></i> Discussions associées :</strong>
                            <div class="mt-2">
                                @foreach($relatedDiscussions as $discussion)
                                    <a href="{{ route('discussions.show', $discussion->id) }}" 
                                       class="btn btn-sm btn-outline-primary mb-2" 
                                       style="border-radius: 6px; padding: 6px 12px;">
                                        <i class="bi bi-arrow-right-circle me-1"></i> 
                                        {{ Str::limit($discussion->title ?? 'Discussion sans titre', 40) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-inbox me-2"></i>
                Vous n'avez aucune question avec réponse pour le moment.
            </div>
        </div>
    @endforelse
</div>

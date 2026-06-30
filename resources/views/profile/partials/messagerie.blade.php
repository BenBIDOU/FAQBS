<div class="mb-4">
    <h3 class="mb-2">Messagerie</h3>
    <p class="text-muted">
        Ici s'affichent les réponses à vos questions.
    </p>
</div>

<div class="row">
    @forelse($answeredQuestions as $question)
        <div class="col-12 mb-3">
            <div class="card border-start border-3 border-bordeaux h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="bi bi-envelope-open me-2"></i>
                                {{ $question->subject }}
                            </h5>
                            <p class="text-muted small mb-1">
                                Question posée le {{ $question->created_at->format('d/m/Y à H:i') }}
                            </p>
                        </div>
                        <span class="badge bg-bordeaux">
                            {{ $question->team }}
                        </span>
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

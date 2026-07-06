@extends('layouts.app')

@section('title')
Gestion des questions - Bibliothèques sonores de la région Centre - Val de Loire
@endsection

@section('content')
<div class="container-fluid" style="background: #1a1a1a; min-height: 100vh;">
    <!-- Header moderne -->
    <div class="page-header mb-4" style="background-color: #2c3e50; border-bottom: 2px solid #005678; padding: 1.5rem 0; margin-bottom: 1.5rem !important;">
        <div class="row align-items-center">
            <div class="col-auto">
                <img src="{{ asset('images/logo.png') }}" class="img-fluid" style="max-height: 120px; margin-left: 6px;">
            </div>
            <div class="col text-center">
                <h1 class="mb-1" style="color: #ffffff; font-weight: 700; font-size: 2rem;">Gestion des questions</h1>
                <p class="mb-0" style="color: #e0e0e0; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <!-- Messages d'alerte -->
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            @if(session('success'))
                <div class="alert mb-4" style="background: rgba(40, 167, 69, 0.2); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); padding: 12px 16px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle me-2" style="color: #28A745; font-size: 1.2rem;"></i>
                        <span style="color: #c3e6cb; font-weight: 500;">{{ session('success') }}</span>
                    </div>
                </div>
            @endif
            @if(session('error'))
                <div class="alert mb-4" style="background: rgba(220, 53, 69, 0.2); border-left: 4px solid #dc3545; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); padding: 12px 16px;">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-circle me-2" style="color: #dc3545; font-size: 1.2rem;"></i>
                        <span style="color: #f5c6cb; font-weight: 500;">{{ session('error') }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Carte principale -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card" style="background: #2d2d2d; border: 1px solid #495057; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                <div class="card-header" style="background: linear-gradient(135deg, #495057 0%, #6c757d 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-question-circle me-2"></i> Gestion des questions
                    </h5>
                </div>
                <div class="card-body" style="color: #e0e0e0;">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="mb-0" style="color: #adadad;">Liste de toutes les questions posées</p>
                        <a href="/agora" class="btn btn-outline-light text-light" style="border: 1px solid #6c757d;">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    @if($questions->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox" style="font-size: 4rem; color: #6c757d !important; opacity: 0.7;"></i>
                            <h5 class="mt-3" style="color: #adadad !important;">Aucune question trouvée</h5>
                            <p class="text-muted" style="color: #8a8a8a !important;">Aucune question n'a été posée pour le moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover" style="border-collapse: separate; border-spacing: 0; color: #e0e0e0;">
                                <thead style="background: #343a40; color: #e0e0e0; border-radius: 8px 8px 0 0; overflow: hidden;">
                                    <tr>
                                        <th style="padding: 12px; border-top: none; border-bottom: 1px solid #495057; color: #ffffff; font-weight: 600; white-space: nowrap;">Nom</th>
                                        <th style="padding: 12px; border-top: none; border-bottom: 1px solid #495057; color: #ffffff; font-weight: 600; white-space: nowrap;">Email</th>
                                        <th style="padding: 12px; border-top: none; border-bottom: 1px solid #495057; color: #ffffff; font-weight: 600; white-space: nowrap;">Équipe</th>
                                        <th style="padding: 12px; border-top: none; border-bottom: 1px solid #495057; color: #ffffff; font-weight: 600; white-space: nowrap;">Date</th>
                                        <th style="padding: 12px; border-top: none; border-bottom: 1px solid #495057; color: #ffffff; font-weight: 600; white-space: nowrap;">Statut</th>
                                        <th style="padding: 12px; border-top: none; border-bottom: 1px solid #495057; color: #ffffff; font-weight: 600; white-space: nowrap;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($questions as $question)
                                        <tr style="background: #3d3d3d; border: 1px solid #495057; border-radius: 8px; margin-bottom: 8px;">
                                            <td style="padding: 12px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057; color: #e0e0e0;">
                                                <strong>{{ $question->name }}</strong>
                                            </td>
                                            <td style="padding: 12px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057; color: #e0e0e0;">{{ $question->email }}</td>
                                            <td style="padding: 12px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057;">
                                                <span class="badge" style="background: rgba(108, 117, 125, 0.3); color: #adb5bd; border: 1px solid #6c757d; padding: 6px 12px; border-radius: 6px; font-size: 0.85em; font-weight: 500;">
                                                    {{ $question->team }}
                                                </span>
                                            </td>
                                            <td style="padding: 12px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057; color: #e0e0e0;">
                                                {{ $question->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}
                                            </td>
                                            <td style="padding: 12px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057;">
                                                @if($question->resolved)
                                                    <span class="badge" style="background: rgba(40, 167, 69, 0.3); color: #7cf2a3; border: 1px solid #28a745; padding: 6px 12px; border-radius: 6px; font-size: 0.85em; font-weight: 500;">Résolue</span>
                                                @else
                                                    <span class="badge" style="background: rgba(255, 193, 7, 0.3); color: #ffd700; border: 1px solid #ffc107; padding: 6px 12px; border-radius: 6px; font-size: 0.85em; font-weight: 500;">En attente</span>
                                                @endif
                                            </td>
                                            <td style="padding: 12px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057;">
                                                <div class="d-flex gap-2 flex-wrap">
                                                    <a href="{{ route('questions-details', $question->id) }}" 
                                                       class="btn btn-sm" 
                                                       title="Voir" style="background: rgba(0, 135, 189, 0.2); border: 1px solid #0087BC; color: #87ceeb; border-radius: 6px; padding: 6px 10px; transition: all 0.2s ease;">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('questions.edit', $question->id) }}" 
                                                       class="btn btn-sm" 
                                                       title="Modifier" style="background: rgba(255, 193, 7, 0.2); border: 1px solid #FFC107; color: #ffd700; border-radius: 6px; padding: 6px 10px; transition: all 0.2s ease;">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('questions.destroy', $question->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette question ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm"
                                                                title="Supprimer" style="background: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #ff6b6b; border-radius: 6px; padding: 6px 10px; transition: all 0.2s ease;">
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
    /* Style des boutons pour le thème sombre */
    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.3);
    }
    
    /* Style du tableau pour le thème sombre */
    .table th, .table td {
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: rgba(60, 60, 60, 0.3);
    }
    
    .table-responsive {
        overflow-x: auto;
    }
    
    /* Style des badges pour le thème sombre */
    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
        border-radius: 20px;
        font-weight: 500;
    }
    
    /* Boutons avec transitions */
    .btn-sm {
        transition: all 0.2s ease;
    }
    
    .btn-sm:hover {
        transform: scale(1.05);
    }
</style>

@endsection

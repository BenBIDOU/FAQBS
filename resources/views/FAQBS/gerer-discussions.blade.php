@extends('layouts.app')

@section('title')
Gérer les discussions - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #ffffff; font-weight: 700; font-size: 2rem;">Gérer les discussions</h1>
                <p class="mb-0" style="color: #e0e0e0; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card" style="background: #2d2d2d; border: 1px solid #495057; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                <div class="card-header" style="background: linear-gradient(135deg, #495057 0%, #6c757d 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h4 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-chat-square-text me-2"></i>
                        Gestion des discussions
                    </h4>
                </div>
                <div class="card-body" style="color: #e0e0e0;">
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

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="mb-0" style="color: #adadad;">Liste de toutes les discussions</p>
                        <a href="/agora" class="btn btn-outline-light text-light" style="border: 1px solid #6c757d;">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>
                    
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="{{ route('discussion.create') }}" class="btn text-white" style="background: linear-gradient(135deg, #6c757d 0%, #495057 100%); border: none; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease; font-weight: 600;">
                            <i class="bi bi-plus-circle me-2"></i> Ajouter une discussion
                        </a>
                    </div>

                    @if($discussions->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-chat-square-text" style="font-size: 4rem; color: #6c757d !important; opacity: 0.7;"></i>
                            <h5 class="mt-3" style="color: #adadad !important;">Aucune discussion trouvée</h5>
                            <p class="text-muted" style="color: #8a8a8a !important;">Commencez par ajouter une nouvelle discussion.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="gestionDiscussionsTable" class="table table-hover" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: #6c757d; color: #000000; border-radius: 8px 8px 0 0; overflow: hidden;">
                                    <tr>
                                        <th class="sortable" data-sort="titre" style="padding: 16px; border-top: none; border-bottom: 1px solid #495057; color: #000000; font-weight: 600; cursor: pointer; user-select: none;">Titre <i class="bi bi-arrow-down-up ms-1"></i></th>
                                        <th class="sortable" data-sort="groupe" style="padding: 16px; border-top: none; border-bottom: 1px solid #495057; color: #000000; font-weight: 600; cursor: pointer; user-select: none;">Groupe <i class="bi bi-arrow-down-up ms-1"></i></th>
                                        <th class="sortable" data-sort="auteur" style="padding: 16px; border-top: none; border-bottom: 1px solid #495057; color: #000000; font-weight: 600; cursor: pointer; user-select: none;">Auteur <i class="bi bi-arrow-down-up ms-1"></i></th>
                                        <th class="sortable" data-sort="date" style="padding: 16px; border-top: none; border-bottom: 1px solid #495057; color: #000000; font-weight: 600; cursor: pointer; user-select: none;">Date de création <i class="bi bi-arrow-down-up ms-1"></i></th>
                                        <th style="padding: 16px; border-top: none; border-bottom: 1px solid #495057; color: #000000; font-weight: 600;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($discussions as $discussion)
                                        @php
                                        $auteurNom = $discussion->user ? $discussion->user->name : 'Inconnu';
                                        @endphp
                                        <tr style="background: #ffffff; border: 1px solid #495057; border-radius: 8px; margin-bottom: 8px;" 
                                            data-titre="{{ e($discussion->title) }}" 
                                            data-groupe="{{ e($discussion->group) }}" 
                                            data-auteur="{{ e($auteurNom) }}" 
                                            data-date="{{ $discussion->created_at ? $discussion->created_at->timestamp : 0 }}">
                                            <td style="padding: 16px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057; color: #000000;">
                                                <strong>{{ $discussion->title }}</strong>
                                                @if($discussion->link)
                                                    <div class="small" style="color: #000000; margin-top: 4px;">
                                                        <i class="bi bi-link-45deg"></i> 
                                                        <a href="{{ $discussion->link }}" target="_blank" class="text-decoration-none" style="color: #000000;">Lien</a>
                                                    </div>
                                                @endif
                                            </td>
                                            <td style="padding: 16px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057;">
                                                <span class="badge" style="background: rgba(0, 45, 93, 0.3); color: #000000; border: 1px solid #495057; padding: 6px 12px; border-radius: 6px; font-size: 0.85em; font-weight: 500;">
                                                    {{ $discussion->group }}
                                                </span>
                                            </td>
                                            <td style="padding: 16px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057; color: #000000;">
                                                @if($discussion->user)
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ asset('images/vous.png') }}" class="rounded-circle me-1" alt="Auteur" width="20" height="20">
                                                        <small>{{ $discussion->user->name }}</small>
                                                    </div>
                                                @else
                                                    <small style="color: #000000;">Inconnu</small>
                                                @endif
                                            </td>
                                            <td style="padding: 16px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057; color: #000000;">{{ $discussion->created_at->format('d/m/Y H:i') }}</td>
                                            <td style="padding: 16px; vertical-align: middle; border-top: none; border-bottom: 1px solid #495057;">
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('discussions.show', $discussion->id) }}" 
                                                       class="btn btn-sm" 
                                                       title="Voir" style="background: rgba(0, 135, 189, 0.2); border: 1px solid #0087BC; color: #87ceeb; border-radius: 6px; padding: 6px 12px; transition: all 0.2s ease;">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="{{ route('discussions.edit', $discussion->id) }}" 
                                                       class="btn btn-sm" 
                                                       title="Modifier" style="background: rgba(255, 193, 7, 0.2); border: 1px solid #FFC107; color: #ffd700; border-radius: 6px; padding: 6px 12px; transition: all 0.2s ease;">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('discussions.destroy', $discussion->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette discussion ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm"
                                                                title="Supprimer" style="background: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #ff6b6b; border-radius: 6px; padding: 6px 12px; transition: all 0.2s ease;">
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
    .sortable:hover {
        background: rgba(255, 255, 255, 0.1) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function setupTableSorting(tableId) {
            const table = document.getElementById(tableId);
            if (!table) return;
            
            const sortableHeaders = table.querySelectorAll('th.sortable');
            
            sortableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const sortKey = this.getAttribute('data-sort');
                    const tbody = table.querySelector('tbody');
                    const rows = Array.from(tbody.querySelectorAll('tr'));
                    
                    const currentDir = this.getAttribute('data-dir') || 'asc';
                    const newDir = currentDir === 'asc' ? 'desc' : 'asc';
                    this.setAttribute('data-dir', newDir);
                    
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
                    
                    rows.sort((a, b) => {
                        let aValue = a.getAttribute(`data-${sortKey}`);
                        let bValue = b.getAttribute(`data-${sortKey}`);
                        
                        if (sortKey === 'date') {
                            return newDir === 'asc' ? parseInt(aValue) - parseInt(bValue) : parseInt(bValue) - parseInt(aValue);
                        }
                        
                        aValue = aValue ? aValue.toLowerCase() : '';
                        bValue = bValue ? bValue.toLowerCase() : '';
                        
                        if (aValue < bValue) return newDir === 'asc' ? -1 : 1;
                        if (aValue > bValue) return newDir === 'asc' ? 1 : -1;
                        return 0;
                    });
                    
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        }
        
        setupTableSorting('gestionDiscussionsTable');
    });
</script>

@endsection

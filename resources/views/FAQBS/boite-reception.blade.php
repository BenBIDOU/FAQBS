@extends('layouts.app')

@section('title')
Boîte de réception - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Boîte de réception</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h5 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-inbox me-2"></i>
                        Boîte de réception
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="background: rgba(220, 53, 69, 0.1); border-left: 4px solid #DC3545; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <p class="mb-0" style="color: #495057;">Liste de vos messages reçus</p>
                        <a href="/agora" class="btn btn-outline-primary text-primary" style="border: 1px solid #002D5D; color: #002D5D !important; border-radius: 8px; transition: all 0.2s ease;">
                            <i class="bi bi-arrow-left me-1"></i> Retour
                        </a>
                    </div>

                    @if($receivedMessages->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-inbox text-muted fa-3x mb-3"></i>
                            <h5 class="text-muted">Aucun message reçu</h5>
                            <p class="text-muted">Vous n'avez aucun message pour le moment.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover" style="border-collapse: separate; border-spacing: 0;">
                                <thead style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); color: white;">
                                    <tr>
                                        <th style="padding: 12px; white-space: nowrap;">Expéditeur</th>
                                        <th style="padding: 12px; white-space: nowrap;">Sujet</th>
                                        <th style="padding: 12px; white-space: nowrap;">Date</th>
                                        <th style="padding: 12px; white-space: nowrap;">Statut</th>
                                        <th style="padding: 12px; white-space: nowrap;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($receivedMessages as $message)
                                        <tr class="{{ !$message->is_read ? 'table-active' : '' }}" style="border-bottom: 1px solid #E9ECEF;">
                                            <td style="padding: 12px; color: #495057;">
                                                <strong>{{ $message->sender->name ?? 'Inconnu' }}</strong>
                                            </td>
                                            <td style="padding: 12px; color: #495057;">{{ $message->subject }}</td>
                                            <td style="padding: 12px; color: #495057;">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                                            <td style="padding: 12px;">
                                                @if($message->is_read)
                                                    <span class="badge bg-success">Lu</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">Non lu</span>
                                                @endif
                                            </td>
                                            <td style="padding: 12px;">
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('messages.show', $message->id) }}" 
                                                       class="btn btn-sm btn-outline-info"
                                                       title="Lire" style="color: #0dcaf0; border-color: #0dcaf0; border-radius: 6px; padding: 6px 10px;">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <form action="{{ route('messages.destroy', $message->id) }}" method="POST"
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                                title="Supprimer" style="color: #dc3545; border-color: #dc3545; border-radius: 6px; padding: 6px 10px;">
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
    /* Style des boutons */
    .btn-outline-primary:hover {
        background: #002D5D;
        color: white !important;
        border-color: #002D5D;
    }
    
    .btn-outline-info:hover {
        background-color: #0dcaf0;
        color: #FFFFFF;
        border-color: #0dcaf0;
    }
    
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    
    /* Style des badges */
    .badge {
        padding: 0.35em 0.65em;
        border-radius: 20px;
        font-weight: 500;
    }
    
    /* Style du tableau */
    .table th, .table td {
        vertical-align: middle;
    }
    
    .table tbody tr:hover {
        background: rgba(0, 45, 93, 0.03);
    }
    
    .table-active {
        background-color: rgba(0, 123, 255, 0.1) !important;
    }
</style>

@endsection
@extends('layouts.app')

@section('title')
Message - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Message</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #002D5D 0%, #0056B3 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h4 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-envelope-open me-2"></i>
                        {{ $message->subject }}
                    </h4>
                </div>
                <div class="card-body">
                    <!-- Informations sur l'expéditeur et la date -->
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            @if($message->sender->photo)
                                <img src="{{ asset('storage/' . $message->sender->photo) }}" alt="Photo" 
                                     class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                     style="width: 50px; height: 50px; background: rgba(0, 45, 93, 0.1); border: 1px solid #002D5D;">
                                    <i class="bi bi-person" style="font-size: 1.5rem; color: #002D5D;"></i>
                                </div>
                            @endif
                            <div>
                                <strong class="d-block" style="color: #002D5D;">{{ $message->sender->name ?? 'Inconnu' }}</strong>
                                <small class="text-muted" style="color: #6c757d !important;">{{ $message->sender->email ?? '' }}</small>
                            </div>
                        </div>
                        <div class="text-muted small" style="color: #6c757d !important;">
                            {{ $message->created_at->format('d/m/Y à H:i') }}
                        </div>
                    </div>

                    <!-- Statut du message -->
                    @if($message->is_read)
                        <div class="alert mb-4" style="background: rgba(40, 167, 69, 0.1); border-left: 4px solid #28A745; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 12px 16px;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-check-circle me-2" style="color: #28A745; font-size: 1.2rem;"></i>
                                <span style="color: #155724; font-weight: 500;">Message marqué comme lu</span>
                            </div>
                        </div>
                    @else
                        <div class="alert mb-4" style="background: rgba(255, 193, 7, 0.1); border-left: 4px solid #FFC107; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); padding: 12px 16px;">
                            <div class="d-flex align-items-center">
                                <i class="bi bi-exclamation-circle me-2" style="color: #FFC107; font-size: 1.2rem;"></i>
                                <span style="color: #856404; font-weight: 500;">Nouveau message</span>
                            </div>
                        </div>
                    @endif

                    <!-- Contenu du message -->
                    <div class="card mb-4" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.05);">
                        <div class="card-body" style="white-space: pre-line; padding: 1.2rem; color: #495057;">
                            {{ $message->content }}
                        </div>
                    </div>

                    <!-- Boutons d'action -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('messages.inbox') }}" class="btn btn-outline-primary text-primary w-100 text-start d-flex justify-content-between align-items-center py-2" style="border-radius: 8px; border: 1px solid #002D5D; background: #FFFFFF; transition: all 0.2s ease; color: #002D5D !important;">
                            <span><i class="bi bi-arrow-left me-1"></i> Retour à la boîte de réception</span>
                        </a>
                        <form action="{{ route('messages.destroy', $message->id) }}" method="POST"
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce message ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 8px; padding: 8px 16px; transition: all 0.3s ease;">
                                <i class="bi bi-trash me-1"></i> Supprimer
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
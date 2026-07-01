@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Bouton Retour -->
            <div class="d-flex justify-content-end mb-3">
                <a href="/espace-membre" class="btn btn-outline-bordeaux">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>
            
            <h2 class="text-center mb-4">Mon Profil</h2>
            
            <!-- Informations et Photo de profil fusionnées -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-bordeaux text-white">
                    <button class="accordion-button collapsed w-100 text-start p-0" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#profileInfoCollapse" 
                            aria-expanded="false" aria-controls="profileInfoCollapse">
                        <span class="d-flex justify-content-between align-items-center w-100 p-3">
                            <span><i class="bi bi-person me-2"></i> Informations et Photo</span>
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </button>
                </div>
                <div id="profileInfoCollapse" class="collapse" data-bs-parent="#profileAccordion">
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Photo de profil à gauche -->
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div id="photo-container" class="text-center">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" 
                                             id="photo-preview" class="img-fluid rounded-circle mb-3" 
                                             style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                    @else
                                        <div id="photo-placeholder" class="d-flex flex-column align-items-center justify-content-center border border-2 border-dashed rounded-circle bg-light" 
                                             style="width: 200px; height: 200px; margin: 0 auto;">
                                            <i class="bi bi-person text-muted" style="font-size: 4rem;"></i>
                                            <span class="text-muted small mt-2">Glisser-déposer une photo</span>
                                        </div>
                                    @endif
                                    <form id="photo-upload-form" action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        <input type="file" name="photo" id="photo-input" accept="image/*" style="display: none;" required>
                                        <button type="button" id="choose-photo-btn" class="btn btn-outline-bordeaux btn-sm mt-2">
                                            <i class="bi bi-image me-1"></i> Choisir une photo
                                        </button>
                                        @if($user->photo)
                                            <button type="button" id="remove-photo-btn" class="btn btn-outline-danger btn-sm mt-2 ms-2">
                                                <i class="bi bi-trash me-1"></i> Supprimer
                                            </button>
                                        @endif
                                    </form>
                                </div>
                            </div>
                            
                            <!-- Informations à droite -->
                            <div class="col-md-8">
                                @include('profile.partials.update-profile-information-form')
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messagerie -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-bordeaux text-white">
                    <button class="accordion-button collapsed w-100 text-start p-0" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#messagerieCollapse" 
                            aria-expanded="false" aria-controls="messagerieCollapse">
                        <span class="d-flex justify-content-between align-items-center w-100 p-3">
                            <span class="d-flex align-items-center">
                                <i class="bi bi-envelope me-2"></i> Messagerie
                                @php
                                    $unreadCount = \App\Models\Question::where('email', auth()->user()->email)
                                        ->whereNotNull('answer')
                                        ->where('answer', '!=', '')
                                        ->count();
                                @endphp
                                @if($unreadCount > 0)
                                    <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                                @endif
                            </span>
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </button>
                </div>
                <div id="messagerieCollapse" class="collapse" data-bs-parent="#profileAccordion">
                    <div class="card-body p-4">
                        @include('profile.partials.messagerie')
                    </div>
                </div>
            </div>

            <!-- Modifier le mot de passe -->
            <div class="card shadow-lg border-0">
                <div class="card-header bg-bordeaux text-white">
                    <button class="accordion-button collapsed w-100 text-start p-0" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#passwordCollapse" 
                            aria-expanded="false" aria-controls="passwordCollapse">
                        <span class="d-flex justify-content-between align-items-center w-100 p-3">
                            <span><i class="bi bi-key me-2"></i> Modifier le mot de passe</span>
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </button>
                </div>
                <div id="passwordCollapse" class="collapse" data-bs-parent="#profileAccordion">
                    <div class="card-body p-4">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-bordeaux {
        background-color: #6D071A;
    }
    .btn-bordeaux {
        background-color: #6D071A;
        border-color: #6D071A;
    }
    .btn-bordeaux:hover {
        background-color: #5a0514;
        border-color: #5a0514;
    }
    .border-dashed {
        border-style: dashed !important;
    }
    .border-2 {
        border-width: 2px !important;
    }
    #photo-placeholder {
        cursor: pointer;
        transition: all 0.3s;
    }
    #photo-placeholder:hover {
        background-color: #f8f9fa;
        border-color: #6D071A !important;
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.getElementById('photo-input');
        const choosePhotoBtn = document.getElementById('choose-photo-btn');
        const photoPlaceholder = document.getElementById('photo-placeholder');
        const photoPreview = document.getElementById('photo-preview');
        const removePhotoBtn = document.getElementById('remove-photo-btn');
        const photoContainer = document.getElementById('photo-container');

        // Ouvrir le sélecteur de fichier quand on clique sur le bouton ou la zone placeholder
        if (choosePhotoBtn) {
            choosePhotoBtn.addEventListener('click', function() {
                photoInput.click();
            });
        }

        if (photoPlaceholder) {
            photoPlaceholder.addEventListener('click', function() {
                photoInput.click();
            });
        }

        // Gérer la sélection de fichier
        if (photoInput) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Afficher l'aperçu
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        if (photoPlaceholder) {
                            photoPlaceholder.style.display = 'none';
                        }
                        if (photoPreview) {
                            photoPreview.src = event.target.result;
                            photoPreview.style.display = 'block';
                        }
                        // Soumettre le formulaire automatiquement
                        document.getElementById('photo-upload-form').submit();
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Gérer le bouton de suppression
        if (removePhotoBtn) {
            removePhotoBtn.addEventListener('click', function() {
                if (confirm('Voulez-vous vraiment supprimer votre photo de profil ?')) {
                    // Créer un input caché pour la suppression
                    const form = document.getElementById('photo-upload-form');
                    const removeInput = document.createElement('input');
                    removeInput.type = 'hidden';
                    removeInput.name = 'remove_photo';
                    removeInput.value = '1';
                    form.appendChild(removeInput);
                    form.submit();
                }
            });
        }

        // Drag and Drop
        if (photoContainer) {
            photoContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                photoContainer.style.borderColor = '#6D071A';
                photoContainer.style.backgroundColor = '#f8f9fa';
            });

            photoContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                photoContainer.style.borderColor = '';
                photoContainer.style.backgroundColor = '';
            });

            photoContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                photoContainer.style.borderColor = '';
                photoContainer.style.backgroundColor = '';
                
                if (e.dataTransfer.files.length > 0) {
                    photoInput.files = e.dataTransfer.files;
                    // Déclencher le changement
                    const event = new Event('change');
                    photoInput.dispatchEvent(event);
                }
            });
        }
    });
</script>
@endsection

@extends('layouts.app')

@section('title', 'Mon Profil')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <!-- Messages de succès/erreur -->
            @if(session('status'))
                <div class="alert alert-success mb-3">
                    {{ session('status') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger mb-3">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- Bouton Retour -->
            <div class="d-flex justify-content-end mb-3">
                <a href="/agora" class="btn btn-outline-bordeaux">
                    <i class="bi bi-arrow-left me-1"></i> Retour
                </a>
            </div>
            
            <h2 class="text-center mb-4">Mon Profil</h2>
            
            <!-- Informations et Photo de profil fusionnées -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-bordeaux text-white">
                    <button class="accordion-button w-100 text-start p-0" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#profileInfoCollapse" 
                            aria-expanded="true" aria-controls="profileInfoCollapse">
                        <span class="d-flex justify-content-between align-items-center w-100 p-3">
                            <span><i class="bi bi-person me-2"></i> Informations et Photo</span>
                            <i class="bi bi-chevron-down"></i>
                        </span>
                    </button>
                </div>
                <div id="profileInfoCollapse" class="collapse show" data-bs-parent="#profileAccordion">
                    <div class="card-body p-4">
                        <div class="row">
                            <!-- Photo de profil à gauche -->
                            <div class="col-md-4 mb-4 mb-md-0">
                                <div id="photo-container" class="text-center p-3" style="border: 2px dashed #ccc; border-radius: 10px; min-height: 240px;">
                                    @if($user->photo)
                                        <img src="{{ asset('storage/' . $user->photo) }}" alt="Photo de profil" 
                                             id="photo-preview" class="img-fluid rounded-circle mb-3" 
                                             style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                    @else
                                        <div id="photo-placeholder" class="d-flex flex-column align-items-center justify-content-center rounded-circle bg-light" 
                                             style="width: 200px; height: 200px; margin: 0 auto;">
                                            <i class="bi bi-person text-muted" style="font-size: 4rem;"></i>
                                            <span class="text-muted small mt-2">Glisser-déposer une photo</span>
                                        </div>
                                    @endif
                                    <form id="photo-upload-form" action="{{ route('profile.photo.update') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('patch')
                                        <input type="file" name="photo" id="photo-input" accept="image/*" style="display: none;" onchange="this.form.submit();">
                                        <button type="button" id="choose-photo-btn" class="btn btn-outline-bordeaux btn-sm mt-2" onclick="document.getElementById('photo-input').click();">
                                            <i class="bi bi-image me-1"></i> Choisir une photo
                                        </button>
                                        @if($user->photo)
                                            <button type="submit" formaction="{{ route('profile.photo.update') }}?remove_photo=1" class="btn btn-outline-danger btn-sm mt-2 ms-2" onclick="return confirm('Voulez-vous vraiment supprimer votre photo de profil ?');">
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

            <!-- Questions que j'ai posées -->
            <div class="card shadow-lg border-0 mb-4">
                <div class="card-header bg-bordeaux text-white">
                    <button class="accordion-button collapsed w-100 text-start p-0" type="button" 
                            data-bs-toggle="collapse" data-bs-target="#questionsPoseesCollapse" 
                            aria-expanded="false" aria-controls="questionsPoseesCollapse">
                        <span class="d-flex justify-content-between align-items-center w-100 p-3">
                            <span class="d-flex align-items-center">
                                <i class="bi bi-envelope me-2"></i> Questions que j'ai posées
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
                <div id="questionsPoseesCollapse" class="collapse" data-bs-parent="#profileAccordion">
                    <div class="card-body p-4">
                        @include('profile.partials.messagerie', ['discussions' => $discussions])
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
        border: 2px dashed #ccc;
    }
    #photo-placeholder:hover {
        background-color: #f8f9fa;
        border-color: #6D071A !important;
    }
    
    #photo-container {
        cursor: pointer;
        transition: all 0.3s;
    }
    
    #photo-container.drag-over {
        border-color: #6D071A !important;
        background-color: #f8f9fa;
        border-style: solid !important;
    }
    
    #photo-preview {
        cursor: pointer;
    }
    
    #choose-photo-btn, #remove-photo-btn {
        cursor: pointer;
    }
    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: white;
        border-color: #dc3545;
    }
    .btn-outline-danger {
        color: #dc3545;
        border-color: #dc3545;
    }
    .btn-outline-primary:hover {
        background-color: #0056B3;
        color: white;
        border-color: #0056B3;
    }
    .btn-outline-primary {
        color: #002D5D;
        border-color: #002D5D;
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.getElementById('photo-input');
        const photoContainer = document.getElementById('photo-container');
        
        // Drag and Drop pour le glisser-déposer
        if (photoContainer && photoInput) {
            photoContainer.addEventListener('dragover', function(e) {
                e.preventDefault();
                e.stopPropagation();
                photoContainer.classList.add('drag-over');
            });

            photoContainer.addEventListener('dragleave', function(e) {
                e.preventDefault();
                e.stopPropagation();
                photoContainer.classList.remove('drag-over');
            });

            photoContainer.addEventListener('drop', function(e) {
                e.preventDefault();
                e.stopPropagation();
                photoContainer.classList.remove('drag-over');
                
                if (e.dataTransfer.files.length > 0) {
                    const file = e.dataTransfer.files[0];
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
                    const maxSize = 2 * 1024 * 1024;
                    
                    if (!validTypes.includes(file.type)) {
                        alert('Veuillez glisser une image valide (JPEG, PNG, JPG, GIF).');
                        return;
                    }
                    if (file.size > maxSize) {
                        alert('La photo doit faire moins de 2 Mo.');
                        return;
                    }
                    
                    // Utiliser DataTransfer pour assigner le fichier
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    photoInput.files = dataTransfer.files;
                    
                    // Soumettre automatiquement
                    photoInput.form.submit();
                }
            });
        }
    });
</script>

<script>
    // Suppression AJAX des questions
    document.querySelectorAll('.delete-question-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const questionId = this.getAttribute('data-question-id');
                const route = this.getAttribute('data-route');
                const questionElement = document.getElementById('question-' + questionId);
                
                if (confirm('Êtes-vous sûr de vouloir supprimer cette question ?')) {
                    fetch(route, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (response.ok) {
                            // Supprimer l'élément de la DOM
                            if (questionElement) {
                                questionElement.remove();
                            }
                            // Afficher un message de succès
                            alert('Question supprimée avec succès !');
                        } else {
                            return response.json().then(data => {
                                throw new Error(data.error || 'Erreur lors de la suppression');
                            });
                        }
                    })
                    .catch(error => {
                        alert('Erreur : ' + error.message);
                    });
                }
            });
        });
    });
</script>
@endsection

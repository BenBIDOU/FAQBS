@extends('layouts.app')

@section('title')
Ajouter une discussion - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Ajouter une discussion</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h4 class="mb-0" style="height: 100%;">Ajouter une nouvelle discussion</h4>
                </div>
                <div class="card-body">
                    <form id="discussionForm" method="POST" action="{{ route('discussions.store') }}" enctype="multipart/form-data">
                        @csrf
                        @if(isset($question_id))
                            <input type="hidden" name="question_id" value="{{ $question_id }}">
                        @endif

                        <!-- Nom, Prénom, Fonction (pré-remplis) -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="nom" class="form-label" style="color: #002D5D; font-weight: 500;">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" 
                                       value="{{ Auth::user()->name ?? '' }}" readonly
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057; background: #f8f9fa;">
                            </div>
                            <div class="col-md-4">
                                <label for="prenom" class="form-label" style="color: #002D5D; font-weight: 500;">Prénom</label>
                                <input type="text" class="form-control" id="prenom" name="prenom" 
                                       value="{{ Auth::user()->prenom ?? Auth::user()->firstname ?? '' }}" readonly
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057; background: #f8f9fa;">
                            </div>
                            <div class="col-md-4">
                                <label for="fonction" class="form-label" style="color: #002D5D; font-weight: 500;">Fonction</label>
                                <input type="text" class="form-control" id="fonction" name="fonction"
                                       @if(Auth::check())
                                           value="@if(Auth::user()->is_master) Master @elseif(Auth::user()->is_president) Président @elseif(Auth::user()->is_voice_donor) Donneur de Voix @else Membre @endif"
                                       @endif
                                       readonly
                                       style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057; background: #f8f9fa;">
                            </div>
                        </div>

                        <!-- Titre de la discussion -->
                        <div class="mb-3">
                            <label for="title" class="form-label" style="color: #002D5D; font-weight: 500;">Titre de la discussion</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $title ?? '' }}" required
                                   style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                        </div>

                        <!-- Groupe (menu déroulant) -->
                        <div class="mb-3">
                            <label for="group" class="form-label" style="color: #002D5D; font-weight: 500;">Groupe</label>
                            <select class="form-select" id="group" name="group" required
                                    style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                                <option value="" @if(!($group ?? '')) selected disabled @endif>Sélectionnez un groupe</option>
                                <option value="Président" @if(($group ?? '') === 'Président') selected @endif>Président</option>
                                <option value="Secrétariat" @if(($group ?? '') === 'Secrétariat') selected @endif>Secrétariat</option>
                                <option value="Trésorerie" @if(($group ?? '') === 'Trésorerie') selected @endif>Trésorerie</option>
                                <option value="Donneurs de Voix" @if(($group ?? '') === 'Donneurs de Voix') selected @endif>Donneurs de Voix</option>
                                <option value="Donneurs de Temps" @if(($group ?? '') === 'Donneurs de Temps') selected @endif>Donneurs de Temps</option>
                            </select>
                        </div>

                        <!-- Hyperlien -->
                        <div class="mb-3">
                            <label for="link" class="form-label" style="color: #002D5D; font-weight: 500;">Lien associé (optionnel)</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: transparent; border: 1px solid #E9ECEF; border-radius: 6px 0 0 6px; color: #002D5D;">https://</span>
                                <input type="text" class="form-control" id="link" name="link" placeholder="exemple.com/discussion"
                                       style="border-radius: 0 6px 6px 0; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                        </div>

                        <!-- Zone de texte -->
                        <div class="mb-3">
                            <label for="content" class="form-label" style="color: #002D5D; font-weight: 500;">Contenu de la discussion</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required
                                      style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">{{ $content ?? '' }}</textarea>
                        </div>

                        <!-- Zone de glisser-déposer pour la photo -->
                        <div class="mb-3">
                            <label for="image" class="form-label" style="color: #002D5D; font-weight: 500;">Image (optionnelle)</label>
                            <div class="drop-zone" id="dropZone" style="border: 2px dashed #E9ECEF; border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.3s; min-height: 150px; display: flex; flex-direction: column; justify-content: center; align-items: center; background: #FFFFFF; border-color: #E9ECEF;">
                                <div class="drop-zone-text" style="color: #6c757d;">
                                    <i class="mb-3 bi bi-cloud-upload fa-3x" style="font-size: 3rem; color: #990000;"></i>
                                    <p style="color: #6c757d; font-weight: 500;">Glissez-déposez une image ici ou cliquez pour sélectionner</p>
                                    <input type="file" id="image" name="image" class="form-control d-none" accept="image/*">
                                </div>
                                <div id="imagePreview" class="d-none" style="text-align: center;">
                                    <img id="previewImage" class="rounded img-fluid" style="max-height: 200px; border-radius: 8px;">
                                    <button type="button" class="mt-2 btn" id="removeImage" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; border: none; border-radius: 6px; padding: 8px 16px; transition: all 0.3s ease;">
                                        Retirer
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary me-md-2" style="color: #6c757d; border-color: #6c757d; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease;">
                                Réinitialiser
                            </button>
                            <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease; font-weight: 600;">
                                Publier la discussion
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Lien pour retourner à Agora -->
            <div class="my-4 text-center">
                <a href="/agora" class="btn text-white" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease; font-weight: 600;">
                    <i class="bi bi-arrow-left me-2"></i> Retour à Agora
                </a>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript pour la zone de glisser-déposer et la prévisualisation -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const fileInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');
        const previewImage = document.getElementById('previewImage');
        const removeImageBtn = document.getElementById('removeImage');

        // Gestion du glisser-déposer
        dropZone.addEventListener('click', () => fileInput.click());

        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#990000';
            dropZone.style.backgroundColor = 'rgba(153, 0, 0, 0.05)';
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.style.borderColor = '#E9ECEF';
            dropZone.style.backgroundColor = '#FFFFFF';
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.style.borderColor = '#E9ECEF';
            dropZone.style.backgroundColor = '#FFFFFF';
            if (e.dataTransfer.files.length) {
                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(e.dataTransfer.files[0]);
                fileInput.files = dataTransfer.files;
                updatePreview();
            }
        });

        fileInput.addEventListener('change', updatePreview);

        removeImageBtn.addEventListener('click', () => {
            fileInput.value = '';
            imagePreview.classList.add('d-none');
            dropZone.style.borderColor = '#E9ECEF';
            dropZone.style.backgroundColor = '#FFFFFF';
        });

        function updatePreview() {
            const file = fileInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('d-none');
                }
                reader.readAsDataURL(file);
            }
        }
    });
</script>
@endsection

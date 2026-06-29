@extends('layouts.app')

@section('title', 'Ajouter une discussion')

@section('content')
<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0">Ajouter une nouvelle discussion</h4>
                </div>
                <div class="card-body">
                    <form id="discussionForm" method="POST" action="{{ route('discussions.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Titre de la discussion -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Titre de la discussion</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <!-- Groupe (menu déroulant) -->
                        <div class="mb-3">
                            <label for="group" class="form-label">Groupe</label>
                            <select class="form-select" id="group" name="group" required>
                                <option value="" selected disabled>Sélectionnez un groupe</option>
                                <option value="Espace membre">Espace membre</option>
                                <option value="Secrétariat">Secrétariat</option>
                                <option value="Président">Président</option>
                                <option value="Donneurs Temps">Donneurs Temps</option>
                                <option value="Donneurs Voix">Donneurs Voix</option>
                            </select>
                        </div>

                        <!-- Hyperlien -->
                        <div class="mb-3">
                            <label for="link" class="form-label">Lien associé (optionnel)</label>
                            <div class="input-group">
                                <span class="input-group-text">https://</span>
                                <input type="text" class="form-control" id="link" name="link" placeholder="exemple.com/discussion">
                            </div>
                        </div>

                        <!-- Zone de texte -->
                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu de la discussion</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                        </div>

                        <!-- Zone de glisser-déposer pour la photo -->
                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optionnelle)</label>
                            <div class="drop-zone" id="dropZone">
                                <div class="drop-zone-text">
                                    <i class="mb-3 fas fa-cloud-upload-alt fa-3x"></i>
                                    <p>Glissez-déposez une image ici ou cliquez pour sélectionner</p>
                                    <input type="file" id="image" name="image" class="form-control d-none" accept="image/*">
                                </div>
                                <div id="imagePreview" class="d-none">
                                    <img id="previewImage" class="rounded img-fluid" style="max-height: 200px;">
                                    <button type="button" class="mt-2 btn btn-sm btn-danger" id="removeImage">Retirer</button>
                                </div>
                            </div>
                        </div>

                        <!-- Bouton de soumission -->
                        <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">Réinitialiser</button>
                            <button type="submit" class="text-white btn btn-bordeaux">Publier la discussion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- CSS pour la zone de glisser-déposer -->
<style>
    .drop-zone {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        min-height: 150px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .drop-zone:hover {
        border-color: #6D071A;
        background-color: #f8f9fa;
    }

    .drop-zone-text {
        color: #666;
    }

    .drop-zone.highlight {
        border-color: #6D071A;
        background-color: #f8f9fa;
    }

    #imagePreview img {
        max-width: 100%;
        max-height: 200px;
        display: block;
        margin: 0 auto;
    }

    .btn-bordeaux {
        background-color: #6D071A;
    }

    .btn-bordeaux:hover {
        background-color: #5a0515;
    }
</style>

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
            dropZone.classList.add('highlight');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('highlight');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('highlight');
            if (e.dataTransfer.files.length) {
                fileInput.files = e.dataTransfer.files;
                updatePreview();
            }
        });

        fileInput.addEventListener('change', updatePreview);

        removeImageBtn.addEventListener('click', () => {
            fileInput.value = '';
            imagePreview.classList.add('d-none');
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

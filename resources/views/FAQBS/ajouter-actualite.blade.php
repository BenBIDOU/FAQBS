@extends('layouts.app')

@section('title', 'Ajouter une actualité')

@section('content')
<div class="py-4 container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="shadow card">
                <div class="text-white card-header bg-bordeaux">
                    <h4 class="mb-0 text-dark">Ajouter une nouvelle actualité</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ url('/actualite/ajouter') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="title" class="form-label">Titre de l'actualité</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="mb-3">
                            <label for="summary" class="form-label">Résumé</label>
                            <textarea class="form-control" id="summary" name="summary" rows="3" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Contenu</label>
                            <textarea class="form-control" id="content" name="content" rows="6" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Image (optionnelle)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        </div>

                        <div class="gap-2 d-grid d-md-flex justify-content-md-end">
                            <button type="reset" class="btn btn-outline-secondary me-md-2">Réinitialiser</button>
                            <button type="submit" class="text-white btn btn-bordeaux">Publier l'actualité</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

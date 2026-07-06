@extends('layouts.app')

@section('title')
Modifier la discussion - Bibliothèques sonores de la région Centre - Val de Loire
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
                <h1 class="mb-1" style="color: #002D5D; font-weight: 700; font-size: 2rem;">Modifier la discussion</h1>
                <p class="mb-0" style="color: #495057; font-size: 1.1rem;">Bibliothèques sonores de la région Centre - Val de Loire</p>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card" style="background: #FFFFFF; border: 1px solid #E9ECEF; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <div class="card-header" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; color: white; font-weight: 600; border-radius: 10px 10px 0 0; height: 56px;">
                    <h4 class="mb-0 d-flex align-items-center" style="height: 100%;">
                        <i class="bi bi-pencil-square me-2"></i>
                        Modifier la discussion
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('discussions.update', $discussion->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="title" class="form-label" style="color: #002D5D; font-weight: 500;">Titre *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title', $discussion->title) }}" required
                                   style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                        </div>

                        <div class="mb-3">
                            <label for="group" class="form-label" style="color: #002D5D; font-weight: 500;">Groupe *</label>
                            <select class="form-select" id="group" name="group" required
                                    style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                                <option value="">Sélectionnez un groupe</option>
                                <option value="Président" {{ old('group', $discussion->group) == 'Président' ? 'selected' : '' }}>Président</option>
                                <option value="Secrétariat" {{ old('group', $discussion->group) == 'Secrétariat' ? 'selected' : '' }}>Secrétariat</option>
                                <option value="Trésorerie" {{ old('group', $discussion->group) == 'Trésorerie' ? 'selected' : '' }}>Trésorerie</option>
                                <option value="Donneurs Voix" {{ old('group', $discussion->group) == 'Donneurs Voix' ? 'selected' : '' }}>Donneurs Voix</option>
                                <option value="Donneurs Temps" {{ old('group', $discussion->group) == 'Donneurs Temps' ? 'selected' : '' }}>Donneurs Temps</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="link" class="form-label" style="color: #002D5D; font-weight: 500;">Lien (optionnel)</label>
                            <div class="input-group">
                                <span class="input-group-text" style="background: transparent; border: 1px solid #E9ECEF; border-radius: 6px 0 0 6px; color: #002D5D;">https://</span>
                                <input type="url" class="form-control" id="link" name="link" 
                                       value="{{ old('link', $discussion->link) }}"
                                       style="border-radius: 0 6px 6px 0; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label" style="color: #002D5D; font-weight: 500;">Contenu *</label>
                            <textarea class="form-control" id="content" name="content" rows="5" required
                                      style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">{{ old('content', $discussion->content) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label" style="color: #002D5D; font-weight: 500;">Image (optionnelle)</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                   style="border-radius: 6px; border: 1px solid #E9ECEF; padding: 12px 16px; color: #495057;">
                            @if($discussion->image_path)
                                <div class="mt-2" style="background: #f8f9fa; border-radius: 8px; padding: 16px; border: 1px solid #E9ECEF;">
                                    <img src="{{ asset('storage/' . $discussion->image_path) }}" alt="Image actuelle" 
                                         style="max-width: 100px; max-height: 100px; border-radius: 4px;" class="img-thumbnail">
                                    <small class="text-muted d-block" style="color: #6c757d !important; margin-top: 8px;">Image actuelle</small>
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('discussions.manage') }}" class="btn btn-outline-primary text-primary">
                                <i class="bi bi-arrow-left me-1"></i> Annuler
                            </a>
                            <button type="submit" class="btn text-white" style="background: linear-gradient(135deg, #990000 0%, #A00000 100%); border: none; border-radius: 8px; padding: 12px 24px; transition: all 0.3s ease; font-weight: 600;">
                                <i class="bi bi-check-lg me-1"></i> Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<div class="mb-4">
    <h3 class="mb-2">Informations du profil</h3>
    <p class="text-muted">
        Mettez à jour vos informations personnelles (nom, téléphone, ville de la BS). 
        Votre rôle est affiché à titre informatif.
    </p>
</div>

<form id="send-verification" method="post" action="{{ route('verification.send') }}">
    @csrf
</form>

<form method="post" action="{{ route('profile.update') }}" class="row g-3">
    @csrf
    @method('patch')

    <!-- Nom -->
    <div class="col-md-6">
        <label for="name" class="form-label">Nom *</label>
        <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" 
               value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div class="col-md-6">
        <label for="email" class="form-label">Email *</label>
        <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" 
               value="{{ old('email', $user->email) }}" required autocomplete="username">
        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
        
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mt-2">
                <p class="text-warning small mb-1">
                    Votre adresse email n'est pas vérifiée.
                </p>
                <button form="send-verification" class="btn btn-link btn-sm p-0 text-warning">
                    Cliquez ici pour renvoyer le lien de vérification.
                </button>
                
                @if (session('status') === 'verification-link-sent')
                    <p class="mt-1 text-success small">
                        Un nouveau lien de vérification a été envoyé à votre adresse email.
                    </p>
                @endif
            </div>
        @endif
    </div>

    <!-- Téléphone -->
    <div class="col-md-6">
        <label for="telephone" class="form-label">Téléphone</label>
        <input id="telephone" name="telephone" type="tel" class="form-control @error('telephone') is-invalid @enderror" 
               value="{{ old('telephone', $user->telephone ?? '') }}" autocomplete="tel">
        @error('telephone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Ville de la BS -->
    <div class="col-md-6">
        <label for="ville_bs" class="form-label">Ville de la BS</label>
        <input id="ville_bs" name="ville_bs" type="text" class="form-control @error('ville_bs') is-invalid @enderror" 
               value="{{ old('ville_bs', $user->ville_bs ?? '') }}" autocomplete="off">
        @error('ville_bs')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Rôle (affichage seulement) -->
    <div class="col-md-6">
        <label class="form-label">Rôle</label>
        <input type="text" class="form-control bg-light cursor-not-allowed" 
               value="@if($user->is_master) Master @elseif($user->is_president) Président @elseif($user->is_voice_donor) Donneur de Voix @else Membre @endif" 
               readonly />
    </div>

    <!-- Bouton de sauvegarde -->
    <div class="col-12">
        <div class="d-flex align-items-center gap-3 mt-4">
            <button type="submit" class="btn btn-bordeaux text-white">
                <i class="bi bi-check-lg me-1"></i> Enregistrer
            </button>
            
            @if (session('status') === 'profile-updated')
                <span class="text-success small">Informations enregistrées avec succès !</span>
            @endif
        </div>
    </div>
</form>

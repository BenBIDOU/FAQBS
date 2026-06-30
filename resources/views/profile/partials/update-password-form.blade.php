<div class="mb-4">
    <h3 class="mb-2">Modifier le mot de passe</h3>
    <p class="text-muted">
        Assurez-vous que votre compte utilise un mot de passe long et sécurisé.
    </p>
</div>

<form method="post" action="{{ route('password.update') }}" class="row g-3">
    @csrf
    @method('put')

    <!-- Mot de passe actuel -->
    <div class="col-12">
        <label for="update_password_current_password" class="form-label">Mot de passe actuel *</label>
        <input id="update_password_current_password" name="current_password" type="password" 
               class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
               autocomplete="current-password" required>
        @error('current_password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Nouveau mot de passe -->
    <div class="col-12">
        <label for="update_password_password" class="form-label">Nouveau mot de passe *</label>
        <input id="update_password_password" name="password" type="password" 
               class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
               autocomplete="new-password" required>
        @error('password', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Confirmer le mot de passe -->
    <div class="col-12">
        <label for="update_password_password_confirmation" class="form-label">Confirmer le mot de passe *</label>
        <input id="update_password_password_confirmation" name="password_confirmation" type="password" 
               class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
               autocomplete="new-password" required>
        @error('password_confirmation', 'updatePassword')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <!-- Bouton de sauvegarde -->
    <div class="col-12">
        <div class="d-flex align-items-center gap-3 mt-4">
            <button type="submit" class="btn btn-bordeaux text-white">
                <i class="bi bi-key me-1"></i> Modifier le mot de passe
            </button>
            
            @if (session('status') === 'password-updated')
                <span class="text-success small">Mot de passe modifié avec succès !</span>
            @endif
        </div>
    </div>
</form>

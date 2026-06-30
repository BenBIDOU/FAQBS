<div class="mb-4">
    <h3 class="mb-2">Supprimer le compte</h3>
    <p class="text-muted small">
        Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. 
        Avant de supprimer votre compte, veuillez télécharger toute donnée ou information que vous souhaitez conserver.
    </p>
</div>

<!-- Bouton pour ouvrir la modal de confirmation -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
    <i class="bi bi-trash me-1"></i> Supprimer mon compte
</button>

<!-- Modal de confirmation -->
<div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="{{ route('profile.destroy') }}" class="p-4">
                @csrf
                @method('delete')

                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmUserDeletionModalLabel">
                        Êtes-vous sûr de vouloir supprimer votre compte ?
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>

                <div class="modal-body">
                    <p class="text-muted small">
                        Une fois votre compte supprimé, toutes ses ressources et données seront définitivement supprimées. 
                        Veuillez entrer votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.
                    </p>

                    <div class="mt-3">
                        <label for="delete_password" class="form-label">Mot de passe *</label>
                        <input id="delete_password" name="password" type="password" 
                               class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                               placeholder="Votre mot de passe" required>
                        @error('password', 'userDeletion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-1"></i> Supprimer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

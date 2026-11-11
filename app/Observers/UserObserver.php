<?php

namespace App\Observers;

use App\Models\Profile;
use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Créer un profil vide pour le nouvel utilisateur
        Profile::create([
            'user_id' => $user->id,
            'is_active' => true,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // Optionnel: synchroniser certains champs si nécessaire
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        // Supprimer le profil associé
        $user->profile?->delete();
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        // Optionnel: restaurer le profil
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        // Supprimer définitivement le profil
        $user->profile?->forceDelete();
    }
}

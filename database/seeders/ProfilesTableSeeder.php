<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;
use App\Models\User;

class ProfilesTableSeeder extends Seeder
{
    public function run()
    {
        // Créer un profil pour chaque utilisateur existant
        $users = User::all();
        
        foreach ($users as $user) {
            Profile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'firstname' => null,
                    'lastname' => null,
                    'telephone' => $user->telephone,
                    'ville_bs' => $user->ville_bs,
                    'photo' => $user->photo,
                    'is_active' => $user->is_active ?? true,
                ]
            );
        }
        
        // Pour les nouveaux utilisateurs, un profil sera créé automatiquement via l'observateur
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class MasterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Master',
            'email' => 'master@faqbs.fr',
            'password' => Hash::make('Master@2026!'),
            'is_master' => true,
            'is_voice_donor' => false,
            'is_president' => false,
        ]);
    }
}

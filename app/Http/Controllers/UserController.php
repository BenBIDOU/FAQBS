<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Affiche le formulaire pour créer un nouveau membre
     */
    public function create()
    {
        return view('FAQBS.ajouter-membre');
    }

    /**
     * Stocke un nouveau membre
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'telephone' => 'nullable|string|max:20',
            'ville_bs' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
            'is_master' => 'boolean',
            'is_voice_donor' => 'boolean',
            'is_president' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->telephone = $validatedData['telephone'] ?? null;
        $user->ville_bs = $validatedData['ville_bs'] ?? null;
        $user->password = Hash::make($validatedData['password']);
        $user->is_master = $validatedData['is_master'] ?? false;
        $user->is_voice_donor = $validatedData['is_voice_donor'] ?? false;
        $user->is_president = $validatedData['is_president'] ?? false;
        $user->is_active = $validatedData['is_active'] ?? true;
        $user->save();

        return redirect()->route('membres.manage')->with('success', 'Membre ajouté avec succès !');
    }

    /**
     * Affiche le formulaire d'édition d'un membre
     */
    public function edit(User $user)
    {
        return view('FAQBS.editer-membre', compact('user'));
    }

    /**
     * Met à jour un membre
     */
    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'telephone' => 'nullable|string|max:20',
            'ville_bs' => 'nullable|string|max:255',
            'is_master' => 'boolean',
            'is_voice_donor' => 'boolean',
            'is_president' => 'boolean',
            'is_active' => 'boolean',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->telephone = $validatedData['telephone'] ?? null;
        $user->ville_bs = $validatedData['ville_bs'] ?? null;
        $user->is_master = $validatedData['is_master'] ?? false;
        $user->is_voice_donor = $validatedData['is_voice_donor'] ?? false;
        $user->is_president = $validatedData['is_president'] ?? false;
        $user->is_active = $validatedData['is_active'] ?? true;

        if (!empty($validatedData['password'])) {
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        return redirect()->route('membres.manage')->with('success', 'Membre modifié avec succès !');
    }

    /**
     * Supprime un membre
     */
    public function destroy(User $user)
    {
        // Ne pas supprimer le compte master principal pour éviter les problèmes
        if ($user->is_master && User::where('is_master', true)->count() <= 1) {
            return redirect()->route('membres.manage')->with('error', 'Impossible de supprimer le dernier compte master !');
        }

        $user->delete();

        return redirect()->route('membres.manage')->with('success', 'Membre supprimé avec succès !');
    }

    /**
     * Suspend ou réactive l'accès d'un membre
     */
    public function toggleSuspend(User $user)
    {
        // Ne pas suspendre le compte master principal
        if ($user->is_master && User::where('is_master', true)->where('is_active', true)->count() <= 1) {
            return redirect()->route('membres.manage')->with('error', 'Impossible de suspendre le dernier compte master actif !');
        }

        $user->is_active = !$user->is_active;
        $user->save();

        $message = $user->is_active ? 'Accès réactivé avec succès !' : 'Accès suspendu avec succès !';

        return redirect()->route('membres.manage')->with('success', $message);
    }
}

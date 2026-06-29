<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DiscussionController extends Controller
{
    /**
     * Affiche le formulaire pour créer une nouvelle discussion
     */
    public function create()
    {
        return view('FAQBS/ajouter-discu');
    }

    /**
     * Stocke une nouvelle discussion dans la base de données
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'group' => 'required|string|in:Espace membre,Secrétariat,Président,Donneurs Temps,Donneurs Voix',
                'link' => 'nullable|url|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $discussion = new Discussion();
            $discussion->title = $validatedData['title'];
            $discussion->group = $validatedData['group'];
            $discussion->link = $validatedData['link'] ?? null;
            $discussion->content = $validatedData['content'];

            // Gestion de l'image
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('discussion_images', 'public');
                $discussion->image_path = $path;
            }

            $discussion->save();

            return redirect()->route('faq')->with('success', 'Discussion ajoutée avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout d\'une discussion: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Une erreur est survenue lors de l\'ajout de la discussion. Veuillez réessayer.');
        }
    }

    /**
     * Affiche toutes les discussions (optionnel)
     */
    public function index()
    {
        $discussions = Discussion::orderBy('created_at', 'desc')->get();
        return view('FAQBS.faq', compact('discussions'));
    }

    /**
     * Affiche une discussion spécifique (optionnel)
     */
    public function show(Discussion $discussion)
    {
        return view('FAQBS.show', compact('discussion'));
    }
}

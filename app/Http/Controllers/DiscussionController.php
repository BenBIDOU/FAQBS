<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DiscussionController extends Controller
{
    /**
     * Affiche le formulaire pour créer une nouvelle discussion
     */
    public function create(Request $request)
    {
        $subject = $request->input('subject', '');
        $title = $request->input('title', $subject); // Alias pour compatibilité
        $group = $request->input('group', '');
        $content = $request->input('content', '');
        $question_id = $request->input('question_id', null);
        return view('FAQBS/ajouter-discu', compact('subject', 'title', 'group', 'content', 'question_id'));
    }

    /**
     * Stocke une nouvelle discussion dans la base de données
     */
    public function store(Request $request)
    {
        // Debug: afficher les données reçues
        // dd($request->all());
        
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'group' => 'required|string|in:Secrétariat,Président,Trésorerie,Donneurs Temps,Donneurs Voix',
                'link' => 'nullable|url|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'question_id' => 'nullable|integer',
            ]);

            $discussion = new Discussion();
            $discussion->title = $validatedData['title'];
            $discussion->group = $validatedData['group'];
            $discussion->link = $validatedData['link'] ?? null;
            $discussion->content = $validatedData['content'];
            $discussion->user_id = Auth::id();

            // Debug: vérifier l'authentification
            if (!Auth::check()) {
                return redirect('/')->with('error', 'Non connecté dans store');
            }

            // Gestion de l'image
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('discussion_images', 'public');
                $discussion->image_path = $path;
            }

            $discussion->save();

            // Associer la discussion à la question si question_id est fourni
            if ($request->has('question_id') && $request->question_id) {
                $question = \App\Models\Question::find($request->question_id);
                if ($question) {
                    $question->discussion_id = $discussion->id;
                    $question->save();
                }
            }

            return redirect('/agora')->with('success', 'Discussion ajoutée avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'ajout d\'une discussion: ' . $e->getMessage());

            return back()->withInput()->with('error', 'Erreur: ' . $e->getMessage());
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

    /**
     * Affiche la page de gestion des discussions (master uniquement)
     */
    public function manage()
    {
        $discussions = Discussion::orderBy('created_at', 'desc')->get();
        return view('FAQBS.gerer-discussions', compact('discussions'));
    }

    /**
     * Affiche le formulaire d'édition d'une discussion
     */
    public function edit(Discussion $discussion)
    {
        return view('FAQBS.editer-discussion', compact('discussion'));
    }

    /**
     * Met à jour une discussion
     */
    public function update(Request $request, Discussion $discussion)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'group' => 'required|string|in:Secrétariat,Président,Donneurs Temps,Donneurs Voix',
            'link' => 'nullable|url|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $discussion->title = $validatedData['title'];
        $discussion->group = $validatedData['group'];
        $discussion->link = $validatedData['link'] ?? null;
        $discussion->content = $validatedData['content'];

        if ($request->hasFile('image')) {
            if ($discussion->image_path && Storage::disk('public')->exists($discussion->image_path)) {
                Storage::disk('public')->delete($discussion->image_path);
            }
            $path = $request->file('image')->store('discussion_images', 'public');
            $discussion->image_path = $path;
        }

        $discussion->save();

        return redirect()->route('discussions.manage')->with('success', 'Discussion modifiée avec succès !');
    }

    /**
     * Supprime une discussion
     */
    public function destroy(Discussion $discussion)
    {
        if ($discussion->image_path && Storage::disk('public')->exists($discussion->image_path)) {
            Storage::disk('public')->delete($discussion->image_path);
        }

        $discussion->delete();

        return redirect()->route('discussions.manage')->with('success', 'Discussion supprimée avec succès !');
    }
}

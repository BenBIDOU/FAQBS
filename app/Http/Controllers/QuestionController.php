<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($team = null)
    {
        $query = Question::orderBy('created_at', 'desc');
        
        if ($team) {
            $query->where('team', $team);
        }
        
        $pendingQuestions = Question::orderBy('created_at', 'desc');
        if ($team) {
            $pendingQuestions->where('team', $team);
        }
        $pendingQuestions = $pendingQuestions->where('resolved', false)->get();
        
        $resolvedQuestions = Question::orderBy('created_at', 'desc');
        if ($team) {
            $resolvedQuestions->where('team', $team);
        }
        $resolvedQuestions = $resolvedQuestions->where('resolved', true)->get();
        
        // Charger toutes les discussions pour vérifier les correspondances de titres
        $discussions = \App\Models\Discussion::orderBy('title')->get();
        
        return view('FAQBS.questions-en-attente', compact('team', 'pendingQuestions', 'resolvedQuestions', 'discussions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('FAQBS.poser-question');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'team' => 'required|string',
            'message' => 'required|string',
        ]);

        // Générer automatiquement le sujet à partir du message
        $subject = Str::limit($validated['message'], 50);
        $validated['subject'] = $subject;

        Question::create($validated);

        return redirect()->route('agora')->with('success', 'Votre question a été envoyée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::findOrFail($id);
        
        // Charger toutes les discussions pour vérifier les correspondances
        $discussions = \App\Models\Discussion::orderBy('created_at', 'desc')->get();
        
        return view('FAQBS.question-detail', compact('question', 'discussions'));
    }

    /**
     * Show the form for replying to a question or store the reply.
     */
    public function reply(Request $request, string $id)
    {
        $question = Question::findOrFail($id);
        
        if ($request->isMethod('post')) {
            // Enregistrer la réponse
            $request->validate([
                'response' => 'required|string',
                'discussion_title' => 'nullable|string|max:255',
            ]);
            
            $question->answer = $request->input('response');
            $question->answered_by = Auth::id();
            $question->answered_at = now();
            $question->resolved = true;
            $question->resolved_by = Auth::id();
            $question->resolved_at = now();
            
            // Conserver le titre de la discussion si fourni
            if ($request->has('discussion_title')) {
                $question->discussion_title = $request->input('discussion_title');
            }
            
            $question->save();
            
            // Créer automatiquement une discussion avec cette réponse
            $discussion = new \App\Models\Discussion();
            $discussion->title = $request->input('discussion_title') ?? $question->subject ?? $question->discussion_title ?? 'Réponse à la question #'.$question->id;
            $discussion->group = $question->team;
            $discussion->content = $request->input('response');
            $discussion->user_id = Auth::id();
            $discussion->save();
            
            // Lier la discussion à la question
            $question->discussion_id = $discussion->id;
            $question->save();
            
            return redirect('/agora')->with('success', 'Réponse enregistrée et discussion créée avec succès !');
        }
        
        // Afficher le formulaire de réponse
        return view('FAQBS.reply', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $question = Question::findOrFail($id);
        return view('FAQBS.editer-question', compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'team' => 'required|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $question = Question::findOrFail($id);
        $question->update($validated);

        return redirect()->route('gestion-questions')->with('success', 'Question modifiée avec succès !');
    }

    /**
     * Marquer une question comme résolue
     */
    public function markAsResolved(string $id, Request $request)
    {
        $question = Question::findOrFail($id);
        $question->resolved = true;
        $question->resolved_by = Auth::id();
        $question->resolved_at = now();
        $question->save();

        // Rediriger vers une destination spécifique si fournie
        $redirectTo = $request->input('redirect');
        if ($redirectTo) {
            return redirect($redirectTo)->with('success', 'Question marquée comme résolue avec succès !');
        }

        return redirect()->back()->with('success', 'Question marquée comme résolue avec succès !');
    }

    /**
     * Gestion complète des questions pour les masters
     */
    public function gestion()
    {
        $questions = Question::orderBy('created_at', 'desc')->get();
        return view('FAQBS.gestion-questions', compact('questions'));
    }

    /**
     * Supprimer une question
     */
    public function destroy(string $id)
    {
        $question = Question::findOrFail($id);
        
        // Vérifier que l'utilisateur est le propriétaire de la question ou un master
        if (strtolower(trim($question->email ?? '')) !== strtolower(trim(Auth::user()->email)) && !Auth::user()->is_master) {
            if (request()->wantsJson()) {
                return response()->json(['error' => 'Vous ne pouvez supprimer que vos propres questions !'], 403);
            }
            return redirect()->back()->with('error', 'Vous ne pouvez supprimer que vos propres questions !');
        }
        
        $question->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Question supprimée avec succès !']);
        }
        
        return redirect()->back()->with('success', 'Question supprimée avec succès !');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        
        return view('FAQBS.questions-en-attente', compact('team', 'pendingQuestions', 'resolvedQuestions'));
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
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        Question::create($validated);

        return redirect('/espace-membre')->with('success', 'Votre question a été envoyée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $question = Question::findOrFail($id);
        return view('FAQBS.question-detail', compact('question'));
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
            ]);
            
            $question->answer = $request->input('response');
            $question->answered_by = Auth::id();
            $question->answered_at = now();
            $question->resolved = true;
            $question->resolved_by = Auth::id();
            $question->resolved_at = now();
            $question->save();
            
            return redirect()->route('questions-en-attente')->with('success', 'Réponse enregistrée avec succès !');
        }
        
        // Afficher le formulaire de réponse
        return view('FAQBS.reply', compact('question'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Marquer une question comme résolue
     */
    public function markAsResolved(string $id)
    {
        $question = Question::findOrFail($id);
        $question->resolved = true;
        $question->resolved_by = Auth::id();
        $question->resolved_at = now();
        $question->save();

        return redirect()->back()->with('success', 'Question marquée comme résolue avec succès !');
    }
}

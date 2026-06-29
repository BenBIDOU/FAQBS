<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($team = null)
    {
        $query = Question::where('resolved', false)->orderBy('created_at', 'desc');
        
        if ($team) {
            $query->where('team', $team);
        }
        
        $questions = $query->get();
        return view('FAQBS.questions-en-attente', compact('questions', 'team'));
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
        //
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
}

<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::orderBy('order', 'asc')->orderBy('created_at', 'asc')->get();
        return view('FAQBS.a-faire', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);
        
        $task = Task::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'order' => $validated['order'] ?? 0,
            'completed' => false,
        ]);
        
        return redirect()->route('a-faire')->with('success', 'Tâche ajoutée avec succès !');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'completed' => 'sometimes|boolean',
            'order' => 'sometimes|integer',
        ]);
        
        $task->update($validated);
        
        return redirect()->route('a-faire')->with('success', 'Tâche mise à jour avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('a-faire')->with('success', 'Tâche supprimée avec succès !');
    }
    
    /**
     * Toggle task completion status
     */
    public function toggleComplete(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return back()->with('success', 'Statut de la tâche mis à jour !');
    }
}

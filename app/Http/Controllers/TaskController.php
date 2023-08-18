<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Task;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('tasks.index', [
            'tasks' => Task::with('user')->latest()->get(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->tasks()->create($validated);

        return redirect()->route('tasks.index')->with('success', 'Tâche créée avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): View
    {
        //
        $this->authorize('update', $task);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
{
    $this->authorize('update', $task);

    $validated = $request->validate([
        'message' => 'required|string|max:255',
        'completed' => 'nullable|boolean', // Nouvelle règle de validation
    ]);

    $task->update([
        'message' => $validated['message'],
        'completed' => $validated['completed'] ?? 0, // Réinitialisation si non coché
    ]);

    return redirect()->route('tasks.index')->with('success', 'Tâche modifiée avec succès !');
}

    public function destroy(task $task): RedirectResponse
    {
        //
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')->with('danger', 'Tâche supprimer avec succès !');
    }

    public function markAsCompleted(Task $task)
    {
        $task->update([
            'completed' => 1,
        ]);

        return redirect()->route('tasks.index')->with('warning', 'Statut de la tâche mis à jour avec succès !');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = auth()->user();

        return view('tasks.index', [
            'tasks' => Task::where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('users', function ($subQuery) use ($user) {
                        $subQuery->where('users.id', $user->id);
                    });
            })
            ->with(['user', 'users'])
            ->latest()
            ->get(),
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
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $task = $request->user()->tasks()->create([
            'message' => $validated['message'],
            'user_id' => $request->user()->id,
        ]);

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
    $this->authorize('update', $task);

    // Récupérer la liste des utilisateurs disponibles
    $users = User::all(); // Assurez-vous d'importer le modèle User en haut du fichier

    return view('tasks.edit', [
        'task' => $task,
        'users' => $users, // Passer la liste des utilisateurs à la vue
    ]);
}


    /**
     * Update the specified resource in storage.
     */

// ...

// ...

public function update(Request $request, Task $task): RedirectResponse
{
    $this->authorize('update', $task);

    $validated = $request->validate([
        'message' => 'required|string|max:255',
        'completed' => 'nullable|boolean',
        'user_id' => 'nullable|exists:users,id',
    ]);

    // Mettre à jour les attributs de la tâche
    $task->update([
        'message' => $validated['message'],
        'completed' => $validated['completed'] ?? 0,

    ]);

    // Assigner la tâche à un nouvel utilisateur (si un utilisateur est sélectionné)
    if ($validated['user_id']) {
        $user = User::findOrFail($validated['user_id']);
        $task->users()->syncWithoutDetaching([$user->id]); // Utiliser la relation users()
    }

    return redirect()->route('tasks.index')->with('success', 'Tâche modifiée avec succès !');
}

// ...


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

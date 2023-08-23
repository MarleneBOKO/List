<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Task;
use App\Models\Project;
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
        'tasks' => $user->tasks() // Utiliser la relation tasks() définie dans le modèle User
            ->with(['user', 'users'])
            ->latest()
            ->get(),
    ]);
}



    public function separatedTasks(): View
{
    $user = auth()->user();

    $userCreatedTasks = $user->tasks()->latest()->get();
    $userAssignedTasks = Task::whereHas('users', function ($query) use ($user) {
        $query->where('users.id', $user->id);
    })->latest()->get();

    return view('tasks.separated', [
        'userCreatedTasks' => $userCreatedTasks,
        'userAssignedTasks' => $userAssignedTasks,
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
    public function store(Request $request, Project $project): RedirectResponse
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $user = $request->user(); // Utilisateur actuel qui crée la tâche

        $task = $project->tasks()->create([
            'message' => $validatedData['message'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('projects.show', ['project' => $project])->with('success', 'Tâche créée avec succès !');
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

     public function edit(Task $task, Project $project): View
     {
         $this->authorize('update', $task);

         // Récupérer la liste des utilisateurs disponibles
         $users = User::all();
         $users = $project->users;

         // Récupérer la liste des utilisateurs assignés au projet

         return view('projects.edit_task', [
             'task' => $task,
             'users' => $users,
             'project' => $project, // Passer le projet à la vue
         ]);
     }

     public function update(Task $task, Project $project, Request $request): RedirectResponse
          {
         $this->authorize('update', $task);

         $validated = $request->validate([
            'message' => 'required|string|max:255',
            'completed' => 'nullable|boolean',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $task->update([
            'message' => $validated['message'],
            'completed' => $validated['completed'] ?? 0,
        ]);

        // Si un nouvel utilisateur est sélectionné, mettre à jour l'assignation de la tâche
        if (array_key_exists('user_id', $validated)) {
            $user = User::findOrFail($validated['user_id']);
            $task->users()->attach([$user->id]); // Utiliser attach() au lieu de attch()
        } else {
            $task->users()->detach(); // Détacher tous les utilisateurs
        }

        return redirect()->route('projects.show', ['project' => $project])->with('success', 'Tâche modifiée avec succès !');
    }

     public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);

        $project = $task->project; // Récupérer le projet associé à la tâche

        $task->delete();

        return redirect()->route('projects.show', ['project' => $project])->with('danger', 'Tâche supprimée avec succès !');
    }

    public function markAsCompleted(Task $task)
    {
        $task->update([
            'completed' => 1,
        ]);

        return redirect()->back()->with('warning', 'Tâche marquée comme terminée avec succès !');
    }
}

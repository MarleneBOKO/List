<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Models\Task;
use App\Models\User;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $user = auth()->user();

        $userCreatedProjects = $user->projects()->latest()->get();
        $userAssignedProjects = Project::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->latest()->get();

        return view('projects.index', [
            'projects' => $user->projects() // Utiliser la relation projects() définie dans le modèle User
                ->with(['user', 'users'])
                ->latest()
                ->get(),
                'userCreatedProjects' => $userCreatedProjects,
                'userAssignedProjects' => $userAssignedProjects,
        ]);
    }
    public function separatedProjects(): View
    {
        $user = auth()->user();

        $userCreatedProjects = $user->projects()->latest()->get();
        $userAssignedProjects = Project::whereHas('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })->latest()->get();

        return view('projects.index', [
            'userCreatedProjects' => $userCreatedProjects,
            'userAssignedProjects' => $userAssignedProjects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function assignedTasks(Project $project)
{
    $assignedTasks = $project->tasks()->whereHas('users', function ($query) {
        $query->where('users.id', auth()->user()->id);
    })->get();
    $tasks = $project->tasks;

    return view('projects.assigned', [
        'project' => $project,
        'assignedTasks' => $assignedTasks,
        'tasks' => $tasks,
    ]);


}
/*public function assignedTasks(Project $project)
{
    $assignedTasks = $project->tasks()->whereHas('users', function ($query) {
        $query->where('users.id', auth()->user()->id);
    })->get();

    $tasks = $project->tasks->whereNotIn('id', $assignedTasks->pluck('id'));

    return view('projects.assigned', [
        'project' => $project,
        'assignedTasks' => $assignedTasks,
        'tasks' => $tasks,
    ]);
}*/


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

        $project = $request->user()->projects()->create([
            'message' => $validated['message'],
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project créée avec succès !');
    }
    /**
     * Display the specified resource.
     */
    public function show(Project $project)
{
    // Charger les relations liées au projet (dans cet exemple, les tâches)
    $project->load('tasks');

    // Passer les données du projet à la vue
    return view('projects.show', compact('project'));
}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task , Project $project): View
    {
        $this->authorize('update', $project);

        // Récupérer la liste des utilisateurs disponibles
        $users = User::all(); // Assurez-vous d'importer le modèle User en haut du fichier

        return view('projects.edit', [
            'project' => $project,
            'users' => $users, // Passer la liste des utilisateurs à la vue
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Task $task , Request $request, Project  $project): RedirectResponse
    {
        $this->authorize('update',  $project);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
            'completed' => 'nullable|boolean',
            'user_id' => 'nullable|exists:users,id',
        ]);

        // Mettre à jour les attributs de la tâche
        $project->update([
            'message' => $validated['message'],
            'completed' => $validated['completed'] ?? 0,

        ]);

        // Assigner la tâche à un nouvel utilisateur (si un utilisateur est sélectionné)
        if ($validated['user_id']) {
            $user = User::findOrFail($validated['user_id']);
            $project->users()->syncWithoutDetaching([$user->id]); // Utiliser la relation users()
        }

        return redirect()->route('projects.index' , $task->project)->with('success', 'Tâche modifiée avec succès !');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project): RedirectResponse
    {
        //
        $this->authorize('delete', $project);

        $project->delete();

        return redirect()->route('projects.index')->with('danger', 'Projet supprimer avec succès !');
    }
    public function markAsCompleted(Task $task)
    {
        $task->update([
            'completed' => 1,
        ]);

        return redirect()->back()->with('warning', 'Tâche marquée comme terminée avec succès !');
    }
}

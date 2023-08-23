<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Project;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        // Définissez ici la logique d'autorisation pour afficher la liste des projets
        return true; // Par exemple, autorise toujours l'accès pour cet exemple
    }

    public function view(User $user, Project $project)
    {
        // Définissez ici la logique d'autorisation pour afficher un projet spécifique
        return $user->id === $project->user_id; // Par exemple, autorise si l'utilisateur est le propriétaire du projet
    }

    public function create(User $user)
    {
        // Définissez ici la logique d'autorisation pour créer un nouveau projet
        return true; // Par exemple, autorise toujours la création pour cet exemple
    }

    public function update(User $user, Project $project)
    {
        // Définissez ici la logique d'autorisation pour mettre à jour un projet
        return $user->id === $project->user_id; // Par exemple, autorise si l'utilisateur est le propriétaire du projet
    }

    public function delete(User $user, Project $project)
    {
        // Définissez ici la logique d'autorisation pour supprimer un projet
        return $user->id === $project->user_id; // Par exemple, autorise si l'utilisateur est le propriétaire du projet
    }
    public function separatedProjects (User $user, Project $project)
    {
        // Définissez ici la logique d'autorisation pour supprimer un projet
        return $user->id === $project->user_id;

}
}

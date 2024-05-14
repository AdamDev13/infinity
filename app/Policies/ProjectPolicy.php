<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\ProjectBid;
use App\Models\ProjectQuestion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return ($user->hasPermissionTo("project.viewAny")) ? true : false;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Project $project)
    {
        return ($user->hasPermissionTo("project.view")) ? true : false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return ($user->hasPermissionTo("project.create")) ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Project $project)
    {
        return ($user->hasPermissionTo("project.update")) ? true : false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Project $project)
    {
        return ($user->hasRole(['superadmin', 'admin'])) ? true : false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Project $project)
    {
        return ($user->hasPermissionTo("project.restore")) ? true : false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Project $project)
    {
        return ($user->hasPermissionTo("project.forceDelete")) ? true : false;
    }

    public function addProjectBid(User $user,Project $project): bool
    {
        $count = ProjectBid::where('project_id',$project->id)->where('user_id',$user->id)->where('is_withdraw',false)->count();

        return $count > 0 ? false:true;
    }

    public function addProjectQuestion(User $user,Project $project): bool
    {
        $count = ProjectQuestion::where('project_id',$project->id)->where('user_id',$user->id)->count();
        return $count > 0 ? false:true;
    }
}

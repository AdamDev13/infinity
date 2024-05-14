<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\ProjectBid;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

class ProjectBidPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function before(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view a specific model.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ProjectBid $model)
    {
        if ($user->hasRole('vendor')) {
            return true;
        }

        $deadline = $model->project->deadline_date;
        if (Carbon::now()->gt($deadline)) {
            return true;
        }
        return false;
    }


    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return true;
    }


    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole("vendor") ? true : false;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Model  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Model $model)
    {
        $deadline = $model->project->deadline_date;
        if (Carbon::now()->gt($deadline) && $user->hasRole(['superadmin'])) {
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Model  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Model $model)
    {
        $deadline = $model->project->deadline_date;
        if (Carbon::now()->gt($deadline) && $user->hasRole(['superadmin'])) {
            return true;
        }
        return false;
    }

    public function download(User $user, Model $model)
    {
        if (!$model->project){
            if (request()->get('viaResource') =="projects"){
                $project = Project::find(request()->get('viaResourceId'));
            }else{
                return false;
            }

        }else{
            $project =$model->project;
        }
        $deadline = $project->deadline_date;
        if (Carbon::now()->gt($deadline) && $user->hasRole(['superadmin','admin'])) {
            return true;
        }
        return false;
    }


}
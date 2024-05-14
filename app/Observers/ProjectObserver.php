<?php

namespace App\Observers;

use App\Events\EventProjectUpdated;
use App\Models\Project;
use App\Models\ProjectLog;
use Illuminate\Support\Facades\Auth;

class ProjectObserver
{

    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        ProjectLog::create([
            "project_id" => $project->id,
            "user_id" => Auth()->id(),
            "type" => "created",
            "event" => "Project was created.",
        ]);
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
//        EventProjectUpdated::dispatch($project->id);
        ProjectLog::create([
            "project_id" => $project->id,
            "user_id" => Auth()->id(),
            "type" => "updated",
            "event" => "Project was updated.",
        ]);
        ProjectLog::create([
            "project_id" => $project->id,
            "user_id" => Auth()->id(),
            "type" => "updated",
            "event" => "Vendors are scheduled to recieve a project updated notification via email.",
        ]);
    }
    
    /**
     * Handle the Project "deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        ProjectLog::create([
            "project_id" => $project->id,
            "user_id" => Auth()->id(),
            "type" => "deleted",
            "event" => "Project was deleted.",
        ]);
    }

    /**
     * Handle the Project "restored" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        ProjectLog::create([
            "project_id" => $project->id,
            "user_id" => Auth()->id(),
            "type" => "restored",
            "event" => "Project was restored.",
        ]);
    }

    /**
     * Handle the Project "force deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }
}

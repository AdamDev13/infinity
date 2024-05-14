<?php

namespace App\Listeners;

use App\Models\ProjectFavorite;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserFavoriteProjectListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $projectId = $event->project->id;
        $userId = $event->userId;

        $projectFavorite = ProjectFavorite::where('project_id', $projectId)->where('user_id', $userId)->first();
        if ($projectFavorite) {
            if ($projectFavorite->status === 'active') {
                $projectFavorite->delete();
            } else {
                $projectFavorite->status = 'active';
                $projectFavorite->save();
            }
        } else {
            ProjectFavorite::updateOrCreate([
                'user_id' => $userId,
                'project_id' => $projectId,
                'status' =>  "active",
            ]);
        }
    }
}

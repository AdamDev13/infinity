<?php

namespace App\Listeners;

use App\Events\EventProjectUpdated;
use App\Models\Project;
use App\Notifications\NotificationProjectUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class SendProjectUpdatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  EventProjectUpdated  $event
     * @return void
     */
    public function handle(EventProjectUpdated $event)
    {
        // Get Product that was Updated
        $project = Project::where("id", $event->project_id)->with('fans.user')->first();
        $users = [];
        if($project->fans) {
            foreach($project->fans as $fan) {
                $users[] = $fan->user;
            }
            Notification::send($users, new NotificationProjectUpdated($project));
        }
    }
}

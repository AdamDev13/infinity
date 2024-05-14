<?php

namespace App\Observers;

use App\Models\ProjectLog;
use App\Models\UpdateProjectEmail;
use App\Mail\UpdateProjectEmailsSender;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UpdateProjectEmailsObserver
{
    public function creating(UpdateProjectEmail $updateProjectEmail) {
        $updateProjectEmail->project_id = $updateProjectEmail->project_id ?? request()->input('viaResourceId', 0);
	}

    /**
     * Handle the UpdateProjectEmail "created" event.
     *
     * @param  \App\Models\UpdateProjectEmail  $updateProjectEmail
     * @return void
     */
    public function created(UpdateProjectEmail $updateProjectEmail)
    {
        $emails = [];
        foreach($updateProjectEmail->project->viewers as $viewer) {
            if ($viewer->user->email) {
                $emails[] = $viewer->user->email;
            }
        }

        if ($updateProjectEmail->project->admin) {
            $emails[] = $updateProjectEmail->project->admin->email;
        }elseif($updateProjectEmail->project->user) {
            $emails[] = $updateProjectEmail->project->user->email;
        }

        $emails = array_unique($emails);

        Log::stack(['single'])->info('Sending update project email to '. implode(', ', $emails));

        ProjectLog::create([
            "project_id" => $updateProjectEmail->project->id,
            "user_id" => Auth()->id(),
            "type" => "updated",
            "event" => "project updated email sent.",
        ]);

//        $sender = new UpdateProjectEmailsSender($updateProjectEmail);
        foreach ($emails as $key => $email){
           Mail::to($email)->send(new UpdateProjectEmailsSender($updateProjectEmail));
        }
    }
}

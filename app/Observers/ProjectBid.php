<?php

namespace App\Observers;

use App\Mail\BidSubmited;
use App\Mail\BidWithdraw;
use App\Mail\LateBidSubmitted;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class ProjectBid
{
    public function saving(\App\Models\ProjectBid $projectBid)
    {
        $project =Project::find($projectBid->project_id);
        $dealLine =$project->deadline_datetime;
        if (Carbon::now()->gt($dealLine)){
            $projectBid->status = "L";
        }
    }

    public function created(\App\Models\ProjectBid $projectBid){

        if ($projectBid->status == "L"){
            Mail::send(new LateBidSubmitted($projectBid));
        }else{
            Mail::send(new BidSubmited($projectBid));
        }
    }

    public function updated(\App\Models\ProjectBid $projectBid){
        if ($projectBid->isDirty('is_withdraw')){
            if ($projectBid->is_withdraw){
                Mail::send(new BidWithdraw($projectBid));
            }
        }
    }
}

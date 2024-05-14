<?php

namespace App\Observers;

use App\Mail\BidSubmited;
use App\Mail\LateBidSubmitted;
use App\Mail\ProjectQuestionAnswerSubmitted;
use App\Mail\ProjectQuestionSubmitted;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProjectQuestionObserver
{

    public function created(\App\Models\ProjectQuestion $projectQuestion){
        Mail::send(new ProjectQuestionSubmitted($projectQuestion));
    }

    public function updating(\App\Models\ProjectQuestion $projectQuestion){
        if($projectQuestion->isDirty("answer")){
            $projectQuestion->is_answer = true;
            $projectQuestion->answered_by = Auth::user()->id;
        }
    }

    public function updated(\App\Models\ProjectQuestion $projectQuestion){
        if($projectQuestion->isDirty("answer")){
            Mail::send(new ProjectQuestionAnswerSubmitted($projectQuestion));
        }
    }
}

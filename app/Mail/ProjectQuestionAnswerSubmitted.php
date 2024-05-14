<?php

namespace App\Mail;

use App\Models\ProjectQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectQuestionAnswerSubmitted extends Mailable
{
    use Queueable, SerializesModels;
    public $projectQuestion,$emails,$project,$user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ProjectQuestion $projectQuestion)
    {
        $this->projectQuestion = $projectQuestion;
        $this->project = $projectQuestion->project;
        $this->user = $this->projectQuestion->userBelongs;
        $this->emails = [];

        $category = $this->project->category;
        if($this->user->email){
            array_push($this->emails,$this->user->email);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Your Question on Project ".$this->project->name." has been Answered")
            ->to($this->emails)
            ->view('emails.ProjectQuestionAnswered');
    }
}

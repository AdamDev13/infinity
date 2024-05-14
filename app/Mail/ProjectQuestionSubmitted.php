<?php

namespace App\Mail;

use App\Models\ProjectQuestion;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectQuestionSubmitted extends Mailable
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
        $this->user = $this->project->userBelongs;
        $this->emails = [];

        $category = $this->project->category;

        if ($this->project->admin){
            array_push($this->emails,$this->project->admin->email);
        } elseif($this->user->email){
            array_push($this->emails,$this->user->email);
        }

        if ($category->id == 1){
            $email = "p1bids@infinitycomm.com";
            array_push($this->emails,$email);
        }elseif ($category->id == 2){
            $email = "p2bids@infinitycomm.com";
            array_push($this->emails,$email);
        }elseif ($category->id == 3){
            $email = "p3bids@infinitycomm.com";
            array_push($this->emails,$email);
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("New Question has been Submitted on ".$this->project->name." by ".$this->projectQuestion->userBelongs->name)
            ->to($this->emails)
            ->view('emails.ProjectQuestionAsked');
    }
}

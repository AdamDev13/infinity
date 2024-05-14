<?php

namespace App\Mail;

use App\Models\ProjectBid;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidSubmited extends Mailable
{
    use Queueable, SerializesModels;
    public $projectBid;
    public $project;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(ProjectBid $projectBid)
    {
        $this->projectBid = $projectBid;
        $this->user =  $this->projectBid->userBelongs;
        $this->project =  $this->projectBid->project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $project =  $this->project;
        $user =  $this->user;
        return $this->to($user->email,$user->name)
            ->subject("Your Bid has been Submitted on Project".$project->name)
            ->markdown('emails.bidSubmitted')
            ->from(env('MAIL_FROM_ADDRESS', 'no-reply@infinitycomm.com'));
    }
}

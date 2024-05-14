<?php

namespace App\Mail;

use App\Models\UpdateProjectEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UpdateProjectEmailsSender extends Mailable
{
    use Queueable, SerializesModels;

    protected $updateProjectEmail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UpdateProjectEmail $updateProjectEmail)
    {
        $this->updateProjectEmail = $updateProjectEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->updateProjectEmail->email_title)
            ->from(env('MAIL_FROM_ADDRESS', 'no-reply@infinitycomm.com'))
            ->markdown('emails.common')
            ->with([
                'content' => $this->updateProjectEmail->email_content,
            ]);
    }
}

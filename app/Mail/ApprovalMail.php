<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

// Helper
use Helper;

class ApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    // Data
    protected $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.approval')->with([
            'name' => $this->data['name'],
            'from' => $this->data['from'],
            'attachmentLink' => $this->data['attachmentLink'],
            'type' => $this->data['type'],
        ])->attachFromStorage($this->data['attachmentLink'], Helper::getOriginalFileName($this->data['attachmentLink']), [
            'mime' => 'application/pdf'
        ]);
    }
}

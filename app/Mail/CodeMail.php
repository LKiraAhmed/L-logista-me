<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class CodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;
    public $user;
    public function __construct($code ,User $user)
    {
        //
        $this->code=$code;
        $this->user=$user;
    }

  
    public function content(): Content
    {
        return new Content(
            view: 'emailRegstier',
            with:[
                "code"=>$this->code,
                "user"=>$this->user
        ],
        );
    }


    public function attachments(): array
    {
        return [];
    }
}

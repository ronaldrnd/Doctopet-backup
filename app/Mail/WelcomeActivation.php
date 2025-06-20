<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeActivation extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $clientName;

    public function __construct($token, $clientName)
    {
        $this->token = $token;
        $this->clientName = $clientName;
    }

    public function build()
    {
        return $this->subject("Bienvenue sur DoctoPet 🎉")
            ->view('emails.welcome-activation');
    }
}

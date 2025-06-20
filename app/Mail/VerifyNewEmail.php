<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerifyNewEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function build()
    {
        $verificationUrl = route('email.verify', ['token' => $this->token]);

        return $this->subject('📧 Vérifiez votre nouvelle adresse email')
            ->view('emails.verify_new_email', ['verificationUrl' => $verificationUrl]);
    }
}

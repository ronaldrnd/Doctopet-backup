<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BreederContactMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $breeder;
    public $messageContent;

    public function __construct(User $user, User $breeder, $messageContent)
    {
        $this->user = $user;
        $this->breeder = $breeder;
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->from('contact@doctopet.com', 'Doctopet')
            ->subject('📩 Nouvelle demande d’adoption')
            ->view('emails.breeder-contact');
    }
}

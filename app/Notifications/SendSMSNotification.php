<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Media101\Bird\Models\Messages\SMSMessage;
use Media101\Bird\Models\Contact;
use Media101\Bird\Notifications\Channels\SMSChannel;

class SendSMSNotification extends Notification
{
    use Queueable;
    protected $message;
    protected $phoneNumber;
    protected $userName; // Ajoute cette variable

    public function __construct($message, $phoneNumber, $userName)
    {
        $this->message = $message;
        $this->phoneNumber = $phoneNumber;
        $this->userName = $userName;
    }

    public function via($notifiable)
    {
        return [SMSChannel::class];
    }

    public function toSMS($notifiable)
    {
        $contact = (new Contact())
            ->displayName($this->userName) // Utilise la propriété de la classe
            ->phoneNumber($this->phoneNumber);

        return (new SMSMessage())
            ->text($this->message)
            ->toContact($contact);
    }
}

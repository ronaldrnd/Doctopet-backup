<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AppointmentCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $appointment;
    public $reason;

    public function __construct($appointment, $reason)
    {
        $this->appointment = $appointment;
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('❌ Annulation de votre rendez-vous')
            ->view('emails.appointment_cancelled');
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClinicInvitation extends Mailable
{
    public $clinic;
    public $request;
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct($clinic, $request)
    {
        $this->clinic = $clinic;
        $this->request = $request;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Clinic Invitation',
        );
    }

    public function build()
    {
        return $this->subject("Invitation à rejoindre la clinique {$this->clinic->name}")
            ->view('emails.clinic_invitation')
            ->with([
                'clinicName' => $this->clinic->name,
                'link' => url('/accept/clinique/' . $this->request->token)
            ]);
    }
}

<?php

// app/Mail/MedicalHistoryUpdated.php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Animal;

class MedicalHistoryUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $animal;
    public $modification;

    public function __construct(Animal $animal, $modification)
    {
        $this->animal = $animal;
        $this->modification = $modification;
    }

    public function build()
    {
        return $this->subject('🩺 Mise à jour de l\'historique médical de votre animal')
            ->view('emails.medical-history-updated');
    }
}

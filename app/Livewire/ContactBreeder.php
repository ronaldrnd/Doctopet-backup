<?php

namespace App\Livewire;

use App\Mail\BreederContactMail;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ContactBreeder extends Component
{
    public $breederId;
    public $breeder;
    public $message;
    public $sendMessageInternally = true;

    public function mount($breederId)
    {
        $this->breeder = User::findOrFail($breederId);
        $this->generateMessage();
    }

    public function generateMessage()
    {
        $user = Auth::user();
        $time = now()->hour < 17 ? 'journée' : 'soirée';


        $this->message = "Bonjour, je suis " . ($user->gender === 'M' ? 'Monsieur' : 'Madame') . " {$user->name},
J’aimerais adopter un " . session('espece_nom') . " " . session('race_nom') . " et j’ai vu qu’il vous en restait dans votre élevage.
Êtes-vous disponible prochainement pour s’appeler et convenir un rendez-vous ?

En vous remerciant et en vous souhaitant une bonne $time,

Bien à vous,
{$user->name}
📧 {$user->email}
📞 {$user->phone_number}";
    }

    public function send()
    {
        $user = Auth::user();

        if ($this->sendMessageInternally) {
            Message::create([
                'sender_id' => $user->id,
                'receiver_id' => $this->breeder->id,
                'content' => $this->message,
                'is_read' => false,
            ]);
        }

        // Envoi du mail formaté
        Mail::to($this->breeder->email)->send(new BreederContactMail($user, $this->breeder, $this->message));

        session()->flash('success', 'Votre message a été envoyé avec succès !');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.contact-breeder');
    }
}

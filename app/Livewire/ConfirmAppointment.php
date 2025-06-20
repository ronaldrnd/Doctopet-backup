<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Animal;
use App\Models\Service;
use App\Models\SpecializedService;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class ConfirmAppointment extends Component
{
    public $selectedSlotStart;
    public $selectedSlotEnd;
    public $date;
    public $animalId;
    public $serviceId;
    public $user;
    public $service;
    public $animal;
    public $specializedService;
    public $isSpecialized;
    public function mount($animalId, $serviceId, $selectedSlotStart, $selectedSlotEnd, $date)
    {

        // Stocker les valeurs
        $this->animalId = $animalId;
        $this->serviceId = $serviceId;
        $this->selectedSlotStart = $selectedSlotStart;
        $this->selectedSlotEnd = $selectedSlotEnd;
        $this->date = $date;

        // Charger les informations requises
        $this->service = Service::with('user')->findOrFail($this->serviceId);
        $this->animal = Animal::findOrFail($this->animalId);
        $this->user = auth()->user();



        // Récupérer la sélection depuis la session
        $selection = session("appointment_selection_{$this->serviceId}", [
            'is_specialised' => false,
            'speciality_id' => null,
        ]);



        // Gérer correctement la formule de base (pas de prestation spécialisée)


        if (!isset($selection['is_specialised']) || $selection['is_specialised'] === false) {
            $this->isSpecialized = false;
            $this->specializedService = null;
        } else {
            // Si prestation spécialisée, on la charge
            $this->isSpecialized = true;
            $this->specializedService = SpecializedService::find($selection['speciality_id']);

            // Vérification pour éviter les erreurs
            if (!$this->specializedService) {
                session()->flash('error', 'La prestation spécialisée sélectionnée n\'existe pas.');
                return redirect()->route('appointments.overview');
            }
        }
    }

    public function confirm()
    {

        $specializedServiceId = $this->isSpecialized ? $this->specializedService->id : null;


        $pro = $this->service->user;

        // Vérifier si le pro accepte automatiquement les rendez-vous
        $status = $pro->acceptsAutoRDV() ? 'confirmed' : 'pending';

        // Création du rendez-vous
        $appointment = Appointment::create([
            'service_id' => $this->serviceId,
            'user_id' => auth()->id(),
            'animal_id' => $this->animalId,
            'date' => $this->date,
            'start_time' => $this->selectedSlotStart,
            'end_time' => $this->selectedSlotEnd,
            'status' => $status,
            'assign_specialist_id' => $this->service->user->id,
            'specialized_service_id' => $specializedServiceId,
        ]);

        // Envoi d'un email de confirmation au vétérinaire/spécialiste
        Mail::to($this->service->user->email)->send(new \App\Mail\AppointmentRequest($appointment));


        // Envoi de l'email de confirmation à l'utilisateur
        Mail::to(auth()->user()->email)->send(new \App\Mail\AppointmentConfirmation($appointment));
        // Message de confirmation et redirection
        session()->flash('success', 'Votre rendez-vous a été confirmé avec succès !');
        return redirect()->route('appointments.overview');
    }

    public function render()
    {
        return view('livewire.confirm-appointment', [
            'isSpecialized' => $this->isSpecialized,
            'specializedService' => $this->specializedService,
        ]);
    }
}

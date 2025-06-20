<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;

class ServiceAppointmentSingle extends Component
{
    public $service;
    public $selectedAnimal = null;
    public $userAnimals = [];
    public $provider; // Stocke les informations du professionnel

    public function mount($service)
    {
        $this->service = Service::with('user')->findOrFail($service);
        $this->provider = $this->service->user; // Récupération du professionnel lié au service

        if (Auth::check()) {
            $this->userAnimals = Auth::user()->animaux;
        }
    }

    public function render()
    {
        return view('livewire.service-appointment-single');
    }
}

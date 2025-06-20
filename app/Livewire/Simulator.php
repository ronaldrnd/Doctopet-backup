<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Specialite;

class Simulator extends Component
{
    public $specialties;
    public $selectedSpecialty;
    public $acceptNewClients = true;
    public $newClients = 10;
    public $avgConsultationPrice = 50;
    public $missedAppointments = 5;
    public $weeklyConsultations = 20;
    public $adminTime = 10;
    public $consultationTime = 30;

    public $estimatedRevenue = 300;

    public $savedTime = 10;
    public $extraPatients = 10;
    public $recoveredRevenue = 0;



    public function mount()
    {
        $this->specialties = Specialite::pluck('nom')->toArray();
        $this->selectedSpecialty = $this->specialties[0] ?? null;
    }

    public function toggleAcceptNewClients($value)
    {
        $this->acceptNewClients = $value;
    }

    public function updated()
    {
        $this->calculateResults();
    }


    public function updatedMissedAppointments()
    {
        $this->calculateResults();
    }


    public function calculateResults()
    {
        // Assurer que toutes les valeurs sont bien des nombres
        $this->newClients = (int) $this->newClients;
        $this->avgConsultationPrice = (float) $this->avgConsultationPrice;
        $this->missedAppointments = (int) $this->missedAppointments;
        $this->weeklyConsultations = (int) $this->weeklyConsultations;
        $this->adminTime = (int) $this->adminTime;
        $this->consultationTime = (int) $this->consultationTime;

        // Réduction du temps administratif et calcul des patients supplémentaires
        $reducedAdminTime = $this->adminTime * 0.3;
        $extraPatients = floor($reducedAdminTime / ($this->consultationTime / 60));

        // 💰 Calcul des rendez-vous manqués récupérables (20% des missedAppointments)

        $recoveredAppointments = floor($this->missedAppointments * 0.53);
        $this->recoveredRevenue = $recoveredAppointments * $this->avgConsultationPrice;


        //dd($this->recoveredRevenue,$this->extraPatients);

        // ⏳ Mise à jour du temps économisé et des patients supplémentaires
        $this->savedTime = $reducedAdminTime;
        $this->extraPatients = $extraPatients;

    }


    public function render()
    {
        $this->calculateResults();
        return view('livewire.simulator');
    }
}

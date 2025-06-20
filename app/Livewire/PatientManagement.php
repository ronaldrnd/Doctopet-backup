<?php

namespace App\Livewire;

use App\Models\AnimalVaccine;
use App\Models\User;
use App\Models\UserWarning;
use App\Models\UserReport;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\ExternalAppointment;
use App\Models\Animal;


class PatientManagement extends Component
{
    public $patients;
    public $filteredPatients;
    public $selectedPatient;
    public $searchTerm = '';
    public $newVaccineName = [];
    public $newVaccineDate = [];
    public $showReportForm = false;
    public $reportTitle;
    public $reportText;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public $editAnimalMedicalHistory = [];


    public $appointmentsPaginated;
    public $appointmentPage = 1;
    public $appointmentsPerPage = 5;



    public function mount()
    {
        $this->loadPatients();
    }

    public function updatedSearchTerm()
    {
        $this->filterPatients();
    }

    public function loadPatients()
    {
        // Patients internes
        $internalPatients = User::with(['animaux', 'appointments'])
            ->whereHas('appointments', fn($q) => $q->where('assign_specialist_id', Auth::id()))
            ->get();

        // Patients des rendez-vous externes
        $externalPatientIds = ExternalAppointment::where('user_id', Auth::id())
            ->pluck('client_id')
            ->filter()
            ->unique();


        //dd($externalPatientIds);

        $externalPatients = User::with('animaux')->whereIn('id', $externalPatientIds)->get();

        $this->patients = $internalPatients->merge($externalPatients)->unique('id');
        $this->filterPatients();
    }


    public function filterPatients()
    {
        $this->filteredPatients = $this->patients->filter(function($patient) {
            return stripos($patient->name, $this->searchTerm) !== false;
        });
    }


    public function getPaginatedAppointmentsProperty()
    {
        if (!$this->selectedPatient) return collect();

        $internals = $this->selectedPatient->specialistAppointments->map(function ($appt) {
            $appt->type = 'interne';
            return $appt;
        });

        $externals = $this->selectedPatient->externalAppointmentsForSpecialist->map(function ($appt) {
            $appt->type = 'externe';
            return $appt;
        });

        $allAppointments = $internals->merge($externals)->sortByDesc('date')->values();

        return $allAppointments->forPage($this->appointmentPage, $this->appointmentsPerPage);
    }



    public function nextPage()
    {
        if ($this->appointmentPage < $this->totalPages) {
            $this->appointmentPage++;
        }
    }


    public function previousPage()
    {
        if ($this->appointmentPage > 1) {
            $this->appointmentPage--;
        }
    }


    public function getTotalPagesProperty()
    {
        if (!$this->selectedPatient) return 1;

        $internals = $this->selectedPatient->specialistAppointments ?? collect();
        $externals = $this->selectedPatient->externalAppointmentsForSpecialist ?? collect();

        $total = $internals->count() + $externals->count();
        return max(1, ceil($total / $this->appointmentsPerPage));
    }


    public function selectPatient($patientId)
    {
        $this->appointmentPage = 1;
        $this->selectedPatient = User::with([
            'animaux',
            'appointments',
            'warnings',
            'specialistAppointments.animal',
            'specialistAppointments.service',
            'specialistAppointments.specializedService',
            'externalAppointmentsForSpecialist.service'
        ])->findOrFail($patientId);

        foreach ($this->selectedPatient->animaux as $animal) {
            $this->editAnimalMedicalHistory[$animal->id] = $animal->historique_medical;
        }
    }



    public function blockPatient($patientId)
    {
        UserWarning::updateOrCreate(
            ['specialist_id' => Auth::id(), 'user_target_id' => $patientId],
            ['is_blocked' => true, 'level' => 2]
        );

        session()->flash('message', 'Le patient a été bloqué.');
        $this->render();

    }

    public function unblockPatient($patientId)
    {
        UserWarning::where('specialist_id', Auth::id())
            ->where('user_target_id', $patientId)
            ->update(['is_blocked' => false, 'level' => 0]);

        session()->flash('message', 'Le patient a été débloqué.');
        $this->render();

    }

    public function addVaccine($animalId)
    {
        $this->validate([
            "newVaccineName.$animalId" => 'required|string|max:255',
            "newVaccineDate.$animalId" => 'required|date'
        ]);

        AnimalVaccine::create([
            'animal_id' => $animalId,
            'vaccine' => $this->newVaccineName[$animalId],
            'vaccination_date' => $this->newVaccineDate[$animalId],
            'added_by_specialist_id' => Auth::id(),  // Enregistrement du spécialiste
        ]);

        session()->flash('message', 'Vaccin ajouté avec succès.');
        unset($this->newVaccineName[$animalId], $this->newVaccineDate[$animalId]);
        $this->render();
    }


    public function updateMedicalHistory($animalId)
    {
        $animal = Animal::findOrFail($animalId);
        $animal->historique_medical = $this->editAnimalMedicalHistory[$animalId] ?? '';
        $animal->save();

        session()->flash('message', 'Historique médical mis à jour.');
        $this->render();
    }


    public function submitReport($userId)
    {
        $this->validate([
            'reportTitle' => 'required|string|max:255',
            'reportText' => 'required|string'
        ]);

        UserReport::create([
            'specialist_id' => Auth::id(),
            'user_id_target' => $userId,
            'libelle' => $this->reportTitle,
            'text' => $this->reportText,
            'date' => now()
        ]);

        session()->flash('message', 'Signalement envoyé aux administrateurs.');
        $this->reset(['reportTitle', 'reportText', 'showReportForm']);
        $this->render();
    }

    public function render()
    {
        return view('livewire.patient-management');
    }
}

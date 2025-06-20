<?php

namespace App\Livewire;

use App\Models\Animal;
use App\Models\Service;
use App\Models\ServiceTemplate;
use App\Models\ServiceType;
use App\Models\Specialite;
use App\Models\Appointment;
use App\Models\PetSitterRecurringAppointment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class PetSitterAppointment extends Component
{
    public $animalId;
    public $specialiteId;
    public $serviceTypeId;
    public $serviceTemplateId;
    public $recurring = false; // Mode récurrent
    public $selectedDays = []; // Stocke les jours cochés en mode récurrent
    public $startDate;
    public $endDate;
    public $startTime;
    public $endTime;
    public $latitude;
    public $longitude;
    public $selectedPetSitter;
    public $availablePetSitters = [];
    public $availableServices = [];
    public $availableSlots = [];
    public $distance;
    public $currentWeek;

    public function mount($animalId, $specialiteId, $serviceTypeId, $serviceTemplateId)
    {
        $this->animalId = $animalId;
        $this->specialiteId = $specialiteId;
        $this->serviceTypeId = $serviceTypeId;
        $this->serviceTemplateId = $serviceTemplateId;
        $this->distance = 0;
        $this->currentWeek = Carbon::now()->startOfWeek();
        // Récupérer les Pet-Sitters proposant ce type de service
        $this->fetchAvailablePetSitters();


    }




    public function previousWeek()
    {
        if ($this->currentWeek->greaterThan(Carbon::now()->startOfWeek())) {
            $this->currentWeek->subWeek();
            $this->fetchAvailableSlots();
        }
    }

    public function nextWeek()
    {
        $this->currentWeek->addWeek();
        $this->fetchAvailableSlots();
    }

    public function fetchAvailablePetSitters()
    {

        $sp = Specialite::where("nom", "=","Pet Sitter")->first();


        $this->availablePetSitters = \App\Models\User::whereExists(function ($query) use ($sp) {
            $query->select(DB::raw(1))
                ->from('specialites')
                ->join('specialite_user', 'specialites.id', '=', 'specialite_user.specialite_id')
                ->whereColumn('users.id', 'specialite_user.user_id')
                ->where('specialites.id', $sp->id); // Bien préciser "specialites.id"
        })->get();
    }

    public function selectPetSitter($petSitterId)
    {
        $this->selectedPetSitter = User::find($petSitterId);

        //$this->calculateDistance();
        $this->fetchAvailableServices();
    }

    public function fetchAvailableServices()
    {
        if (!$this->selectedPetSitter) return;

        // Récupérer **tous les services** liés au `serviceTypeId` pour le Pet-Sitter sélectionné
        $this->availableServices = Service::where('user_id', $this->selectedPetSitter->id)
            ->where('services_types_id', $this->serviceTypeId)
            ->get();

        $this->fetchAvailableSlots();
    }

    public function fetchAvailableSlots()
    {
        if (!$this->selectedPetSitter || $this->availableServices->isEmpty()) return;

        $appointments = Appointment::whereIn('service_id', $this->availableServices->pluck('id'))
            ->whereBetween('date', [
                Carbon::now()->startOfWeek()->toDateString(),
                Carbon::now()->endOfWeek()->toDateString(),
            ])->get();

        $slots = [];

        foreach ($this->availableServices as $service) {
            foreach ($service->schedules as $schedule) {

                $daysTranslation = [
                    'Lundi' => 'Monday',
                    'Mardi' => 'Tuesday',
                    'Mercredi' => 'Wednesday',
                    'Jeudi' => 'Thursday',
                    'Vendredi' => 'Friday',
                    'Samedi' => 'Saturday',
                    'Dimanche' => 'Sunday',
                ];

                $dayInEnglish = $daysTranslation[$schedule->day_of_week] ?? 'Monday'; // Valeur par défaut si jamais le jour est inconnu

                $day = Carbon::now()->next($dayInEnglish)->format('Y-m-d');
                $start = Carbon::parse($schedule->start_time);
                $end = Carbon::parse($schedule->end_time);

                while ($start->lt($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($service->duration)->format('H:i');

                    $isTaken = $appointments->contains(function ($appointment) use ($day, $slotStart, $slotEnd) {
                        return $appointment->date->format('Y-m-d') === $day &&
                            ($slotStart >= $appointment->start_time && $slotEnd <= $appointment->end_time);
                    });

                    if (!$isTaken || $this->isFlexibleService()) {
                        $slots[$day][] = [
                            'start_time' => $slotStart,
                            'end_time' => $slotEnd,
                            'service_id' => $service->id,
                            'service_name' => $service->name,
                            'service_price' => $service->price,
                        ];
                    }

                    $start->addMinutes(30);
                }
            }
        }

        $this->availableSlots = $slots;
    }



    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Rayon de la terre en km
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function isFlexibleService()
    {
        $flexibleServices = ["Hébergement chez le Pet-sitter", "Garderie pour chien chez le Pet-sitter", "Promenade de chien"];
        return in_array($this->serviceTemplateId, $flexibleServices);
    }

    public function saveAppointment($serviceId, $date, $startTime, $endTime)
    {
        $this->validate([
            'selectedPetSitter' => 'required',
        ]);

        if ($this->recurring) {
            $this->validate(['selectedDays' => 'required|array|min:1']);
            foreach ($this->selectedDays as $day) {
                PetSitterRecurringAppointment::create([
                    'animal_id' => $this->animalId,
                    'service_id' => $serviceId,
                    'user_id' => Auth::id(),
                    'jour' => $day,
                    'horaire_debut' => $startTime,
                    'horaire_fin' => $endTime,
                ]);
            }
        } else {
            Appointment::create([
                'animal_id' => $this->animalId,
                'service_id' => $serviceId,
                'user_id' => Auth::id(),
                'date' => $date,
                'start_time' => $startTime,
                'end_time' => $endTime,
            ]);
        }

        session()->flash('message', 'Votre réservation a bien été enregistrée.');
        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.pet-sitter-appointment', [
            'animal' => Animal::find($this->animalId),
            'specialite' => Specialite::find($this->specialiteId),
            'serviceType' => ServiceType::find($this->serviceTypeId),
            'serviceTemplate' => ServiceTemplate::find($this->serviceTemplateId),
            'availablePetSitters' => $this->availablePetSitters,
            'availableSlots' => $this->availableSlots,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Service;
use App\Models\SpecializedService;
use App\Models\Animal;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendAppointmentEmail;

class CreateRDV extends Component
{
    public $serviceId;
    public $specializedServiceId = null;
    public $date;
    public $time;
    public $animalId;
    public $message;
    public $weekOffset = 0; // Add this line for week management

    public $service;
    public $specializedServices = [];
    public $availableSlots = [];
    public $userAnimals = [];
    public $selectedSlot = [
        'date' => null,
        'start_time' => null
    ];

    public function mount($serviceId)
    {


        $this->service = Service::findOrFail($serviceId);
        $this->serviceId = $serviceId;
        $this->specializedServices = $this->service->specializedServices;
        $this->userAnimals = Animal::where('proprietaire_id', Auth::user()->id)->get();
        $this->updateAvailableSlots();

    }

    public function selectAnimal($animalId)
    {
        $this->animalId = $animalId;
        $this->updateAvailableSlots();
    }

    public function selectFormula($specializedServiceId)
    {
        $this->specializedServiceId = $specializedServiceId;
        $this->updateAvailableSlots();
    }

    public function selectSlot($date, $time)
    {
        Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.UTF-8');
        $this->selectedSlot = ['date' => $date, 'start_time' => $time];
        $this->date = $date;
        $this->time = $time;
    }

    private function updateAvailableSlots()
    {
        // Par défaut, utiliser les données de la prestation de base
        $criteria = $this->service;
        $duration = $this->service->duration;

        // Si une formule spécialisée est choisie
        if ($this->specializedServiceId) {
            $duration = 0;
            $specializedService = SpecializedService::find($this->specializedServiceId);
            if ($specializedService) {
                $criteria = $specializedService;
                $duration = $specializedService->duration;
            }
        }

        // Si un animal est sélectionné, appliquer des filtres
        if ($this->animalId && $this->specializedServiceId) {
            $animal = Animal::find($this->animalId);
            if ($animal) {
                // Vérifiez que l'animal correspond aux critères de la prestation spécialisée
                if (
                    intval($criteria->min_weight) && $animal->poids < intval($criteria->min_weight) ||
                    intval($criteria->max_weight) && $animal->poids > intval($criteria->max_weight) ||
                    intval($criteria->min_height) && $animal->taille < intval($criteria->min_height) ||
                    intval($criteria->max_height) && $animal->taille > intval($criteria->max_height)
                ) {
                    // Aucune disponibilité si l'animal ne correspond pas
                    $this->availableSlots = [];
                    return;
                }
            }
        }

        // Calculer les créneaux disponibles en fonction des critères
        $condition_recherche = ($this->animalId && $this->specializedServiceId) || ($this->animalId && count($this->specializedServices) == 0);
        if ($condition_recherche)
            $this->availableSlots = $this->calculateAvailableSlots($duration, $this->weekOffset);

    }


    public function nextWeek()
    {
        $this->weekOffset++;
        $this->updateAvailableSlots();
    }

    public function previousWeek()
    {
        $this->weekOffset--;
        $this->updateAvailableSlots();
    }


    private function calculateAvailableSlots($duration, $weekOffset = 0)
    {
        Carbon::setLocale('fr'); // Configure Carbon en français
        setlocale(LC_TIME, 'fr_FR.UTF-8'); // Configure PHP pour les formats de date en français

        $slots = [];
        $currentDate = now()->startOfDay()->addWeeks($weekOffset);
        $currentTime = now()->format('H:i:s'); // Heure actuelle pour validation
        $currentDate->setTimezone('Europe/Paris'); // Assure la bonne timezone

        // Obtenez les rendez-vous existants
        $existingAppointments = Appointment::where('service_id', $this->service->id)
            ->whereBetween('date', [$currentDate->copy()->startOfWeek(), $currentDate->copy()->endOfWeek()])
            ->get(['date', 'start_time', 'end_time']);

        for ($i = 0; $i < 7; $i++) {
            $day = $currentDate->copy()->addDays($i);
            $dayName = ucfirst($day->translatedFormat('l'));

            foreach ($this->service->schedules as $schedule) {
                if ($schedule->day_of_week === $dayName) {
                    $startTime = strtotime($schedule->start_time);
                    $endTime = strtotime($schedule->end_time);

                    while ($startTime + ($duration * 60) <= $endTime) {
                        $slotStartTime = date('H:i:s', $startTime);
                        $slotEndTime = date('H:i:s', $startTime + ($duration * 60));

                        // Vérifier si le créneau chevauche un rendez-vous existant
                        $isSlotTaken = $existingAppointments->contains(function ($appointment) use ($day, $slotStartTime, $slotEndTime) {
                            return $appointment->date === $day->format('Y-m-d') &&
                                ($slotStartTime < $appointment->end_time && $slotEndTime > $appointment->start_time);
                        });

                        // Vérifier si le créneau respecte les plages horaires et n'est pas avant l'heure actuelle
                        $respectsSchedule = strtotime($slotEndTime) <= strtotime($schedule->end_time);
                        $isAfterCurrentTime = $day->isToday() ? strtotime($slotStartTime) >= strtotime($currentTime) : true;

                        if (!$isSlotTaken && $respectsSchedule && $isAfterCurrentTime) {
                            $slots[] = [
                                'date' => $day->format('Y-m-d'),
                                'start_time' => $slotStartTime,
                                'end_time' => $slotEndTime,
                            ];
                        }

                        $startTime += ($duration * 60);
                    }
                }
            }
        }

        Log::info("Available slots calculated", ['slots' => $slots]);
        return $slots;
    }


    public function submit()
    {


        $this->time = date('H:i', strtotime($this->time));
        $this->validate([
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'animalId' => 'required|exists:animaux,id',
            'message' => 'nullable|string|max:500',
        ]);


        // Vérifiez si une prestation spécialisée est sélectionnée et appliquez la durée correcte
        $duration = $this->service->duration; // Par défaut, durée du service de base
        if ($this->specializedServiceId) {
            $specializedService = SpecializedService::find($this->specializedServiceId);
            if ($specializedService) {
                $duration = $specializedService->duration;
            }
        }

        // Calculer l'heure de fin basée sur la durée correcte
        $endTime = date('H:i:s', strtotime("+{$duration} minutes", strtotime($this->time)));






        $appointment = Appointment::create([
            'service_id' => $this->serviceId,
            'user_id' => auth()->id(),
            'animal_id' => $this->animalId,
            'specialized_service_id' => $this->specializedServiceId,
            'date' => $this->date,
            'start_time' => $this->time,
            'end_time' => $endTime,
            'message' => $this->message,
            'assign_specialist_id ' => $this->service->user->id,
            'status' => $status,
        ]);

        //dispatch(new SendAppointmentEmail($appointment));
        $this->sendConfirmationEmail($appointment);

        session()->flash('success', 'Votre demande de rendez-vous a été envoyée avec succès !');
        return redirect()->route('appointments.overview');
    }

    private function sendConfirmationEmail($appointment)
    {
        Mail::to($appointment->service->user->email)->send(new \App\Mail\AppointmentRequest($appointment));
    }

    public function render()
    {
        return view('livewire.create-r-d-v', [
            'service' => $this->service,
            'specializedServices' => $this->specializedServices,
            'availableSlots' => $this->availableSlots,
            'userAnimals' => $this->userAnimals,
        ]);
    }
}

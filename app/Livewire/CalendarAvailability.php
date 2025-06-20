<?php

namespace App\Livewire;

use App\Models\ExternalAppointment;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Appointment;
use App\Models\Service;
use Carbon\Carbon;

class CalendarAvailability extends Component
{
    public $service_id;
    public $currentWeek;
    public $availableSlots = [];
    public $selectedSlot;
    public $animalID;
    public $serviceDuration;
    public $currentDayIndex = 0;



    protected $listeners = ['updateAppointmentDuration' => 'updateDurationAndRefresh', 'refreshCalendar' => 'reloadCalendar'];

    public function mount($service_id,$animalID)
    {

        if($service_id == null || $animalID == null){
            dd("ça va pas là ", $service_id, $animalID);
        }
        $this->animalID = $animalID;
        $this->service_id = $service_id;
        $this->currentWeek = Carbon::now()->startOfWeek();
        // Récupérer la durée de base du service
        $service = Service::findOrFail($this->service_id);
        $this->serviceDuration = $service->duration;


        $this->fetchAvailableSlots($this->serviceDuration);

        // Si aucun créneau disponible, passez à la semaine suivante
        if (empty($this->availableSlots)) {
            $this->nextAvailableWeek();
        }
    }


    public function reloadCalendar()
    {
        $this->fetchAvailableSlots($this->serviceDuration);
        $this->render();
    }
    public function fetchAvailableSlots($duration)
    {
        Carbon::setLocale('fr');
        setlocale(LC_TIME, 'fr_FR.UTF-8');

        $service = Service::with('schedules')->findOrFail($this->service_id);

        // Récupération de l'ID du professionnel assigné au service
        $specialistId = $service->user_id;

        // Récupération des rendez-vous du vétérinaire
        $appointments = Appointment::where('assign_specialist_id', $specialistId)
            ->whereBetween('date', [
                $this->currentWeek->copy()->startOfWeek()->toDateString(),
                $this->currentWeek->copy()->endOfWeek()->toDateString()
            ])->get();


        // Récupérer les rendez vous externes
        $externalAppointments = ExternalAppointment::where('user_id', $specialistId)
            ->whereBetween('date', [
                $this->currentWeek->copy()->startOfWeek()->toDateString(),
                $this->currentWeek->copy()->endOfWeek()->toDateString()
            ])->get();


        \Illuminate\Support\Facades\Log::info("Ressources dans la mémoire");


        //dd($appointments);

        $slots = [];
        $now = Carbon::now();
        $maxWeeksToSearch = 5;
        $weekCount = 0;

        while (empty($slots) && $weekCount < $maxWeeksToSearch) {
            //\Illuminate\Support\Facades\Log::info("NEW ITERATION : " . $weekCount);
            $groupedSchedules = [];

            // 🔄 **1. Regrouper les créneaux horaires spécifiques au service**
            //\Illuminate\Support\Facades\Log::info("COUNT -> " . $service->schedules->count());
            foreach ($service->schedules as $schedule) {
                //\Illuminate\Support\Facades\Log::info("JE CHECK LE SCHEDULE : " . $schedule);
                $dayIndex = $this->getDayIndexFromFrenchName($schedule->day_of_week);
                $day = $this->currentWeek->copy()->startOfWeek()->addDays($dayIndex - 1);


                if ($day->isPast() && !$day->isToday()) continue;

                if (!isset($groupedSchedules[$day->toDateString()])) {
                    $groupedSchedules[$day->toDateString()] = [
                        'start' => null,
                        'end' => null
                    ];
                }

                $scheduleStart = Carbon::parse($schedule->start_time, 'Europe/Paris')->setDate($day->year, $day->month, $day->day);
                $scheduleEnd = Carbon::parse($schedule->end_time, 'Europe/Paris')->setDate($day->year, $day->month, $day->day);

                if ($groupedSchedules[$day->toDateString()]['start'] === null || $scheduleStart->lessThan($groupedSchedules[$day->toDateString()]['start'])) {
                    $groupedSchedules[$day->toDateString()]['start'] = $scheduleStart;
                }

                if ($groupedSchedules[$day->toDateString()]['end'] === null || $scheduleEnd->greaterThan($groupedSchedules[$day->toDateString()]['end'])) {
                    $groupedSchedules[$day->toDateString()]['end'] = $scheduleEnd;
                }
            }

            //\Illuminate\Support\Facades\Log::info("ETAPE PASSER 1 GO STEP 2");




            // 🔍 **2. Vérifier la disponibilité sur les créneaux réels du vétérinaire ET du service**
            foreach ($groupedSchedules as $day => $schedule) {
                //Log::info("VERIF DAY : " . $day . " SCHEDULE : " . $schedule['start'] . " - " . $schedule['end']);
                $day = Carbon::parse($day)->toDateString(); // 🔹 Assure que le format est correct
                $start = $schedule['start']->copy();
                $end = $schedule['end']->copy();
                $freeSlots = [];

                while ($start->lessThan($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($duration)->format('H:i');

                    // Vérification si le créneau dépasse la fin de la journée du service
                    if ($start->copy()->addMinutes($duration)->greaterThan($end)) {
                        //Log::alert("JE BREAK");
                        break;
                    }

                    $isTakenByVeterinarian = $appointments->contains(function ($appointment) use ($day, $slotStart, $slotEnd) {
                        $slotStartTime = Carbon::parse($appointment->date)->setTimeFromTimeString($slotStart);
                        $slotEndTime = Carbon::parse($appointment->date)->setTimeFromTimeString($slotEnd);

                        $appointmentStart = Carbon::parse($appointment->date)
                            ->setHour(Carbon::parse($appointment->start_time)->hour)
                            ->setMinute(Carbon::parse($appointment->start_time)->minute)
                            ->setSecond(0);

                        $appointmentEnd = Carbon::parse($appointment->date)
                            ->setHour(Carbon::parse($appointment->end_time)->hour)
                            ->setMinute(Carbon::parse($appointment->end_time)->minute)
                            ->setSecond(0);

                        return $appointmentStart->toDateString() === $day &&
                            (
                                ($slotStartTime->gte($appointmentStart) && $slotStartTime->lt($appointmentEnd)) ||
                                ($slotEndTime->gt($appointmentStart) && $slotEndTime->lte($appointmentEnd)) ||
                                ($slotStartTime->lte($appointmentStart) && $slotEndTime->gte($appointmentEnd)) ||
                                ($appointmentStart->lte($slotStartTime) && $appointmentEnd->gte($slotEndTime))
                            );
                    });

                    $isTakenByExternal = $externalAppointments->contains(function ($appointment) use ($day, $slotStart, $slotEnd) {
                        $slotStartTime = Carbon::parse($appointment->date)->setTimeFromTimeString($slotStart);
                        $slotEndTime = Carbon::parse($appointment->date)->setTimeFromTimeString($slotEnd);

                        $appointmentStart = Carbon::parse($appointment->date)
                            ->setTimeFromTimeString($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->date)
                            ->setTimeFromTimeString($appointment->end_time);

                        return $appointmentStart->toDateString() === $day &&
                            (
                                ($slotStartTime->gte($appointmentStart) && $slotStartTime->lt($appointmentEnd)) ||
                                ($slotEndTime->gt($appointmentStart) && $slotEndTime->lte($appointmentEnd)) ||
                                ($slotStartTime->lte($appointmentStart) && $slotEndTime->gte($appointmentEnd)) ||
                                ($appointmentStart->lte($slotStartTime) && $appointmentEnd->gte($slotEndTime))
                            );
                    });

                    //\Illuminate\Support\Facades\Log::alert("RESULT " . ($isTakenByVeterinarian || $isTakenByExternal));

// 🟢 **Ajout si libre sur le calendrier du vétérinaire ET respectant la plage du service**
                    if (!$isTakenByVeterinarian && !$isTakenByExternal && (!$schedule['start']->isToday() || $start->isAfter($now))) {
                        //\Illuminate\Support\Facades\Log::info("ASSIGNATION DE SLOT");
                        $freeSlots[] = [
                            'start_time' => $slotStart,
                            'end_time' => $slotEnd,
                            'carbon_start' => $start->copy(),
                        ];
                    }

                    $start->addMinutes(30);


                    // Ajouter les créneaux trouvés aux slots
                    if (!empty($freeSlots)) {
                        if (!isset($slots[$day])) {
                            $slots[$day] = [];
                        }
                        //\Illuminate\Support\Facades\Log::info("DETECTION DE SLOT");
                        $slots[$day] = array_merge($slots[$day], $freeSlots);
                    }
                }

                // Trier et nettoyer les créneaux horaires
                foreach ($slots as $date => &$daySlots) {
                    $daySlots = collect($daySlots)
                        ->unique(fn($slot) => $slot['start_time'])
                        ->sortBy('start_time')
                        ->values()
                        ->all();
                }

                ksort($slots);
                $this->availableSlots = $slots;
                if (empty($this->availableSlots)) {
                    $this->currentWeek->addWeek();
                    $weekCount++;
                }
            }

            if(empty($groupedSchedules))
                $weekCount++;

        }
    }



    public function nextDay()
    {
        if ($this->currentDayIndex < count($this->availableSlots) - 1) {
            $this->currentDayIndex++;
        }
    }

    public function previousDay()
    {
        if ($this->currentDayIndex > 0) {
            $this->currentDayIndex--;
        }
    }









    public function updateDurationAndRefresh($duration)
    {

        $duration = intval($duration);
        $this->serviceDuration = $duration;
        $this->currentWeek = Carbon::now()->startOfWeek();
        $this->fetchAvailableSlots($duration);
    }

    private function getDayIndexFromFrenchName($dayName)
    {
        $days = [
            'Lundi' => 1,
            'Mardi' => 2,
            'Mercredi' => 3,
            'Jeudi' => 4,
            'Vendredi' => 5,
            'Samedi' => 6,
            'Dimanche' => 7,
        ];

        return $days[$dayName] ?? null;
    }

    public function nextWeek()
    {
        $this->currentWeek->addWeek();
        $this->fetchAvailableSlots($this->serviceDuration);

    }

    public function previousWeek()
    {
        if ($this->currentWeek->greaterThan(Carbon::now()->startOfWeek())) {
            $this->currentWeek->subWeek();
            $this->fetchAvailableSlots($this->serviceDuration);
        }
    }

    private function nextAvailableWeek()
    {
        while (empty($this->availableSlots)) {
            $this->nextWeek();
        }
    }

    public function selectSlot($date, $time)
    {
        $this->selectedSlot = [
            'date' => $date,
            'start_time' => $time,
        ];

        session()->flash('selectedSlot', $this->selectedSlot);
        session()->flash('animalId', $this->animalID);
        session()->flash('serviceId', $this->service_id);

        return redirect()->route('rdv.confirm');
    }




    public function render()
    {
        return view('livewire.calendar-availability', [
            'availableSlots' => $this->availableSlots,
            'currentWeek' => $this->currentWeek,
        ]);
    }
}

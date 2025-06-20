<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Specialite;
use App\Models\Animal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Appointment;
class SearchBar extends Component
{
    public $query = '';
    public $location = '';
    public $isSearch = false;
    public $selectedAnimal = null;
    public $suggestions = [];
    public $userAnimals = [];
    public $latitude;
    public $longitude;
    public $maxDistance = 100;
    public $searchResults = [];

    public $selectedService;
    public $selectedSpecializedService = [];
    public $serviceID;

    public $orderedIds = [];

    public $orderedPositions = []; // Tableau des positions dynamiques

    public $sortPrice;
    public $sortDistance;
    public $sortRating;


    protected $listeners = ['updateLocation', 'refreshCalendar'];
    protected $updatesQueryString = [
        'query' => ['except' => ''],
        'selectedAnimal' => ['except' => ''],
        'location' => ['except' => ''],
        'latitude' => ['except' => ''],
        'longitude' => ['except' => ''],
        'sortPrice' => ['except' => 'normal'],
        'sortDistance' => ['except' => 'normal'],
        'sortRating' => ['except' => 'normal'],
    ];




    public function mount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $this->userAnimals = $user->animaux;
            $this->location = request()->get('location', $user->address ?? '');
            $this->latitude = request()->get('latitude', $user->latitude ?? 45.75);
            $this->longitude = request()->get('longitude', $user->longitude ?? 4.85);
        }

        $this->query = request()->get('query', '');
        $this->selectedAnimal = request()->get('selectedAnimal', null);

        $this->sortPrice = request()->get('price', 'normal');
        $this->sortDistance = request()->get('distance', 'normal');
        $this->sortRating = request()->get('rating', 'normal');

        if ($this->query || $this->selectedAnimal) {
            $this->selectService($this->query);
        }

        // Initialiser les positions selon l’ordre d’origine des résultats
        foreach (Service::all() as $index => $service) {
            $this->orderedPositions[$service->id] = $index;
        }

        $this->fill(request()->only([
            'query', 'selectedAnimal', 'location', 'latitude', 'longitude', 'sortPrice', 'sortDistance', 'sortRating'
        ]));
    }




    public function boot()
    {
        $this->fill(request()->only([
            'query', 'selectedAnimal', 'location', 'latitude', 'longitude', 'sortPrice', 'sortDistance', 'sortRating'
        ]));
    }




    public function searchByQuery()
    {
        if (!empty($this->query)) {
            $this->selectService(null);
        }
    }


    public function updatedQuery()
    {
        if (strlen($this->query) > 1) {
            $this->suggestions = $this->searchAll();
        } else {
            $this->suggestions = [];
        }
    }


    public function updateSession($serviceId)
    {
        // Vérification stricte pour éviter "undefined" et "null"
        $selectedValue = $this->selectedSpecializedService[$serviceId] ?? 'null';
        $isSpecialized = !empty($selectedValue) && $selectedValue !== 'null' && $selectedValue !== 'undefined';
        $specialityId = $isSpecialized ? $selectedValue : null;

        session()->put("appointment_selection_{$serviceId}", [
            'is_specialised' => $isSpecialized,
            'speciality_id' => $specialityId,
        ]);

        if ($isSpecialized) {
            $specializedService = \App\Models\SpecializedService::find($specialityId);
            if ($specializedService) {
                $this->serviceID = $specializedService->service_id;
                $this->selectedService = Service::find($specializedService->service_id);
                $this->dispatch('updateAppointmentDuration', $specializedService->duration);
            }
        } else {
            $baseService = Service::findOrFail($serviceId);
            $this->serviceID = $baseService->id;
            $this->selectedService = $baseService;
            $this->dispatch('updateAppointmentDuration', $baseService->duration);
        }
    }





    public function searchAll()
    {
        $services = Service::where('name', 'LIKE', '%' . $this->query . '%')
            ->where("is_enabled", 1)
            ->select('id', 'name', 'user_id') // On sélectionne uniquement les colonnes nécessaires
            ->with('user:id,name,latitude,longitude') // Chargement optimisé
            ->orderBy('name', 'asc') // ✅ Ajout du tri alphabétique
            ->limit(4)
            ->get()
            ->groupBy('name');

        $specialties = Specialite::where('nom', 'LIKE', '%' . $this->query . '%')
            ->orderByRaw("CASE WHEN nom = 'Vétérinaire généraliste' THEN 0 ELSE 1 END, nom ASC") // ✅ “Vétérinaire généraliste” en premier, puis tri alphabétique
            ->limit(8)
            ->get();


        return [
            'services' => $services->toArray(), // Convertir en tableau pour éviter l'erreur
            'specialties' => $specialties
        ];
    }


    public function updatemaxDistance()
    {

    }

    public function selectService($serviceName)
    {
        $search = $serviceName ? "%$serviceName%" : $this->query;

        $services = Service::where('name', 'LIKE', '%' . $search . '%')
            ->where("is_enabled", 1)
            ->whereHas('user', function ($query) {
                $query->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->where(function ($query) {
                        $query->where('is_subscribed', 1)
                            ->orWhere('is_ambassador', 1)
                            ->orWhere(function ($subQuery) {
                                $subQuery->whereNotNull('free_trial_end')
                                    ->where('free_trial_end', '>', Carbon::now()); // Vérifie si l’essai est actif
                            });

                    });
            })
            ->with('user:id,name,latitude,longitude')
            ->get()
            ->filter(function ($service) {
                return $service->user && $this->calculateDistance(
                        $this->latitude,
                        $this->longitude,
                        $service->user->latitude,
                        $service->user->longitude
                    ) <= $this->maxDistance;
            });

        // Appliquer les filtres
        // Appliquer les filtres
        if ($this->sortPrice !== 'normal') {
            $services = $services->sortBy($this->sortPrice === 'asc' ? 'price' : '-price');
        }

        if ($this->sortDistance !== 'normal') {
            $services = $services->sortBy(function ($service) {
                return $this->calculateDistance(
                    $this->latitude,
                    $this->longitude,
                    $service->user->latitude,
                    $service->user->longitude
                );
            });
        }

        if ($this->sortRating !== 'normal') {
            $services = $services->sortByDesc(function ($service) {
                return \App\Models\Review::where('specialist_id', $service->user->id)->avg('rating') ?? 0;
            });
        }


        // Mettre à jour les résultats
        $this->searchResults = $services->groupBy('name')->toArray();
        $this->suggestions = [];
        $this->isSearch = true;
    }



    public function updateSorting($type, $direction)
    {
        $params = request()->all();
        $params[$type] = $direction;

        return redirect()->route('search', $params);
    }



    public function sortBy($criteria)
    {
        if ($this->searchResults) {
            $sortedIds = collect($this->searchResults)
                ->flatten(1)
                ->sortBy($criteria === 'price' ? 'price' :
                    ($criteria === 'availability' ? fn($service) => $this->getNextAvailableSlot($service)?->timestamp ?? now()->addWeeks(5)->timestamp :
                        \App\Models\Review::where('specialist_id', $service['user']['id'])->avg('rating') ?? 0)
                )
                ->pluck('id')
                ->toArray();

            // Mettre à jour `orderedPositions` pour trier via CSS uniquement
            foreach ($sortedIds as $position => $id) {
                $this->orderedPositions[$id] = $position;
            }

            // Pas de modification de `searchResults` → pas de rechargement Livewire !
            $this->dispatch('updateSortedPositions', $this->orderedPositions);
        }
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


    private function getNextAvailableSlot($service)
    {
        $service = Service::with('schedules')->findOrFail($service['id']);
        $specialistId = $service->user_id;

        $appointments = Appointment::where('assign_specialist_id', $specialistId)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->get();

        $now = Carbon::now();
        $maxWeeksToSearch = 5;
        $weekCount = 0;
        $slots = [];

        while (empty($slots) && $weekCount < $maxWeeksToSearch) {
            $groupedSchedules = [];

            foreach ($service->schedules as $schedule) {
                $dayIndex = $this->getDayIndexFromFrenchName($schedule->day_of_week);
                $day = now()->copy()->startOfWeek()->addDays($dayIndex - 1);

                if ($day->isPast() && !$day->isToday()) continue;

                if (!isset($groupedSchedules[$day->toDateString()])) {
                    $groupedSchedules[$day->toDateString()] = [
                        'start' => null,
                        'end' => null
                    ];
                }

                $scheduleStart = Carbon::parse($schedule->start_time, 'Europe/Paris')->setDate($day->year, $day->month, $day->day);
                $scheduleEnd = Carbon::parse($schedule->end_time, 'Europe/Paris')->setDate($day->year, $day->month, $day->day);

                if (!$groupedSchedules[$day->toDateString()]['start'] || $scheduleStart->lessThan($groupedSchedules[$day->toDateString()]['start'])) {
                    $groupedSchedules[$day->toDateString()]['start'] = $scheduleStart;
                }

                if (!$groupedSchedules[$day->toDateString()]['end'] || $scheduleEnd->greaterThan($groupedSchedules[$day->toDateString()]['end'])) {
                    $groupedSchedules[$day->toDateString()]['end'] = $scheduleEnd;
                }
            }

            foreach ($groupedSchedules as $day => $schedule) {
                $start = $schedule['start']->copy();
                $end = $schedule['end']->copy();

                while ($start->lessThan($end)) {
                    $slotStart = $start->format('H:i');
                    $slotEnd = $start->copy()->addMinutes($service->duration)->format('H:i');

                    if ($start->copy()->addMinutes($service->duration)->greaterThan($end)) {
                        break;
                    }

                    $isTakenByVeterinarian = $appointments->contains(function ($appointment) use ($day, $slotStart, $slotEnd) {
                        $appointmentStart = Carbon::parse($appointment->date)->setTimeFromTimeString($appointment->start_time);
                        $appointmentEnd = Carbon::parse($appointment->date)->setTimeFromTimeString($appointment->end_time);

                        return $appointmentStart->toDateString() === $day &&
                            (
                                ($slotStart >= $appointmentStart->format('H:i') && $slotStart < $appointmentEnd->format('H:i')) ||
                                ($slotEnd > $appointmentStart->format('H:i') && $slotEnd <= $appointmentEnd->format('H:i')) ||
                                ($slotStart <= $appointmentStart->format('H:i') && $slotEnd >= $appointmentEnd->format('H:i')) ||
                                ($appointmentStart->format('H:i') <= $slotStart && $appointmentEnd->format('H:i') >= $slotEnd)
                            );
                    });

                    if (!$isTakenByVeterinarian && (!$schedule['start']->isToday() || $start->isAfter($now))) {
                        return $start; // Renvoie immédiatement le premier créneau libre
                    }

                    $start->addMinutes(30);
                }
            }

            $weekCount++;
        }

        return null; // Aucune disponibilité trouvée sur 5 semaines
    }



    public function selectSpecialty($specialtyId)
    {
        session()->put("come_from_searchbar",true);
        session()->put("user_addr",$this->location);
        return redirect()->route('specialities.index', ['id' => $specialtyId]);
    }

    public function updateLocation($lat, $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
        $this->updateAddressFromCoordinates();
    }

    private function updateAddressFromCoordinates()
    {
        if ($this->latitude && $this->longitude) {
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
            ])->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $this->latitude,
                'lon' => $this->longitude,
                'format' => 'json',
            ]);

            if ($geoResponse->successful() && isset($geoResponse->json()['display_name'])) {
                $this->location = $geoResponse->json()['display_name'];
            }
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    public function render()
    {
        return view('livewire.search-bar');
    }
}

<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Cabinet;
use App\Models\SpecialiteServiceType;
use App\Models\SpecializedService;
use App\Models\VetoExt;
use Illuminate\Support\Carbon;
use Livewire\Component;
use App\Models\Animal;
use App\Models\Specialite;
use App\Models\Service;
use App\Models\ServiceType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BookAppointmentWizard extends Component
{
    public $step = 1;
    public $animalId;
    public $specialiteId;
    public $serviceTypeId;
    public $selectedService;
    public $selectedSpecializedService = [];
    public $reason;
    public $services = [];
    public $specializedServices = [];
    public $userAnimals;
    public $latitude;
    public $longitude;
    public $maxDistance = 10;
    public $serviceID;
    public $filteredServiceTypes = []; // Liste des services filtrés
    public $veterinarySpecialties = [];
    public $isVeterinaryGroupSelected = false;


    public $preciseServices = []; // Liste des services précis filtrés
    public $selectedPreciseService = null; // Service précis sélectionné
    public $vetoExternes;


    protected $listeners = ['setCoordinates','updateLocation'];

    public function mount()
    {
        $user = Auth::user();
        $this->userAnimals = $user->animaux; // Charger les animaux de l'utilisateur
        $this->userAddress = $user->address; // Charger l'adresse de l'utilisateur
        $this->latitude = 45.75;
        $this->longitude = 4.85;
        $this->filteredServiceTypes = ServiceType::all(); // Chargement initial de tous les types
        $this->selectedSpecializedService = [];
        $this->veterinarySpecialties = Specialite::where('nom', 'like', '%vétérinaire%')
            ->where('nom', '!=', 'Vétérinaire généraliste')
            ->get();

    }

    public function selectAnimal($id)
    {
        $this->animalId = $id;
        $this->step = 2;
    }

    public function selectSpecialite($id)
    {
        if($id == 'veterinary_group'){
            $this->isVeterinaryGroupSelected = true;
            $this->step = 2.5;
        }
        else{
            $specialite = Specialite::find($id);
            if ($specialite->nom === 'Vétérinaire généraliste') {
                $this->specialiteId = $id;
                $this->isVeterinaryGroupSelected = false;
                $this->filterServiceTypes();
                $this->step = 3;
            } else {
                $this->specialiteId = $id;
                $this->isVeterinaryGroupSelected = false;
                $this->filterServiceTypes();
                $this->step = 3;
            }
        }


    }

    public function selectVeterinarySpecialite($id)
    {
        $this->specialiteId = $id;
        $this->filterServiceTypes();
        $this->step = 3; // Revenir à la logique normale après le choix
    }

    public function selectServiceType($id)
    {
        $this->serviceTypeId = $id;

        // Récupérer les services précis liés au type sélectionné
        $this->preciseServices = \App\Models\ServiceTemplate::where('services_types_id', $id)->get();

        $this->step = 4; // Nouvelle étape pour la précision du service
    }

    public function selectPreciseService($id)
    {
        $this->selectedPreciseService = \App\Models\ServiceTemplate::findOrFail($id);

        // Vérifier si le service appartient à la spécialité "Pet Sitter"
        $petSitterSpecialite = Specialite::where('nom', 'Pet Sitter')->first();

        if ($this->specialiteId == $petSitterSpecialite->id) {
            return redirect()->route('pet.sitter.appointment', [
                'animalId' => $this->animalId,
                'specialiteId' => $this->specialiteId,
                'serviceTypeId' => $this->serviceTypeId,
                'serviceTemplateId' => $this->selectedPreciseService->id
            ]);
        }

        $this->step = 5; // On passe à l'étape de la raison du rendez-vous
    }



    public function filterServiceTypes()
    {
        if (!$this->specialiteId) {
            $this->filteredServiceTypes = ServiceType::all();
            return;
        }
        // Récupérer les services compatibles avec la spécialité sélectionnée
        $allowedServiceTypeIds = SpecialiteServiceType::where('specialite_id', $this->specialiteId)
            ->pluck('services_types_id');

        // Filtrer les types de services correspondants
        $this->filteredServiceTypes = ServiceType::whereIn('id', $allowedServiceTypeIds)->get();
    }


    public function selectService($serviceId)
    {
        $this->serviceID = $serviceId;
        $this->selectedService = Service::with('specializedServices')->findOrFail($serviceId);

        // Vérifier si l'animal est éligible aux prestations spécialisées
        $animal = Animal::findOrFail($this->animalId);
        $this->specializedServices = $this->selectedService->specializedServices->filter(function ($specializedService) use ($animal) {
            return ($specializedService->min_weight <= $animal->weight && $specializedService->max_weight >= $animal->weight)
                && ($specializedService->min_height <= $animal->height && $specializedService->max_height >= $animal->height);
        });

        $this->step = 6;
    }


    public function selectSpecializedService($specializedServiceId)
    {
        $this->selectedSpecializedService = SpecializedService::findOrFail($specializedServiceId);
        $this->updateSession();
    }


    public function setCoordinates($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;

        // Rechercher l'adresse basée sur les coordonnées
        $this->updateAddressFromCoordinates();
    }

    public function updated($propertyName)
    {

        if($propertyName == 'userAddress')
            $this->updateCoordinatesFromAddress();

        if ($propertyName === 'latitude' || $propertyName === 'longitude') {
            $this->updateAddressFromCoordinates();
        }
    }



    #[On('updateLocation')]
    public function updateLocation($lat, $long)
    {

        $this->latitude = $lat;
        $this->longitude = $long;


        $this->updateAddressFromCoordinates();
    }

    private function updateCoordinatesFromAddress()
    {
        $this->latitude = Auth::user()->latitude;
        $this->longitude = Auth::user()->longitude;
//        if($this->userAddress){
//            $geoResponse = Http::withHeaders([
//                'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
//            ])->get('https://nominatim.openstreetmap.org/search', [
//                'q' => $this->userAddress,
//                'format' => 'json',
//                'limit' => 1,
//            ]);
//
//            if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
//                $geoData = $geoResponse->json()[0];
//                $this->latitude = $geoData['lat'];
//                $this->longitude = $geoData['lon'];
//
//            }
//        }
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
                $this->userAddress = $geoResponse->json()['display_name'];
            }
        }
    }

    public function updatedMaxDistance()
    {
        $this->fetchServices();
    }




    public function fetchServices()
    {


        $serviceTemplates = \App\Models\ServiceTemplate::pluck('name')->toArray();

        $allServices = Service::with('user', 'specializedServices')
            ->whereHas('user.specialites', function ($query) {
                $query->where('specialites.id', $this->specialiteId);
            })
            ->when($this->serviceTypeId, function ($query) {
                $query->where('services.services_types_id', $this->serviceTypeId);
            })
            ->get();


        $this->services = $allServices->filter(function ($service) use ($serviceTemplates) {

            if (!in_array($service->name, $serviceTemplates)) {
                return false;
            }

            // Vérifiez si l'utilisateur a une adresse valide
            if ($service->user && $service->user->address) {
                // Récupérez les coordonnées via Nominatim



                if($service->user->latitude == null && $service->user->longitude == null){
                    $service->user->updateCoordinatesFromAddress();
                }

//                $geoResponse = Http::withHeaders([
//                    'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
//                ])->get('https://nominatim.openstreetmap.org/search', [
//                    'q' => $service->user->address,
//                    'format' => 'json',
//                    'limit' => 1,
//                ]);

//                    $geoData = $geoResponse->json()[0];
                    $serviceLat = $service->user->latitude;
                    $serviceLng = $service->user->longitude;

                    // Calculer la distance
                    $distance = $this->calculateDistance(
                        $this->latitude,
                        $this->longitude,
                        $serviceLat,
                        $serviceLng
                    );

                    // Filtrer en fonction de la distance maximale autorisée
                    return $distance <= $this->maxDistance;

            }

            // Si aucune adresse valide, excluez le service
            return false;
        });


        $latitude = $this->latitude;
        $longitude = $this->longitude;
        $specialiteId = $this->specialiteId;
        $this->vetoExternes = $this->getNearbyVetoExternes($latitude, $longitude, $specialiteId);

    }


    public function getNearbyVetoExternes($latitude, $longitude, $specialiteId, $maxDistance = 50)
    {
        // 1️⃣ Récupérer tous les cabinets qui ont des vétérinaires externes
        $cabinets = Cabinet::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        // 2️⃣ Initialiser un tableau pour stocker les cabinets valides
        $validCabinets = [];

        // 3️⃣ Parcourir chaque cabinet et calculer la distance
        foreach ($cabinets as $cabinet) {
            $distance = $this->calculateDistance($latitude, $longitude, $cabinet->latitude, $cabinet->longitude);

            if ($distance <= $maxDistance) {
                $validCabinets[] = [
                    'id' => $cabinet->id,
                    'nom' => $cabinet->nom,
                    'adresse' => $cabinet->adresse,
                    'tel' => $cabinet->tel,
                    'distance' => $distance
                ];
            }
        }

        // 4️⃣ Si aucun cabinet valide, faire un dd() et stopper l'exécution
        if (empty($validCabinets)) {
            dd("Aucun cabinet trouvé dans la distance de $maxDistance km", $cabinets);
        }

        // 5️⃣ Récupérer les vétérinaires externes liés aux cabinets trouvés
        $vetoExternes = VetoExt::whereHas('cabinets', function ($query) use ($validCabinets) {
            $query->whereIn('cabinet.id', array_column($validCabinets, 'id'));
        })
            ->whereHas('specialites', function ($query) use ($specialiteId) {
                $query->where('specialites.id', $specialiteId);
            })
            ->get();

        // 6️⃣ Si aucun vétérinaire trouvé, faire un dd()
        if ($vetoExternes->isEmpty()) {
            dd("Aucun vétérinaire externe ne correspond à la distance et spécialité demandée.", $validCabinets);
        }

        // 7️⃣ Retourner les vétérinaires trouvés
        return $vetoExternes;
    }


    public function redirectToPetSitterAppointment()
    {
        return redirect()->route('pet.sitter.appointment', [
            'animalId' => $this->animalId,
            'specialiteId' => $this->specialiteId,
            'serviceTypeId' => $this->serviceTypeId
        ]);
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

    public function goToNextStep()
    {
        if($this->step < 6)
            $this->step++;
        if ($this->step === 6) {
            $this->fetchServices();
        }
    }

    public function goToPreviousStep()
    {
        if($this->step == 2.5)
            $this->step = 2;
        else
            $this->step--;
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
            $specializedService = SpecializedService::find($specialityId);
            if ($specializedService) {
                $this->serviceID = $specializedService->service->id;
                $this->selectedService = Service::find($specializedService->service->id);
                $this->dispatch('updateAppointmentDuration', $specializedService->duration);
            }
        } else {
            $baseService = Service::findOrFail($serviceId);
            $this->serviceID = $baseService->id;
            $this->selectedService = $baseService;
            $this->dispatch('updateAppointmentDuration', $baseService->duration);
        }
    }







    public function render()
    {
        return view('livewire.book-appointment-wizard', [
            'specialites' => Specialite::all(),
            'serviceTypes' => $this->filteredServiceTypes,
            'services' => $this->services,
            'animalId' => $this->animalId, // Ajout de l'animalId
            'specializedServices' => $this->specializedServices,
            'vetoExternes' => $this->vetoExternes,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Cabinet;
use App\Models\VetoExt;
use Livewire\Component;
use App\Models\Specialite;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class SpecialitySearch extends Component
{
    public $speciality;
    public $latitude;
    public $longitude;
    public $userAddress;
    public $distance = 5; // Distance par défaut (5km)
    public $specialistUsers = [];
    public $externalVeterinarians = [];
    public $message = null;

    protected $listeners = ['updateLocation'];

    public function mount($specialityId)
    {
        $this->speciality = Specialite::findOrFail($specialityId);

        // Si l'utilisateur est connecté, récupérer son adresse
        if (Auth::check()) {
            $this->userAddress = Auth::user()->address;
            if(session()->get("come_from_searchbar"))
            {
                $this->userAddress = session()->get("user_addr");
                session()->forget("user_addr");
            }

            $this->latitude = Auth::user()->latitude;
            $this->longitude = Auth::user()->longitude;
        }

        // Charger les spécialistes internes avec filtrage de distance
        $this->fetchSpecialistUsers();

        // Charger les vétérinaires externes
        $this->fetchExternalVeterinarians();
    }

    #[On('updateLocation')]
    public function updateLocation($lat, $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
        $this->updateAddressFromCoordinates();
    }

    /**
     * 🎯 Charger les spécialistes internes en fonction de la distance
     */
    public function fetchSpecialistUsers()
    {
        if ($this->latitude && $this->longitude) {
            $this->specialistUsers = $this->speciality->users()
                ->whereNotNull('latitude')
                ->whereNotNull('longitude')
                ->get()
                ->filter(function ($user) {
                    if ($user->latitude && $user->longitude) {
                        $distance = $this->calculateDistance($this->latitude, $this->longitude, $user->latitude, $user->longitude);
                        $user->distance = $distance;
                        return $distance <= $this->distance;
                    }
                    return false;
                })
                ->sortBy('distance')
                ->values();
        }
    }

    public function updateCoordinatesFromAddress()
    {
        $this->search = true;
        $this->message = "🔍 Recherche en cours...";

        if ($this->userAddress) {
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $this->userAddress,
                'format' => 'json',
                'limit' => 1,
            ]);

            if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
                $geoData = $geoResponse->json()[0];
                $this->latitude = $geoData['lat'];
                $this->longitude = $geoData['lon'];

                // Actualiser les vétérinaires et spécialistes internes
                $this->fetchSpecialistUsers();
                $this->fetchExternalVeterinarians();
            } else {
                $this->message = "🚫 Adresse introuvable. Veuillez réessayer.";
            }
        }
    }

    /**
     * 🎯 Charger les vétérinaires externes en fonction des cabinets et de la distance
     */
    public function fetchExternalVeterinarians()
    {
        if ($this->latitude && $this->longitude) {
            // 1️⃣ Récupérer les cabinets proches
            $nearbyCabinets = Cabinet::select('cabinet.id as cabinet_id', 'cabinet.nom', 'cabinet.adresse', 'cabinet.tel', 'cabinet.latitude', 'cabinet.longitude')
                ->get()
                ->filter(function ($cabinet) {
                    if ($cabinet->latitude && $cabinet->longitude) {
                        $distance = $this->calculateDistance($this->latitude, $this->longitude, $cabinet->latitude, $cabinet->longitude);
                        $cabinet->distance = $distance;
                        return $distance <= $this->distance;
                    }
                    return false;
                })
                ->sortBy('distance')
                ->values();




            $cabinetIds = $nearbyCabinets->pluck('cabinet_id')->toArray();

            // 2️⃣ Récupérer les vétérinaires externes associés aux cabinets proches
            $this->externalVeterinarians = VetoExt::select('veto_ext.id', 'veto_ext.name')
                ->join('veto_ext_specialite', 'veto_ext.id', '=', 'veto_ext_specialite.veto_ext_id')
                ->join('spe_has_cabinet', 'veto_ext.id', '=', 'spe_has_cabinet.veto_ext_id')
                ->where('veto_ext_specialite.specialite_id', $this->speciality->id)
                ->whereIn('spe_has_cabinet.cabinet_id', $cabinetIds)
                ->distinct()
                ->with(['cabinets' => function ($query) {
                    $query->select(
                        'cabinet.id AS cabinet_id', // ⚠ Correction ici
                        'cabinet.nom',
                        'cabinet.adresse',
                        'cabinet.tel',
                        'cabinet.latitude',
                        'cabinet.longitude'
                    );
                }])
                ->get()
                ->map(function ($vet) use ($nearbyCabinets) {
                    // Associer le cabinet le plus proche
                    $vet->nearestCabinet = $nearbyCabinets->firstWhere('cabinet_id', optional($vet->cabinets->first())->cabinet_id);
                    return $vet;
                });

        }
    }


    /**
     * 🎯 Calculer la distance entre deux points GPS
     */
    public function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Rayon de la Terre en km
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }

    /**
     * 🎯 Mettre à jour la liste lorsque la distance change
     */
    public function updated($propertyName)
    {
        if ($propertyName === 'distance') {
            $this->fetchSpecialistUsers();
            $this->fetchExternalVeterinarians();
        }
    }

    /**
     * 🎯 Récupérer l'adresse à partir des coordonnées GPS
     */
    private function updateAddressFromCoordinates()
    {
        if ($this->latitude && $this->longitude) {
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0',
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

    /**
     * 🎯 Affichage des résultats dans la vue
     */
    public function render()
    {
        return view('livewire.speciality-search', [
            'specialistUsers' => $this->specialistUsers,
            'externalVeterinarians' => $this->externalVeterinarians,
        ]);
    }
}

<?php

namespace App\Livewire;

use App\Models\Cabinet;
use App\Models\Signalement;
use App\Models\VetoExt;
use Livewire\Component;
use App\Models\User; // Pour récupérer les vétérinaires
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class UrgenceJournee extends Component
{
    public $userAddress;
    public $latitude;
    public $longitude;
    public $distance = 10; // Distance par défaut
    public $veterinarians = [];
    public $message = "";
    public $search = 0;
    public $suggestions = [];



    public $nom;
    public $prenom;
    public $email;
    public $libelle;
    public $showModal = false;

    public $externalVeterinarians = [];

    protected $listeners = ['updateLocation'];


    public function mount()
    {
        // Si l'utilisateur est connecté, récupérer son adresse
        if (Auth::check()) {
            $this->userAddress = Auth::user()->address;
        }
    }

    #[On('updateLocation')]
    public function updateLocation($lat, $long)
    {
        $this->latitude = $lat;
        $this->longitude = $long;
        $this->updateAddressFromCoordinates();
    }

    public function searchAddress()
    {
        if (strlen($this->userAddress) < 5) {
            $this->suggestions = [];
            return;
        }

        $response =  Http::withHeaders([
            'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
        ])->get('https://nominatim.openstreetmap.org/search', [
            'q' => $this->userAddress,
            'format' => 'json',
            'limit' => 5,
        ]);
        if ($response->successful()) {
            $this->suggestions = $response->json();
        }
    }


    public function SetData($address, $lat, $lon)
    {

        $this->userAddress = $address;
        $this->latitude = $lat;
        $this->longitude = $lon;
        $this->suggestions = [];
        $this->fetchVeterinarians();
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

    public function updated($propertyName)
    {
        // Si l'utilisateur met à jour l'adresse
        if ($propertyName === 'userAddress') {
            $this->updateCoordinatesFromAddress();
        }

        // Si la distance est mise à jour, recharger les vétérinaires
        if ($propertyName === 'distance') {
            $this->fetchVeterinarians();
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


                // Actualiser les vétérinaires
                $this->fetchVeterinarians();
            } else {
                $this->message = "🚫 Adresse introuvable. Veuillez réessayer.";
            }
        }
    }

    public function updateCoordinatesVeterinarians($address)
    {
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
            ]);

            if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
                $geoData = $geoResponse->json()[0];
                return [$geoData['lat'],$geoData['lon']];

        }

            return false;
    }





    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset(['nom', 'prenom', 'email', 'libelle', 'message']);
    }

    public function submitSignalement()
    {
        $this->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email',
            'libelle' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        Signalement::create([
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'email' => $this->email,
            'libelle' => $this->libelle,
            'message' => $this->message,
            'traite' => false, // Par défaut, non traité
        ]);

        session()->flash('success', 'Votre signalement a été envoyé avec succès.');

        $this->closeModal();
    }

    public function fetchVeterinarians()
    {
        if ($this->latitude && $this->longitude) {
            $this->message = "🔍 Recherche des vétérinaires en cours...";

//            // 🏥 1️⃣ Récupérer les vétérinaires internes (inscrits)
//            $this->veterinarians = User::where('type', 'S')->get()->map(function ($veterinarian) {
//                list($lat, $long) = $this->updateCoordinatesVeterinarians($veterinarian->address);
//
//                if ($lat && $long) {
//                    $distance = $this->calculateDistance($this->latitude, $this->longitude, $lat, $long);
//                    $veterinarian->distance = $distance;
//
//                    return $distance <= $this->distance ? $veterinarian : null;
//                }
//                return null;
//            })->filter();

            // NE PAS INCLUDE LES VETERINAIRES SUR LE SITE
            $this->veterinarians = collect();

            // 🏥 2️⃣ Récupérer les vétérinaires externes en fonction des cabinets
            // 1️⃣ Récupérer les cabinets proches
            $nearbyCabinets = Cabinet::select('cabinet.*')
                ->selectRaw("(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance",
                    [$this->latitude, $this->longitude, $this->latitude])
                ->having("distance", "<=", $this->distance)
                ->orderBy("distance")
                ->get();

            //dd($nearbyCabinets);

            // 2️⃣ Associer les vétérinaires externes à ces cabinets
            $externalVeterinarians = collect();

            foreach ($nearbyCabinets as $cabinet) {
                foreach ($cabinet->veterinarians as $veto) {


                    $hasGeneralistSpecialty = $veto->specialites->contains('nom', 'Vétérinaire généraliste');


                    if ($hasGeneralistSpecialty) {
                        $externalVeterinarians->push([
                            'name' => $veto->name,
                            'address' => $cabinet->adresse,
                            'distance' => $cabinet->distance,
                            'phone_number' => $cabinet->tel,
                            'is_registered' => false
                        ]);
                    }

                }
            }

            //dd($this->externalVeterinarians);
            $this->externalVeterinarians = $externalVeterinarians;

            $this->message = "";
        }
    }

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

    public function render()
    {
        return view('livewire.urgence-journee', [
            'veterinarians' => $this->veterinarians,
        ]);
    }
}

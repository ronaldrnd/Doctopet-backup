<?php

namespace App\Livewire;

use App\Models\Elevage;
use App\Models\Espece;
use App\Models\Race;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Livewire\Component;

class FindBreederWizard extends Component
{
    public $step = 1;
    public $especeId;
    public $raceId;
    public $latitude;
    public $longitude;
    public $maxDistance = 300;

    public $breeders = [];



    public function mount()
    {
        $this->latitude = 45.75; // Par défaut (Lyon)
        $this->longitude = 4.85;
        $this->latitude = 45.75;
        $this->longitude = 4.85;
    }

    public function selectEspece($id)
    {
        $this->especeId = $id;
        $this->step = 2;
        session()->put("espece_nom",Espece::find($id)->nom);
    }

    public function selectRace($id)
    {
        $this->raceId = $id;
        $this->step = 3;
        session()->put("race_nom",Race::find($id)->nom);
        $this->findBreeders();

    }

    public function setLocation($latitude, $longitude)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->findBreeders();
        $this->step = 4;
    }

    public function updatedMaxDistance()
    {
        $this->filterBreeders();
    }


    public function filterBreeders()
    {
        $this->breeders = $this->breeders->filter(fn($breeder) => $breeder->distance !== null && $breeder->distance <= $this->maxDistance);
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

    public function findBreeders()
    {
        $this->breeders = Elevage::with('eleveur')
            ->where('espece_id', $this->especeId)
            ->when($this->raceId, fn($q) => $q->where('race_id', $this->raceId))
        ->get();



        $this->breeders->each(function ($breeder) {
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $breeder->eleveur->address,
                'format' => 'json',
                'limit' => 1,
            ]);


            if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
                $geoData = $geoResponse->json()[0];
                $serviceLat = $geoData['lat'];
                $serviceLng = $geoData['lon'];

                // Calculer et stocker la distance dans l'objet
                $breeder->distance = $this->calculateDistance(
                    $this->latitude,
                    $this->longitude,
                    $serviceLat,
                    $serviceLng
                );
            } else {
                $breeder->distance = null; // Si échec de récupération de coordonnées
            }
        });

    }


    public function render()
    {
        return view('livewire.find-breeder-wizard', [
            'especes' => Espece::all(),
            'races' => $this->especeId ? Race::where('espece_id', $this->especeId)->get() : [],
        ]);
    }
}

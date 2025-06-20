<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ManageAppointments extends Component
{
    const DEFAULT_LAT = 45.75; // Lyon
    const DEFAULT_LNG = 4.85; // Lyon

    public $search = '';
    public $services = [];
    public $latitude;
    public $longitude;
    public $maxDistance = 20; // Distance par défaut en km

    public $upcomingAppointments = [];
    public $pastAppointments = [];

    public function mount()
    {
        $this->loadAppointments();
        $this->fetchNearbyServices();
    }

    public function updatedSearch()
    {
        $this->fetchNearbyServices();
    }

    public function updatedMaxDistance()
    {
        $this->fetchNearbyServices();
    }

    private function fetchNearbyServices()
    {
        $user = Auth::user();

        // Étape 1 : Géocoder l'adresse de l'utilisateur
        if ($user && $user->address) {
            $geoResponse = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $user->address,
                'format' => 'json',
                'limit' => 1,
            ]);


            if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
                $geoData = $geoResponse->json()[0];
                $this->latitude = $geoData['lat'];
                $this->longitude = $geoData['lon'];
            } else {
                $this->latitude = self::DEFAULT_LAT;
                $this->longitude = self::DEFAULT_LNG;
            }
        }

        // Valeurs par défaut si la géolocalisation échoue
        if (!$this->latitude || !$this->longitude) {
            $this->latitude = self::DEFAULT_LAT;
            $this->longitude = self::DEFAULT_LNG;
        }

        // Étape 2 : Filtrer les services par distance
        $allServices = Service::with('user')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->get();

        $this->services = $allServices->filter(function ($service) {
            if ($service->user && $service->user->address) {
                $geoResponse = Http::withHeaders([
                    'User-Agent' => 'DoctoPet/1.0 (contact@votreapp.com)',
                ])->get('https://nominatim.openstreetmap.org/search', [
                    'q' => $service->user->address,
                    'format' => 'json',
                    'limit' => 1,
                ]);

                if ($geoResponse->successful() && count($geoResponse->json()) > 0) {
                    $serviceLat = $geoResponse->json()[0]['lat'];
                    $serviceLng = $geoResponse->json()[0]['lon'];

                    $distance = $this->haversineGreatCircleDistance(
                        $this->latitude,
                        $this->longitude,
                        $serviceLat,
                        $serviceLng
                    );

                    return $distance <= $this->maxDistance;
                }
            }

            return false;
        });
    }

    private function haversineGreatCircleDistance($lat1, $lon1, $lat2, $lon2, $earthRadius = 6371)
    {
        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        return $angle * $earthRadius;
    }

    public function loadAppointments()
    {
        $userId = Auth::id();

        $this->upcomingAppointments = Appointment::where('user_id', $userId)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $this->pastAppointments = Appointment::where('user_id', $userId)
            ->where('date', '<', now()->toDateString())
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->get();
    }

    public function render()
    {
        return view('livewire.manage-appointments');
    }
}

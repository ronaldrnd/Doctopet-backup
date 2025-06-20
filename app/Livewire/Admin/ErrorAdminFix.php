<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Cabinet;
use App\Models\VetoExt;
use Illuminate\Support\Facades\Http;

class ErrorAdminFix extends Component
{
    public $usersWithoutCoordinates = [];
    public $cabinetsWithoutCoordinates = [];
    public $veterinariansWithoutCabinet = [];
    public $veterinariansWithoutSpecialty = [];
    public $editingAddress = [];

    public function mount()
    {
        $this->loadUsersWithoutCoordinates();
        $this->loadCabinetsWithoutCoordinates();
        $this->loadVeterinariansWithoutAssignments();

        foreach ($this->usersWithoutCoordinates as $user) {
            $this->editingAddress[$user->id] = $user->address;
        }
    }

    public function loadUsersWithoutCoordinates()
    {
        $this->usersWithoutCoordinates = User::whereNull('latitude')
            ->orWhereNull('longitude')
            ->get();
    }

    public function loadCabinetsWithoutCoordinates()
    {
        $this->cabinetsWithoutCoordinates = Cabinet::whereNull('latitude')
            ->orWhereNull('longitude')
            ->get();
    }

    public function loadVeterinariansWithoutAssignments()
    {
        $this->veterinariansWithoutCabinet = VetoExt::doesntHave('cabinets')->get();
        $this->veterinariansWithoutSpecialty = VetoExt::doesntHave('specialites')->get();
    }

    public function attemptToFix($entityId, $type)
    {
        $entity = ($type === 'user') ? User::find($entityId) : Cabinet::find($entityId);

        if ($entity && $entity->address) {
            $response = Http::withHeaders([
                'User-Agent' => 'DoctoPet/1.0',
            ])->get('https://nominatim.openstreetmap.org/search', [
                'q' => $entity->address,
                'format' => 'json',
                'limit' => 1,
            ]);

            if ($response->successful() && count($response->json()) > 0) {
                $geoData = $response->json()[0];
                $entity->update([
                    'latitude' => $geoData['lat'],
                    'longitude' => $geoData['lon'],
                ]);

                session()->flash('success', "Coordonnées mises à jour pour {$entity->name}");
            } else {
                session()->flash('error', "Impossible de récupérer les coordonnées pour {$entity->name}");
            }
        } else {
            session()->flash('error', "L'entité {$entity->name} n'a pas d'adresse renseignée.");
        }

        $this->loadUsersWithoutCoordinates();
        $this->loadCabinetsWithoutCoordinates();
    }

    public function updateAddress($entityId, $type)
    {

        $entity = ($type === 'user') ? User::find($entityId) : Cabinet::find($entityId);

        $newAddress = $this->editingAddress[$entity->id];
        if ($entity) {
            $entity->update(['address' => $newAddress]);
            session()->flash('success', "Adresse mise à jour pour {$entity->name}");
        }

        $this->editingAddress[$entityId] = false;
    }

    public function render()
    {
        return view('livewire.admin.error-admin-fix');
    }
}

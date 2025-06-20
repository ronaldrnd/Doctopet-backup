<?php

namespace App\Livewire;

use App\Models\Espece;
use App\Models\Service;
use App\Models\ServiceSchedule;
use App\Models\SpecializedService;
use Livewire\Component;

class ServiceView extends Component
{
    public $serviceId;
    public $name, $description, $price, $duration, $gap_between_services, $schedules = [];
    public $isEnabled;
    public $specializedServices = [];
    public $especes;
    public $excludedSpecies = [];


    public function mount($id)
    {
        $service = Service::findOrFail($id);
        $this->serviceId = $service->id;
        $this->name = $service->name;
        $this->description = $service->description;
        $this->price = $service->price;
        $this->duration = $service->duration;
        $this->gap_between_services = $service->gap_between_services;
        $this->isEnabled = $service->is_enabled;
        $this->especes = Espece::all();

        // Charger les horaires
        $this->schedules = $service->schedules->groupBy('day_of_week')
            ->map(function ($slots) {
                return $slots->pluck('start_time')->toArray();
            })
            ->toArray();

        // Charger les prestations spécialisées
        $this->specializedServices = $service->specializedServices->map(function ($specialized) {
            return $specialized->only(['id', 'name', 'price', 'duration', 'min_weight', 'max_weight', 'min_height', 'max_height']);
        })->toArray();

        $this->excludedSpecies = $service->excludedSpecies->pluck('id')->toArray();

    }

    public function addSpecializedService()
    {
        $this->specializedServices[] = [
            'id' => null,
            'name' => '',
            'price' => null,
            'duration' => null,
            'min_weight' => null,
            'max_weight' => null,
            'min_height' => null,
            'max_height' => null,
        ];
    }

    public function removeSpecializedService($index)
    {
        unset($this->specializedServices[$index]);
        $this->specializedServices = array_values($this->specializedServices);
    }

    public function updateService()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
            'gap_between_services' => 'required|integer|min:0',
            'specializedServices.*.name' => 'nullable|string|max:255',
            'specializedServices.*.price' => 'nullable|numeric|min:0',
            'specializedServices.*.duration' => 'nullable|integer|min:1',
            'specializedServices.*.min_weight' => 'nullable|numeric|min:0',
            'specializedServices.*.max_weight' => 'nullable|numeric|min:0',
            'specializedServices.*.min_height' => 'nullable|numeric|min:0',
            'specializedServices.*.max_height' => 'nullable|numeric|min:0',
        ]);

        $service = Service::findOrFail($this->serviceId);
        $service->update([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'gap_between_services' => $this->gap_between_services,
        ]);

        // Supprimer les anciens horaires
        ServiceSchedule::where('service_id', $this->serviceId)->delete();

        // Ajouter les nouveaux horaires
        foreach ($this->schedules as $day => $times) {
            foreach ($times as $time) {
                ServiceSchedule::create([
                    'service_id' => $this->serviceId,
                    'day_of_week' => $day,
                    'start_time' => $time,
                    'end_time' => $this->calculateEndTime($time),
                ]);
            }
        }

        // Gérer les prestations spécialisées
        SpecializedService::where('service_id', $this->serviceId)->delete();
        foreach ($this->specializedServices as $specialized) {
            if (!empty($specialized['name']) || $specialized['price'] || $specialized['duration']) {
                SpecializedService::create([
                    'service_id' => $this->serviceId,
                    'name' => $specialized['name'],
                    'price' => $specialized['price'],
                    'duration' => $specialized['duration'],
                    'min_weight' => intval($specialized['min_weight']),
                    'max_weight' => intval($specialized['max_weight']),
                    'min_height' => $specialized['min_height'],
                    'max_height' => $specialized['max_height'],
                ]);
            }
        }

        // 🔹 Mise à jour des espèces interdites
        $service->excludedSpecies()->sync($this->excludedSpecies);

        session()->flash('success', 'Prestation mise à jour avec succès !');
    }

    public function toggleServiceStatus()
    {
        $service = Service::findOrFail($this->serviceId);
        $service->update(['is_enabled' => !$this->isEnabled]);
        $this->isEnabled = !$this->isEnabled;
    }

    public function deleteService()
    {
        Service::findOrFail($this->serviceId)->delete();
        return redirect()->route('professional.services');
    }

    private function calculateEndTime($startTime)
    {
        $duration = $this->duration;
        return date('H:i:s', strtotime("+$duration minutes", strtotime($startTime)));
    }

    public function render()
    {
        return view('livewire.service-view');
    }
}

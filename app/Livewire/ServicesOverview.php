<?php

namespace App\Livewire;

use App\Models\Espece;
use App\Models\Service;
use App\Models\ServiceSchedule;
use App\Models\SpecializedService;
use App\Models\ServiceType;
use App\Models\ServiceTemplate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ServicesOverview extends Component
{

    public $services;
    public $serviceTypes;
    public $serviceTemplates = [];
    public $selectedServiceType;
    public $selectedServiceTemplate;

    public $name, $description, $price, $duration, $gap_between_services;
    public $schedules = [];
    public $specializedServices = [];


    public $requested_name, $requested_description, $requested_price, $requested_duration;


    public $excludedSpecies = [];
    public $especes;

    public function mount()
    {
        $this->services = Service::where('user_id', auth()->id())->with(['serviceType', 'template','excludedSpecies'])->get();
        $this->serviceTypes = ServiceType::all();
        $this->serviceTemplates = collect();
        $this->schedules = [];
        $this->specializedServices = [];
        $this->especes = Espece::all();
        $this->serviceTemplates = ServiceTemplate::all();
    }




    public function toggleSlot($day, $time)
    {
        if (!isset($this->schedules[$day])) {
            $this->schedules[$day] = [];
        }

        if (in_array($time, $this->schedules[$day])) {
            $this->schedules[$day] = array_filter($this->schedules[$day], fn($slot) => $slot !== $time);
        } else {
            $this->schedules[$day][] = $time;
        }
    }

    public function addSpecializedService()
    {
        $this->specializedServices[] = [
            'name' => '',
            'price' => 0,
            'duration' => 0,
            'size' => '',
            'min_weight' => null,
            'max_weight' => null,
            'min_height' => null,
            'max_height' => null,
        ];
    }

    #[On('getServiceTemplates')]
    public function getServiceTemplates($typeId)
    {
        $this->selectedServiceType = $typeId;
        return ServiceTemplate::where('services_types_id', $typeId)->get();
    }


    #[On('applyServiceTemplate')]
    public function applyServiceTemplate($templateId)
    {
        $template = ServiceTemplate::find($templateId);

        if ($template) {
            $this->selectedServiceTemplate = $template->id;
            $this->name = $template->name;  // Nom fixe basé sur la template
            $this->description = $template->description;
            $this->price = $template->price;
            $this->duration = $template->duration;
            $this->gap_between_services = $template->gap_between_services;
        }
    }

    public function requestNewService()
    {
        $this->validate([
            'requested_name' => 'required|string|max:255',
            'requested_description' => 'nullable|string',
            'requested_price' => 'nullable|numeric|min:0',
            'requested_duration' => 'nullable|integer|min:1',
        ]);

        \App\Models\ServiceRequest::create([
            'user_id' => auth()->id(),
            'requested_name' => $this->requested_name,
            'description' => $this->requested_description,
            'suggested_price' => $this->requested_price,
            'suggested_duration' => $this->requested_duration,
        ]);

        session()->flash('message', 'Votre demande a été envoyée aux administrateurs.');
        $this->reset(['requested_name', 'requested_description', 'requested_price', 'requested_duration']);
    }



    public function updatedSelectedServiceType($typeId)
    {
        if ($typeId) {
            $this->serviceTemplates = ServiceTemplate::where('services_types_id', $typeId)->get();
        }
    }


    public function removeSpecializedService($index)
    {
        unset($this->specializedServices[$index]);
    }


    public function updatedSelectedServiceTemplate($templateId)
    {
        if ($templateId) {
            $template = ServiceTemplate::find($templateId);
            if ($template) {
                $this->name = $template->name;
                $this->description = $template->description;
                $this->price = $template->price;
                $this->duration = $template->duration;
                $this->gap_between_services = $template->gap_between_services;
            }
        } else {
            $this->reset(['name', 'description', 'price', 'duration', 'gap_between_services']);
        }
    }

    private function calculateEndTime($startTime,$serviceDuration)
    {
        return date('H:i:s', strtotime("+$serviceDuration minutes", strtotime($startTime)));
    }


    // Méthode pour activer/désactiver un service
    public function toggleServiceStatus($serviceId)
    {
        $service = Service::findOrFail($serviceId);
        $service->update(['is_enabled' => !$service->is_enabled]);
        $this->services = Service::where('user_id', auth()->id())->with(['serviceType', 'template', 'excludedSpecies'])->get();
    }

    public function saveService()
    {
        $this->validate([
            'name' => 'required|string|max:300',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:1',
        ]);



        // 🔹 Étape 1 : Vérification des horaires
        if (empty($this->schedules)) {
            session()->flash('error', 'Vous devez sélectionner au moins un créneau horaire.');
            $this->render();
            return;
        }

        $minRequiredSlots = $this->duration > 30 ? 2 : 1;
        $validSchedule = false;


        foreach ($this->schedules as $day => $times) {
            sort($times);

            if (count($times) >= $minRequiredSlots) {
                for ($i = 0; $i < count($times) - 1; $i++) {
                    $current = strtotime($times[$i]);
                    $next = strtotime($times[$i + 1]);

                    if ($this->duration > 30 && ($next - $current === 1800)) {
                        $validSchedule = true;
                        break;
                    } elseif ($this->duration <= 30) {
                        $validSchedule = true;
                        break;
                    }
                }
            }

            if ($validSchedule) {
                break;
            }
        }

        if (!$validSchedule) {
            session()->flash('error', 'Votre prestation nécessite au moins ' . $minRequiredSlots . ' créneau(x) consécutif(s).');
            $this->render();
            return;
        }


        // Création du service principal
        $service = Service::create([
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'duration' => $this->duration,
            'services_types_id' => $this->selectedServiceType,
            'user_id' => auth()->id(),
        ]);


        $service->excludedSpecies()->sync($this->excludedSpecies);


        // Création des formules spécialisées basées sur les paramètres entrés
        foreach ($this->specializedServices as $specializedService) {
            $formattedName = "{$this->name} ({$specializedService['duration']} min)";

            SpecializedService::create([
                'service_id' => $service->id,
                'name' => $formattedName,
                'price' => $specializedService['price'],
                'duration' => $specializedService['duration'],
                'min_weight' => $specializedService['min_weight'],
                'max_weight' => $specializedService['max_weight'],
                'min_height' => $specializedService['min_height'],
                'max_height' => $specializedService['max_height'],
            ]);
        }



        // Gestion des horaires
        foreach ($this->schedules as $day => $times) {
            if (!is_array($times)) continue;

            sort($times);
            $mergedSchedules = $this->mergeTimeSlots($times); // Utiliser la fusion correcte des créneaux


            foreach ($mergedSchedules as $schedule) {
                ServiceSchedule::create([
                    'service_id' => $service->id,
                    'day_of_week' => $day,
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'], // Ici, utiliser le bon end_time fusionné
                ]);
            }
        }


        // Réinitialiser les champs après la sauvegarde
        $this->reset(['selectedServiceType', 'selectedServiceTemplate', 'name', 'description', 'price', 'duration', 'gap_between_services', 'schedules', 'specializedServices','excludedSpecies']);
        $this->mount(); // Recharge les données
    }








    private function mergeTimeSlots(array $times): array
    {
        $merged = [];
        sort($times);

        foreach ($times as $time) {
            $start = $time;
            $end = date('H:i:s', strtotime("+30 minutes", strtotime($start))); // Chaque créneau dure 30 minutes
            $merged[] = ['start_time' => $start, 'end_time' => $end];
        }

        return $merged;
    }




    public function render()
    {
        return view('livewire.services-overview', [
            'services' => $this->services,
            'serviceTypes' => $this->serviceTypes,
            'serviceTemplates' => $this->serviceTemplates,
            'especes' => $this->especes,
        ]);
    }
}

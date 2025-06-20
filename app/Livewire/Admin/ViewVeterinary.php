<?php
namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\VetoExt;
use App\Models\Cabinet;
use App\Models\SpeHasCabinet;
use App\Models\Specialite;

class ViewVeterinary extends Component
{
    public $veterinarian;
    public $name;
    public $linkedCabinets = [];
    public $specialites = [];
    public $specialiteId;

    // Recherche pour le cabinet
    public $cabinetSearch = '';
    public $filteredCabinets = [];

    public function mount($vetoId)
    {
        $this->veterinarian = VetoExt::findOrFail($vetoId);
        $this->name = $this->veterinarian->name;
        $this->linkedCabinets = $this->veterinarian->cabinets;
        $this->specialites = $this->veterinarian->specialites;
        $this->filteredCabinets = Cabinet::all();
    }

    public function updatedCabinetSearch()
    {
        $this->filteredCabinets = Cabinet::where('nom', 'like', '%' . $this->cabinetSearch . '%')->get();
    }

    public function linkCabinet($cabinetId)
    {
        $cabinet = Cabinet::find($cabinetId);
        if (!$cabinet) return;

        SpeHasCabinet::firstOrCreate([
            'veto_ext_id' => $this->veterinarian->id,
            'cabinet_id' => $cabinetId
        ]);

        session()->flash('success', "Cabinet '{$cabinet->nom}' associé au vétérinaire.");
        $this->linkedCabinets = $this->veterinarian->cabinets;
        $this->cabinetSearch = ''; // Reset de la recherche
    }

    public function unlinkCabinet($cabinetId)
    {
        SpeHasCabinet::where([
            'veto_ext_id' => $this->veterinarian->id,
            'cabinet_id' => $cabinetId
        ])->delete();

        session()->flash('success', 'Cabinet dissocié du vétérinaire.');
        $this->linkedCabinets = $this->veterinarian->cabinets;
    }

    public function addSpecialite()
    {
        if (!$this->specialiteId) return;

        $this->veterinarian->specialites()->attach($this->specialiteId);
        session()->flash('success', 'Spécialité ajoutée avec succès.');
        $this->specialites = $this->veterinarian->specialites;
    }

    public function removeSpecialite($specialiteId)
    {
        $this->veterinarian->specialites()->detach($specialiteId);
        session()->flash('success', 'Spécialité supprimée.');
        $this->specialites = $this->veterinarian->specialites;
    }

    public function render()
    {
        return view('livewire.admin.view-veterinary', [
            'allSpecialites' => Specialite::all()
        ]);
    }
}

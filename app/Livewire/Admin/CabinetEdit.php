<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Cabinet;
use Illuminate\Support\Facades\Session;

class CabinetEdit extends Component
{
    public $cabinetId;
    public $nom;
    public $adresse;
    public $latitude;
    public $longitude;
    public $modeEdit = false;

    public function mount($cabinetId = null)
    {
        if ($cabinetId) {
            $this->cabinetId = $cabinetId;
            $cabinet = Cabinet::findOrFail($cabinetId);
            $this->nom = $cabinet->nom;
            $this->adresse = $cabinet->adresse;
            $this->latitude = $cabinet->latitude;
            $this->longitude = $cabinet->longitude;
            $this->modeEdit = true;
        }
    }

    public function save()
    {
        $validated = $this->validate([
            'nom' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        if ($this->modeEdit) {
            Cabinet::where('id', $this->cabinetId)->update($validated);
            Session::flash('message', 'Cabinet mis à jour avec succès.');
        } else {
            Cabinet::create($validated);
            Session::flash('message', 'Cabinet créé avec succès.');
        }

    }

    public function delete()
    {
        if ($this->cabinetId) {
            Cabinet::findOrFail($this->cabinetId)->delete();
            Session::flash('message', 'Cabinet supprimé avec succès.');
            return redirect()->route('admin.cabinets');
        }
    }

    public function render()
    {
        return view('livewire.admin.cabinet-edit');
    }
}

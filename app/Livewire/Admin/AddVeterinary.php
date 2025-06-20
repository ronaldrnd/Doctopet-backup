<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VetoExt;
use App\Models\Cabinet;

class AddVeterinary extends Component
{
    use WithPagination;

    public $vetoName;
    public $cabinetName;
    public $cabinetAddress;
    public $cabinetPhone;
    public $search = ''; // Champ pour la recherche

    protected $paginationTheme = 'tailwind';

    public function addVeterinary()
    {
        $existingVeto = VetoExt::where('name', $this->vetoName)->first();

        if ($existingVeto) {
            session()->flash('error', 'Ce vétérinaire existe déjà.');
            return;
        }

        VetoExt::create(['name' => $this->vetoName]);
        session()->flash('success', 'Vétérinaire ajouté avec succès.');
        $this->reset('vetoName');
    }

    public function addCabinet()
    {
        $existingCabinet = Cabinet::where('nom', $this->cabinetName)->first();

        if ($existingCabinet) {
            session()->flash('error', 'Ce cabinet existe déjà.');
            return;
        }

        Cabinet::create([
            'nom' => $this->cabinetName,
            'adresse' => $this->cabinetAddress,
            'tel' => $this->cabinetPhone
        ]);

        session()->flash('success', 'Cabinet ajouté avec succès.');
        $this->reset(['cabinetName', 'cabinetAddress', 'cabinetPhone']);
    }

    public function updatingSearch()
    {
        $this->resetPage(); // Réinitialise la pagination lors d'une nouvelle recherche
    }

    public function render()
    {
        $veterinarians = VetoExt::where('name', 'like', "%{$this->search}%")->paginate(20);

        return view('livewire.admin.add-veterinary', [
            'veterinarians' => $veterinarians
        ]);
    }
}

<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Cabinet;
use App\Models\User;

class CabinetList extends Component
{
    public $cabinets;

    public function mount()
    {
        $this->loadCabinets();
    }

    public function loadCabinets()
    {
        $this->cabinets = Cabinet::withCount('veterinaires')->get();
    }

    public function editCabinet($cabinetId)
    {
        return redirect()->route('admin.cabinet.edit', ['cabinetId' => $cabinetId]);
    }

    public function render()
    {
        return view('livewire.admin.cabinet-list', [
            'cabinets' => $this->cabinets
        ]);
    }
}

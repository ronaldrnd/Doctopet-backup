<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchProfessionals extends Component
{
    public $searchTerm = '';

    public function render()
    {
        // Charger les professionnels avec leurs spécialités
        $professionals = collect();
        if (!empty($this->searchTerm)) {
            $professionals = User::with('specialites')
                ->where('type', 'S')
                ->where('name', 'like', '%' . $this->searchTerm . '%')
                ->get();
        }

        return view('livewire.search-professionals', [
            'professionals' => $professionals
        ]);
    }
}

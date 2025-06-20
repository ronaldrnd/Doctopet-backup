<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class DashboardComponent extends Component
{
    public $currentMode;

    public function mount()
    {
        if(!Auth::check()){
            $this->currentMode = "dashboard";
        }
        else {
            if (Auth::user()->estSpecialiste()) {
                $this->currentMode = session('user_mode', 'pro'); // Par défaut "pro"
            } else {
                $this->currentMode = "client";
            }
        }

    }

    #[On('modeSwitched')]
    public function updateMode($mode)
    {
        $this->currentMode = $mode; // Met à jour le mode
    }

    public function render()
    {
        return view('livewire.dashboard-component');
    }
}

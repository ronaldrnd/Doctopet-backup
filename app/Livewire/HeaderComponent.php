<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HeaderComponent extends Component
{
    public $userMode;

    public function mount()
    {
        if (Auth::check() && Auth::user()->estSpecialiste()) {
            // Initialiser le mode utilisateur à partir de la session ou par défaut à "pro"
            $this->userMode = session('user_mode', 'pro');
        }
    }

    public function switchMode()
    {
        if (Auth::check() && Auth::user()->estSpecialiste()) {
            // Basculer entre "pro" et "client"
            $this->userMode = $this->userMode === 'pro' ? 'client' : 'pro';
            session(['user_mode' => $this->userMode]); // Mettre à jour la session
            $this->dispatch('modeSwitched', $this->userMode); // Émet un événement pour les autres composants
        }
    }

    public function render()
    {
        return view('livewire.header-component');
    }
}

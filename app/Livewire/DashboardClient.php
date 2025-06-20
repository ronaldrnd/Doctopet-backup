<?php

namespace App\Livewire;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardClient extends Component
{

    public $proUnreadCount = 0;
    public $userMode;


    public function mount()
    {
        $this->proUnreadCount = $this->countProMessages();
        $this->userMode = session('user_mode', Auth::user()->type == 'S' ? 'pro' : 'client');
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


    /**
     * Compter les messages non lus provenant d'autres professionnels
     */
    public function countProMessages()
    {
        return Message::where('receiver_id', Auth::id())
            ->whereHas('sender', function($query) {
                $query->where('type', 'S'); // 'S' pour professionnels
            })
            ->where('is_read', false)
            ->distinct('sender_id')
            ->count('sender_id');
    }

    public function render()
    {
        return view('livewire.dashboard-client',
        [
            'proUnreadCount' => $this->proUnreadCount
        ]);
    }
}

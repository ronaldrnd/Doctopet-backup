<?php

namespace App\Livewire;

use App\Models\Message;
use App\Models\Appointment; // Import du modèle Appointment
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardPro extends Component
{
    public $clientUnreadCount = 0;
    public $proUnreadCount = 0;
    public $pendingAppointmentsCount = 0;  // Nouvelle variable pour les rendez-vous en attente

    public $userMode;

    public function mount()
    {
        $this->clientUnreadCount = $this->countClientMessages();
        $this->proUnreadCount = $this->countProMessages();
        $this->pendingAppointmentsCount = $this->countPendingAppointments();  // Initialisation des rendez-vous en attente

        if (Auth::user()->type == 'S')
            $this->userMode = 'pro';
        else
            $this->userMode = 'client';
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
     * Compter les messages non lus provenant des clients
     */
    public function countClientMessages()
    {
        return Message::where('receiver_id', Auth::id())
            ->whereHas('sender', function($query) {
                $query->where('type', 'C'); // 'C' pour clients
            })
            ->where('is_read', false)
            ->distinct('sender_id')
            ->count('sender_id');
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

    /**
     * Compter les rendez-vous en attente (pending)
     */
    public function countPendingAppointments()
    {
        // Mettre à jour les rendez-vous "pending" passés en "canceled"
        Appointment::where('assign_specialist_id', Auth::id())
            ->where('status', 'pending')
            ->where('date', '<', now()->format('Y-m-d')) // Vérifie la date du rendez-vous
            ->update(['status' => 'canceled']);

        // Retourner le nombre de rendez-vous "pending" dans le futur
        return Appointment::where('assign_specialist_id', Auth::id())
            ->where('status', 'pending')
            ->where('date', '>=', now()->format('Y-m-d')) // Ne prend que les RDV futurs
            ->count();
    }

    public function render()
    {
        return view('livewire.dashboard-pro', [
            'clientUnreadCount' => $this->clientUnreadCount,
            'proUnreadCount' => $this->proUnreadCount,
            'pendingAppointmentsCount' => $this->pendingAppointmentsCount  // Passage à la vue
        ]);
    }
}

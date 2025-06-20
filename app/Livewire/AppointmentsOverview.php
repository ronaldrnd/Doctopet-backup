<?php

namespace App\Livewire;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AppointmentsOverview extends Component
{
    public $upcomingAppointments = [];
    public $pastAppointments = [];

    public function mount()
    {
        $this->loadAppointments();
    }

    public function loadAppointments()
    {
        $userId = Auth::id();

        $this->upcomingAppointments = Appointment::where('user_id', $userId)
            ->where('date', '>=', now()->toDateString())
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $this->pastAppointments = Appointment::where('user_id', $userId)
            ->where('date', '<', now()->toDateString())
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->get();
    }

    public function render()
    {
        return view('livewire.appointments-overview');
    }
}

<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;
use App\Models\Appointment;
use Carbon\Carbon;

class SpecialistCalendar extends Component
{
    public $appointments;
    public $pastAppointments;
    public $selectedDate;

    public function mount()
    {
        $this->selectedDate = Carbon::today()->toDateString(); // Date actuelle
        $this->loadAppointments(); // Charge les rendez-vous
    }

    public function loadAppointments()
    {
        $userId = Auth::id();

        // Récupérer les rendez-vous futurs
        $this->appointments = Appointment::with(['animal', 'service'])
            ->whereDate('date', '>=', $this->selectedDate)
            ->where(function ($query) use ($userId) {
                $query->whereHas('service', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId);
                })->orWhere('assign_specialist_id', $userId);
            })
            ->orderBy('date')
            ->orderBy('start_time')
            ->get()
            ->groupBy('date')
            ->map(fn ($day) => $day->values());

        // Récupérer les rendez-vous passés
        $this->pastAppointments = Appointment::with(['animal', 'service'])
            ->whereDate('date', '<', $this->selectedDate)
            ->where(function ($query) use ($userId) {
                $query->whereHas('service', function ($subQuery) use ($userId) {
                    $subQuery->where('user_id', $userId);
                })->orWhere('assign_specialist_id', $userId);
            })
            ->orderByDesc('date')
            ->orderByDesc('start_time')
            ->get()
            ->groupBy('date')
            ->map(fn ($day) => $day->values());
    }

    public function updateStatus($appointmentId, $status)
    {
        $appointment = Appointment::findOrFail($appointmentId);
        $appointment->update(['status' => $status]);

        Mail::to($appointment->user->email)->send(new \App\Mail\AppointmentStatusUpdated($appointment));

        $this->loadAppointments();
    }

    public function viewAppointment($id)
    {
        return redirect()->route('appointments.show', $id);
    }

    public function render()
    {
        return view('livewire.specialist-calendar');
    }
}

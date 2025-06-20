<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class UpdateCompletedAppointments extends Command
{
    protected $signature = 'appointments:update-completed';
    protected $description = 'Met à jour le statut des rendez-vous terminés à "completed"';

    public function handle()
    {
        $now = Carbon::now(); // Date et heure actuelle

        // Trouver tous les rendez-vous confirmés dont l'heure de fin est dépassée
        $appointments = Appointment::where('status', 'confirmed')
            ->where(function ($query) use ($now) {
                $query->where('date', '<', $now->toDateString())
                    ->orWhere(function ($subQuery) use ($now) {
                        $subQuery->where('date', '=', $now->toDateString())
                            ->where('end_time', '<', $now->toTimeString());
                    });
            })
            ->get();

        $count = $appointments->count();

        if ($count > 0) {
            foreach ($appointments as $appointment) {
                $appointment->update(['status' => 'completed']);
            }

            $this->info("$count rendez-vous ont été mis à jour en 'completed'.");
        } else {
            $this->info("Aucun rendez-vous à mettre à jour.");
        }
    }
}

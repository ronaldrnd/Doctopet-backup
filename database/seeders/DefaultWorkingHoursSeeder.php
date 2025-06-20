<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultWorkingHoursSeeder extends Seeder
{
    public function run()
    {
        $defaultHours = [
            ['start_time' => '09:00:00', 'end_time' => '12:00:00'],
            ['start_time' => '13:00:00', 'end_time' => '17:00:00'],
        ];

        foreach (range(0, 6) as $day) { // Pour chaque jour de la semaine
            foreach ($defaultHours as $hours) {
                DB::table('working_hours')->insert([
                    'user_id' => 1, // Remplacez par l'utilisateur concerné lors de l'inscription
                    'day_of_week' => $day,
                    'start_time' => $hours['start_time'],
                    'end_time' => $hours['end_time'],
                ]);
            }
        }
    }
}


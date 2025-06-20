<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateReferralCodesSeeder extends Seeder
{
    public function run()
    {
        $users = DB::table('users')->whereNull('referral_code')->get();

        foreach ($users as $user) {
            do {
                $referralCode = Str::random(10);
                $codeExists = DB::table('users')->where('referral_code', $referralCode)->exists();
            } while ($codeExists); // Vérifie si le code existe déjà

            DB::table('users')
                ->where('id', $user->id)
                ->update(['referral_code' => $referralCode]);
        }

        $this->command->info('Codes de parrainage uniques mis à jour avec succès !');
    }
}

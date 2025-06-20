<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Spatie\Permission\Models\Role;

class AssignAdminRole extends Command
{
    protected $signature = 'assign:admin {email}';
    protected $description = 'Attribue le rôle Administrateur à un utilisateur avec son email';

    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Utilisateur non trouvé !");
            return;
        }

        // Vérifier si le rôle Administrateur existe sinon le créer
        if (!Role::where('name', 'Administrateur')->exists()) {
            Role::create(['name' => 'Administrateur']);
        }

        $user->assignRole('Administrateur');

        $this->info("Le rôle Administrateur a été attribué à {$user->name} !");
    }
}

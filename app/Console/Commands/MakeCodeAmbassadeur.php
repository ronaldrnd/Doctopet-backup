<?php

namespace App\Console\Commands;

use App\Services\AmbassadorService;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeCodeAmbassadeur extends Command
{
    protected $signature = 'make:code_amba {nombre}';
    protected $description = 'Créer des code ambassadeurs';

    public function handle()
    {
        $nombre = $this->argument('nombre');
        // boucle for sur nombre
        for ($i = 1; $i <= $nombre; $i++) {
            AmbassadorService::generateAccessCode();
        }
        $this->info($nombre . " code(s) Ambassadeur créé avec succès !");
    }
}

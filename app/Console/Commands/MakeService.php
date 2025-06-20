<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Créer un service Laravel dans app/Services';

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Services/{$name}.php");

        if (file_exists($path)) {
            $this->error("Le service {$name} existe déjà !");
            return;
        }

        (new Filesystem)->ensureDirectoryExists(app_path('Services'));

        $stub = <<<PHP
        <?php

        namespace App\Services;

        class {$name}
        {
            public function exampleMethod()
            {
                // TODO: Implémenter la logique du service
            }
        }
        PHP;

        file_put_contents($path, $stub);

        $this->info("Service {$name} créé avec succès !");
    }
}

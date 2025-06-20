<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\StockTriggerService;

class CheckStockLevels extends Command
{
    protected $signature = 'stock:check';
    protected $description = 'Vérifie les niveaux de stock et envoie des alertes si nécessaire';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(StockTriggerService $stockTriggerService)
    {
        $this->info('🔄 Vérification des stocks en cours...');

        $stockTriggerService->checkStockLevels();

        $this->info('✅ Vérification terminée.');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SmsReminderService;

class SendSmsReminders extends Command
{
    /**
     * Le nom et la signature de la commande console.
     *
     * @var string
     */
    protected $signature = 'sms:send-reminders';

    /**
     * La description de la commande.
     *
     * @var string
     */
    protected $description = "Envoie des rappels de rendez-vous par SMS aux utilisateurs 1h avant leur RDV.";

    /**
     * Exécute la commande.
     */
    public function handle()
    {
        $this->info('📢 Lancement de l\'envoi des rappels par SMS...');

        SmsReminderService::sendReminders();

        $this->info('✅ Tâche terminée : Les rappels ont été envoyés.');
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Subscription;

class UpdateUserSubscriptionStatus extends Command
{
    protected $signature = 'subscriptions:update';
    protected $description = 'Met à jour le statut is_subscribed des utilisateurs en fonction de leur abonnement';

    public function handle()
    {
        $this->info('Mise à jour des abonnements en cours...');

        // Récupère tous les utilisateurs ayant un abonnement actif
        $subscribedUsers = Subscription::where('stripe_status', 'active')
            ->pluck('user_id')
            ->toArray();

        // Met à jour les utilisateurs abonnés
        User::whereIn('id', $subscribedUsers)->update(['is_subscribed' => 1]);

        // Met à jour les utilisateurs qui n'ont pas d'abonnement actif
        User::whereNotIn('id', $subscribedUsers)->update(['is_subscribed' => 0]);

        $this->info('Mise à jour terminée !');
    }
}

<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Subscription;

class StripeStatistics extends Component
{
    public array $transactions = [];
    public $revenues = [];

    public function mount()
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Récupérer les transactions Stripe et convertir en tableau
        $charges = Charge::all()->jsonSerialize();

        // Stocker uniquement les informations nécessaires sous forme de tableau
        $this->transactions = array_map(function ($charge) {
            return [
                'id' => $charge['id'],
                'amount' => $charge['amount'] / 100, // Conversion en €
                'currency' => strtoupper($charge['currency']),
                'status' => $charge['status'],
                'date' => date('d/m/Y', $charge['created']),
                'customer_name' => $charge['billing_details']['name'] ?? 'Inconnu',
                'receipt_url' => $charge['receipt_url'] ?? null
            ];
        }, $charges['data']);
    }

    private function calculateMonthlyRevenue()
    {
        $monthlyRevenue = [];

        // Récupérer les paiements des utilisateurs
        foreach (User::all() as $user) {
            foreach ($user->invoices() as $invoice) {
                $month = $invoice->date()->format('Y-m');
                $monthlyRevenue[$month] = ($monthlyRevenue[$month] ?? 0) + floatval($invoice->total());
            }
        }

        return $monthlyRevenue;
    }

    public function render()
    {
        return view('livewire.admin.stripe-statistics');
    }
}

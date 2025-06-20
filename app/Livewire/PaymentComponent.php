<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PaymentComponent extends Component
{
    public $specialty;
    public $price;
    public $paymentMethodId;

    public $specialtyPrices = [
        "Vétérinaire" => 59.49,
        "Dentiste animalier" => 54.99,
        "Ostéopathe" => 49.99,
        "Physiothérapeute animalier" => 47.99,
        "Kinésiologue animalier" => 44.99,
        "Nutritionniste animalier" => 42.99,
        "Toiletteur" => 42.99,
        "Chenil" => 29.99,
        "Éleveur spécialisé" => 24.99,
        "Éducateur canin" => 22.99,
        "Pet Sitter" => 19.99,
    ];

    public function mount()
    {
        $this->specialty = key($this->specialtyPrices);
        $this->price = $this->specialtyPrices[$this->specialty] ?? 0;
    }

    public function updatedSpecialty()
    {
        $this->price = $this->specialtyPrices[$this->specialty] ?? 0;
    }

    public function processSubscription()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                session()->flash('error', 'Utilisateur non authentifié.');
                return;
            }

            // Récupérer l'ID Stripe du plan
            $priceId = config('services.stripe_prices.' . $this->specialty);

            if (!$priceId) {
                session()->flash('error', 'Spécialité non trouvée.');
                return;
            }

            // Création de l'abonnement
            $user->newSubscription('default', $priceId)
                ->create($this->paymentMethodId);

            session()->flash('success', 'Votre abonnement est actif ! 🎉');
            return redirect()->route('dashboard');

        } catch (\Exception $e) {
            Log::error('Erreur Stripe: ' . $e->getMessage());
            session()->flash('error', 'Erreur de paiement: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.payment-component');
    }
}

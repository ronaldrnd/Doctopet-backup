<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaiementController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Affiche le formulaire de paiement
     */
    public function showPaymentForm()
    {
        return view('paiement.view');
    }

    /**
     * Crée une intention d'abonnement avec Stripe et Laravel Cashier
     */
    public function createSubscriptionIntent(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $validated = $request->validate([
            'specialty' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        $priceId = config('services.stripe_prices.' . $validated['specialty']);

        if (!$priceId) {
            return response()->json(['error' => 'Spécialité non trouvée'], 400);
        }

        try {
            if (!$user->stripe_id) {
                $user->createAsStripeCustomer();
            }

            $user->addPaymentMethod($validated['payment_method']);
            $user->updateDefaultPaymentMethod($validated['payment_method']);

            $subscription = $user->newSubscription('default', $priceId)
                ->create($validated['payment_method']);

            return response()->json([
                'subscriptionId' => $subscription->id,
                'message' => 'Abonnement créé avec succès'
            ]);
        } catch (\Exception $e) {
            Log::error('Erreur Stripe: ' . $e->getMessage());
            return response()->json(['error' => 'Erreur Stripe : ' . $e->getMessage()], 500);
        }
    }

    /**
     * Affiche la page de succès du paiement
     */
    public function paymentSuccess()
    {
        return view('paiement.success');
    }

    /**
     * Affiche la page d'annulation du paiement
     */
    public function paymentCancel()
    {
        return view('paiement.cancel');
    }
}

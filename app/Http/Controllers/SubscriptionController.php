<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Cashier\Subscription;
use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Stripe\Stripe;

class SubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $user = auth()->user();

        // Vérifier si utilisateur ambassadeur (abonnement gratuit)
        if ($user->isAmbassador()) {
            $user->update([
                'is_subscribed' => true,
                'next_billing_date' => Carbon::now()->startOfMonth()->addMonth(),
            ]);
            return response()->json(['message' => 'Abonnement gratuit activé pour les ambassadeurs.']);
        }

        // Validation
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
            'payment_method' => 'required'
        ]);

        $plan = Plan::findOrFail($request->plan_id);

        // Stripe Setup
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($request->payment_method);

        // Définir le premier paiement au 1er du mois
        $nextBilling = Carbon::now()->startOfMonth()->addMonth();

        // Création de l'abonnement
        $subscription = $user->newSubscription('default', $plan->stripe_price_id)
            ->trialUntil($nextBilling)
            ->create($request->payment_method);

        // Mettre à jour l'utilisateur
        $user->update([
            'is_subscribed' => true,
            'stripe_subscription_id' => $subscription->id,
            'next_billing_date' => $nextBilling
        ]);

        return response()->json([
            'message' => 'Abonnement créé avec succès !',
            'subscription' => $subscription
        ]);
    }


    public function checkReferral(Request $request)
    {
        $referrer = User::where('referral_code', $request->code)->first();

        $user = Auth::user();

        if ($user->vouch_receiver_id) {
            session()->flash('error', 'Vous avez déjà utilisé un code de parrainage.');
            return response()->json(['success' => false,'message' => 'Vous ne pouvez pas utiliser un deuxième code de parrainage']);
        }

        if (!$referrer) {
            return response()->json(['success' => false, 'message' => 'Code invalide']);
        }

        $discount = $referrer->type === 'AMBASSADEUR' ? 20 : 10;

        Auth::user()->update(['vouch_receiver_id' => $referrer->id]);


        return response()->json(['success' => true, 'discount' => $discount]);
    }


    public function cancel()
    {
        $user = auth()->user();
        $subscription = $user->subscription('default');

        if ($subscription) {
            $subscription->cancel();
            $user->update(['is_subscribed' => false]);
            return response()->json(['message' => 'Abonnement annulé.']);
        }

        return response()->json(['message' => 'Aucun abonnement trouvé.'], 404);
    }

    public function index()
    {
        $user = auth()->user();
        $plans = \App\Models\Plan::all();
        $subscription = $user->subscription('default');

        return view('profil.settings', compact('user', 'plans', 'subscription'));
    }


}

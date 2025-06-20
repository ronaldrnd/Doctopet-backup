<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\StripeClient;

class PlanController extends Controller
{
    protected $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function index()
    {
        $plans = Plan::get();
        return view("plans", compact("plans"));
    }

    public function show(Plan $plan, Request $request)
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
        Stripe::setApiKey(config('services.stripe.secret'));

        $intent = auth()->user()->createSetupIntent();

        return view("subscription", compact("plan", "intent"));
    }

    public function subscription(Request $request)
    {
        $user = $request->user();
        $plan = Plan::find($request->plan);

        if (!$plan) {
            return response()->json(['error' => 'Plan non trouvé.'], 404);
        }

        if ($user->subscribed('default')) {
            return response()->json(['error' => '❌ Vous êtes déjà abonné à un plan.'], 400);
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));

        // Vérifier si l'utilisateur a un client Stripe, sinon en créer un
        if (!$user->stripe_id) {
            $stripeCustomer = \Stripe\Customer::create([
                'email' => $user->email,
                'name' => $user->name,
                'address' => [
                    'line1' => $request->billing_street,
                    'city' => $request->billing_city,
                    'postal_code' => $request->billing_postal_code,
                    'country' => 'FR',
                ]
            ]);
            $user->update(['stripe_id' => $stripeCustomer->id]);
        }

        // Mettre à jour l'adresse du client Stripe
        \Stripe\Customer::update($user->stripe_id, [
            'address' => [
                'line1' => $request->billing_street,
                'city' => $request->billing_city,
                'postal_code' => $request->billing_postal_code,
                'country' => 'FR',
            ]
        ]);

        // Récupérer le PaymentMethod ID envoyé depuis le formulaire JS
        $paymentMethodId = $request->input('payment_method');

        if (!$paymentMethodId) {
            return response()->json(['error' => '❌ Aucune méthode de paiement fournie.'], 400);
        }

        try {
            // 🔥 Attacher le PaymentMethod au client Stripe
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);
            $paymentMethod->attach(['customer' => $user->stripe_id]);

            // Définir la méthode de paiement par défaut
            \Stripe\Customer::update($user->stripe_id, [
                'invoice_settings' => ['default_payment_method' => $paymentMethodId]
            ]);

            // Vérifie si c'est un abonnement annuel
            $isAnnual = str_contains($plan->slug, 'annuel');
            $trialEnd = $isAnnual ? now()->addYear() : now()->addMonth();

            // Gestion des coupons
            $discount = intval($request->discount);
            $couponId = null;

            if ($discount > 0) {
                try {
                    $coupon = \Stripe\Coupon::create([
                        'amount_off' => $discount * 100,
                        'currency' => 'eur',
                        'duration' => 'once',
                        'name' => 'Réduction Parrainage'
                    ]);
                    $couponId = $coupon->id;
                } catch (\Exception $e) {
                    return response()->json(['error' => 'Erreur lors de la création du coupon : ' . $e->getMessage()], 400);
                }
            }

            // 🔥 Création de l'abonnement avec SCA et gestion de l'authentification
            $subscription = $user->newSubscription('default', $plan->stripe_plan)
                ->trialUntil($trialEnd)
                ->create($paymentMethodId, [
                    'metadata' => ['plan_id' => $plan->id],
                    'coupon' => $couponId ?? null,
                ]);

            // Récupération de la dernière facture (si elle existe)
            $latestInvoice = $subscription->latestInvoice();

            if ($latestInvoice && $latestInvoice->payment_intent) {
                $paymentIntent = \Stripe\PaymentIntent::retrieve($latestInvoice->payment_intent);

                if ($paymentIntent->status === 'requires_action' || $paymentIntent->status === 'requires_confirmation') {
                    return response()->json([
                        'requires_action' => true,
                        'payment_intent_client_secret' => $paymentIntent->client_secret
                    ]);
                }
            }



            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            return response()->json(['error' => '❌ Erreur Stripe : ' . $e->getMessage()], 400);
        }
    }


    public function cancelSubscription(Request $request)
    {
        $user = $request->user();

        // Vérifier si l'utilisateur a un abonnement actif
        if (!$user->subscribed('default')) {
            return redirect()->back()->with('error', '❌ Vous n’avez pas d’abonnement actif.');
        }

        try {
            // Récupérer l'abonnement Stripe
            $subscription = $user->subscription('default');

            if (!$subscription) {
                return redirect()->back()->with('error', '❌ Aucune souscription trouvée.');
            }

            // Vérifier si l'abonnement est déjà annulé ou terminé
            if ($subscription->ended() || $subscription->onGracePeriod()) {
                return redirect()->back()->with('error', '⚠️ Votre abonnement est déjà annulé.');
            }

            // Récupérer l'ID de l'abonnement Stripe
            $stripeSubscriptionId = $subscription->stripe_id;

            // Initialiser Stripe
            Stripe::setApiKey(config('services.stripe.secret'));

            // Annuler l'abonnement Stripe
            $stripeSubscription = \Stripe\Subscription::retrieve($stripeSubscriptionId);

            if ($stripeSubscription->status == 'canceled') {
                return redirect()->back()->with('error', '⚠️ Votre abonnement est déjà annulé.');
            }

            // Option 1 : Résiliation immédiate
            // $stripeSubscription->cancel_now();

            // Option 2 : Résiliation à la fin de la période actuelle
            $stripeSubscription->cancel();

            // Marquer l'abonnement comme annulé dans Laravel Cashier
            $subscription->markAsCanceled();

            return redirect()->back()->with('success', '✅ Votre abonnement a été résilié avec succès. Il prendra fin à la fin de la période en cours.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', '❌ Une erreur est survenue lors de l’annulation : ' . $e->getMessage());
        }
    }






}

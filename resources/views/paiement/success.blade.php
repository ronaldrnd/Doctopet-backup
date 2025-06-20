@include("includes.header")

@php
    $subscription = \Illuminate\Support\Facades\Auth::user()->subscriptions()
    ->where('stripe_status', 'active')
    ->orWhere('stripe_status','trialing')
    ->first();
    $plan = null;
    $isAnnual = false;

    if ($subscription) {
        $plan = \App\Models\Plan::where('stripe_plan', $subscription->stripe_price)->first();
        $isAnnual = str_contains($plan->slug, 'annuel'); // Détection automatique
    }
@endphp

<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-lg text-center">
        <!-- Icône de confirmation -->
        <div class="text-green-500 text-6xl mb-4">
            ✅
        </div>

        <!-- Message principal -->
        <h1 class="text-3xl font-bold text-gray-800 mb-2">
            🎉 Félicitations, {{ Auth::user()->name }} !
        </h1>
        <p class="text-lg text-gray-600">
            Votre abonnement "<span class="font-bold text-green-600">{{ $plan->name }}</span>" a été activé avec succès.
        </p>

        <!-- Détails de l'abonnement -->
        <div class="mt-6 p-4 bg-gray-100 rounded-md shadow-sm">
            <p class="text-gray-700 font-semibold">💳 Montant prélevé :

                @php
                    $planPrice = $plan->price / 100;
                    if (isset($discount)) {
                        $planPrice -= $discount;
                    }
                @endphp

                <span class="text-green-600 font-bold">
                    {{ number_format($planPrice, 2) }}€ / {{ $isAnnual ? 'an' : 'mois' }}
                </span>
            </p>

            @if ($isAnnual)
                <p class="text-green-600 font-bold text-sm mt-1">
                    🎉 Vous avez économisé 20% grâce à l'abonnement annuel !
                </p>
            @endif

            <p class="text-gray-700 mt-4">📅 Prochain renouvellement :
                <span class="font-bold">
                    {{ $isAnnual ? \Carbon\Carbon::now()->addYear()->format('d/m/Y') : \Carbon\Carbon::now()->addMonth()->format('d/m/Y') }}
                </span>
            </p>
        </div>

        <!-- Message de remerciement -->
        <p class="mt-6 text-lg font-semibold text-gray-800">
            Merci pour votre confiance ! 🐾 <br>
            Votre soutien nous aide à améliorer Doctopet.
        </p>

        <!-- Bouton retour tableau de bord -->
        <a href="{{ route('dashboard') }}" class="mt-6 inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold shadow-md transition-all">
            🏠 Retour au Tableau de Bord
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
<script>
    const count = 250, defaults = { origin: { y: 0.7 } };

    function fire(particleRatio, opts) {
        confetti(Object.assign({}, defaults, opts, {
            particleCount: Math.floor(count * particleRatio),
        }));
    }

    fire(0.25, { spread: 26, startVelocity: 55 });
    fire(0.2, { spread: 60 });
    fire(0.35, { spread: 100, decay: 0.91, scalar: 0.8 });
    fire(0.1, { spread: 120, startVelocity: 25, decay: 0.92, scalar: 1.2 });
    fire(0.1, { spread: 120, startVelocity: 45 });
</script>

@include("includes.footer")

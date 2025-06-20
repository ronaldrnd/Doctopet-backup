@include("includes.header")

<div class="container mx-auto px-4 py-12">


    @php
        $currentSubscription = auth()->user()->subscription('default'); // Vérifie s'il a un abonnement actif

        if ($currentSubscription) {
            $currentSubscription->plan = \App\Models\Plan::where("stripe_plan", $currentSubscription->stripe_price)->first();
            $stripeSubscription = $currentSubscription->asStripeSubscription();

            // Date de fin d'abonnement (si annulé, Stripe donne cette info)
            $cancellationDate = null;
            if ($stripeSubscription->cancel_at) {
                $cancellationDate = \Carbon\Carbon::createFromTimestamp($stripeSubscription->cancel_at);
            } elseif ($stripeSubscription->current_period_end) {
                // Si pas de date d’annulation explicite, prendre la fin de la période actuelle
                $cancellationDate = \Carbon\Carbon::createFromTimestamp($stripeSubscription->current_period_end);
            } else {
                // Fallback : Ajouter 1 mois à la date de début
                $cancellationDate = \Carbon\Carbon::parse($currentSubscription->created_at)->addMonth();
            }
        }
    @endphp

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative text-center">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative text-center">
            {{ session('error') }}
        </div>
    @endif

    <!-- Section abonnement en cours -->
    @if ($currentSubscription && $currentSubscription->valid())

        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-md shadow-md">
            <h2 class="text-2xl font-semibold mb-2">✅ Vous êtes abonné à l'abonnement {{ ucfirst($currentSubscription->plan->name) }} de Doctopet</h2>
            <p class="text-lg">
                💰 Prix :
                <strong>
                    {{ number_format($currentSubscription->plan->price / 100, 2) }}€
                    / {{ str_contains($currentSubscription->plan->slug, 'annuel') ? 'an' : 'mois' }}
                </strong>
            </p>

            @if ($currentSubscription->onGracePeriod())
                <p class="text-lg text-orange-700 font-bold">⚠️ Votre abonnement est annulé, il prendra fin le <strong>{{ $cancellationDate->format('d/m/Y') }}</strong>.</p>
            @else
                <p>📆 Prochaine facturation : <strong>{{ \Carbon\Carbon::createFromTimestamp($stripeSubscription->current_period_end)->format('d/m/Y') }}</strong></p>
            @endif

            <div class="mt-4 flex space-x-4">
                <a href="{{ route('subscription.index') }}" class="px-6 py-3 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 transition-all">
                    Gérer mon abonnement ⚙️
                </a>

                @if (!$currentSubscription->onGracePeriod())
                    <form action="{{ route('subscription.cancel') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-6 py-3 bg-red-500 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 transition-all">
                            Résilier ❌
                        </button>
                    </form>
                @else
                    <span class="px-6 py-3 bg-gray-400 text-white font-semibold rounded-lg shadow-md cursor-not-allowed">
                        Résiliation en attente...
                    </span>
                @endif
            </div>
        </div>
    @else
        <h1 class="text-4xl font-bold text-center mb-12 text-gray-800">🎉 Nos Abonnements</h1>

        <p class="text-center text-lg text-gray-600 mb-8">
            📅 <strong>Passez à l'abonnement annuel et économisez 20% !</strong> Profitez d’une année complète de services à prix réduit. 💰
        </p>


        <!-- 🔥 Switch Stylisé pour basculer entre mensuel et annuel -->
        <div class="flex justify-center mb-8">
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 font-semibold">💳 Mensuel</span>

                <!-- Switch -->
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" id="subscriptionToggle" class="sr-only peer">
                    <div class="w-16 h-8 bg-gray-300 rounded-full transition-all peer-checked:bg-yellow-500 relative">
                        <span id="btn-checkbox" class="absolute top-1 left-1 w-6 h-6 bg-white rounded-full shadow-md transform transition-all peer-checked:translate-x-8"></span>
                    </div>
                </label>

                <span class="text-yellow-600 font-semibold">🔥 Annuel (-20%)</span>
            </div>
        </div>


        <!-- 🔥 Cartes des abonnements -->
        <div id="subscriptionContainer" class="grid md:grid-cols-3 gap-8">
            @foreach($plans as $plan)
                <div class="subscription-card bg-white shadow-lg rounded-lg p-8 border border-gray-200 hover:shadow-2xl transition-all transform hover:scale-105"
                     data-type="{{ str_contains($plan->slug, 'annuel') ? 'annual' : 'monthly' }}">

                    <div class="text-center">
                        <h2 class="text-2xl font-semibold text-gray-700">{{ $plan->name }}</h2>
                        <p class="text-gray-500 text-sm mt-2">{{ $plan->description }}</p>

                        @if (str_contains($plan->slug, 'annuel'))
                            <h3 class="text-3xl font-bold text-yellow-600 mt-4">
                                {{ number_format($plan->price / 100, 2) }}€ / an
                            </h3>
                            <p class="text-sm text-green-600 font-bold animate-pulse">🔥 -20% d'économie !</p>
                        @else
                            <h3 class="text-3xl font-bold text-indigo-600 mt-4">
                                {{ number_format($plan->price / 100, 2) }}€ / mois
                            </h3>
                        @endif
                    </div>

                    <div class="mt-6 flex justify-center">
                        <a href="{{ route('plans.show', $plan->slug) }}"
                           class="px-6 py-3 font-semibold rounded-lg shadow-md transition-all text-white {{ str_contains($plan->slug, 'annuel') ? 'bg-yellow-500 hover:bg-yellow-700' : 'bg-indigo-500 hover:bg-indigo-700' }}">
                            Choisir 💳
                        </a>
                    </div>
                </div>
            @endforeach
        </div>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("subscriptionToggle");
        const btnCheckbox = document.getElementById("btn-checkbox"); // Récupère le rond blanc
        const cards = document.querySelectorAll(".subscription-card");

        function updateSubscriptions() {
            const showAnnual = toggle.checked;

            // Déplacement fluide du rond blanc à droite/gauche
            if (showAnnual) {
                btnCheckbox.style.transform = "translateX(32px)"; // Déplace à droite
            } else {
                btnCheckbox.style.transform = "translateX(0px)"; // Revient à gauche
            }

            // Affichage des abonnements selon le type sélectionné
            cards.forEach(card => {
                if ((showAnnual && card.dataset.type === "annual") || (!showAnnual && card.dataset.type === "monthly")) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        }

        // Initialisation : affiche les abonnements annuels par défaut
        toggle.checked = true;
        updateSubscriptions();

        // Écouteur d'événement pour le toggle
        toggle.addEventListener("change", updateSubscriptions);
    });


</script>

</div>

@endif

@include("includes.footer")

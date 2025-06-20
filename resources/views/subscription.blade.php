@include("includes.header")

<div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg border border-gray-200 mt-12">
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">💳 Abonnement à {{ $plan->name }}</h2>

    <!-- 🔥 Texte de réduction si l'abonnement est annuel -->
    @if (str_contains($plan->slug, 'annuel'))
        <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4 rounded-md text-center">
            <p class="font-semibold">🔥 Offre spéciale ! Économisez <strong>20%</strong> en choisissant l’abonnement annuel.</p>
        </div>
    @endif

    <p class="text-center text-gray-600 text-lg mb-6">
        Prix : <span class="font-semibold text-indigo-600" id="display-price">
            {{ number_format($plan->price / 100, 2) }}€ /
            <span id="billing-type">{{ str_contains($plan->slug, 'annuel') ? 'an' : 'mois' }}</span>
        </span>
    </p>

    <form action="{{ route('subscription.create') }}" method="POST" id="payment-form" class="space-y-6">
        @csrf
        <input type="hidden" name="plan" value="{{ $plan->id }}">
        <input type="hidden" name="discount" id="discount-amount" value="0">

        <div>
            <label class="block text-gray-700 font-semibold">👤 Nom sur la carte :</label>
            <input type="text" name="name" id="card-holder-name" class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" required>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">💳 Informations de Carte :</label>
            <div id="card-element" class="p-4 border rounded-lg shadow-sm bg-gray-100"></div>
            <p id="card-errors" class="text-red-500 text-sm mt-2 hidden"></p>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold">🏠 Adresse de facturation :</label>
            <input type="text" name="billing_street" id="billing-street" class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" required placeholder="Numéro et Rue">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-semibold">🏙️ Ville :</label>
                <input type="text" name="billing_city" id="billing-city" class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" required placeholder="Ville">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold">📮 Code Postal :</label>
                <input type="text" name="billing_postal_code" id="billing-postal-code" class="w-full mt-2 p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-indigo-400 focus:outline-none" required placeholder="Code Postal">
            </div>
        </div>

        <!-- Code de réduction -->
        <div>
            <label class="block text-gray-700 font-semibold">🎟️ Code de réduction</label>
            <input type="text" id="referral-code" class="w-full p-3 border rounded" placeholder="Entrez un code">
            <button type="button" id="apply-referral"
                    class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                ➕ Appliquer le code
            </button>
            <p id="discount-message" class="text-green-600 text-sm mt-2 hidden"></p>
        </div>

        <button type="submit" class="w-full bg-green-500 text-white font-bold p-3 rounded-lg hover:bg-green-700 transition-all">
            🔒 S'abonner
        </button>

        <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md mt-4">
            <p class="text-sm italic">
                5% de votre abonnement sera reversé à une association choisie par Doctopet.
            </p>
        </div>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let stripe = Stripe("{{ config('services.stripe.key') }}");
        let elements = stripe.elements();
        let card = elements.create('card');
        card.mount('#card-element');

        let form = document.querySelector('#payment-form');
        let cardErrors = document.getElementById('card-errors');
        let referralInput = document.getElementById('referral-code');
        let applyReferralButton = document.getElementById('apply-referral');
        let discountMessage = document.getElementById('discount-message');
        let discountAmount = document.getElementById('discount-amount');
        let billingType = document.getElementById('billing-type');
        let priceDisplay = document.getElementById('display-price');

        let originalPrice = {{ $plan->price / 100 }};
        let finalPrice = originalPrice;

        // 🎟️ **Application du code de réduction**
        applyReferralButton.addEventListener('click', function () {
            let code = referralInput.value.trim();
            if (code === '') return;

            fetch("{{ route('check.referral') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ code: code })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        finalPrice = Math.max(0, originalPrice - data.discount);
                        priceDisplay.innerHTML = finalPrice.toFixed(2) + "€ / " + billingType.textContent;
                        discountAmount.value = data.discount;
                        discountMessage.textContent = "Réduction appliquée : -" + data.discount + "€";
                        discountMessage.classList.remove("hidden");
                    } else {
                        discountMessage.textContent = "Code invalide.";
                        discountMessage.classList.remove("hidden");
                        discountMessage.classList.add("text-red-600");
                    }
                });
        });

        // 💳 **Gestion du paiement avec 3D Secure (SCA)**
        form.addEventListener('submit', async function (event) {
            event.preventDefault();
            console.log("j'envoie !")

            let billingStreet = document.getElementById('billing-street').value;
            let billingCity = document.getElementById('billing-city').value;
            let billingPostalCode = document.getElementById('billing-postal-code').value;

            // ✅ **Créer un PaymentMethod**
            const { paymentMethod, error } = await stripe.createPaymentMethod({
                type: 'card',
                card: card,
                billing_details: {
                    name: document.getElementById('card-holder-name').value,
                    address: {
                        line1: billingStreet,
                        city: billingCity,
                        postal_code: billingPostalCode,
                        country: 'FR'
                    }
                }
            });

            if (error) {
                console.log("error")
                cardErrors.textContent = error.message;
                cardErrors.classList.remove("hidden");
                return;
            }

            // 🔥 Envoi du PaymentMethod au backend
            const response = await fetch("{{ route('subscription.create') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    plan: "{{ $plan->id }}",
                    payment_method: paymentMethod.id,
                    discount: discountAmount.value
                })
            });


            const result = await response.json();

            if (result.error) {
                cardErrors.textContent = result.error;
                cardErrors.classList.remove("hidden");
            } else if (result.requires_action) {
                // 🔥 Authentification 3D Secure nécessaire
                const { paymentIntent, error: confirmError } = await stripe.confirmCardPayment(
                    result.payment_intent_client_secret
                );

                if (confirmError) {
                    cardErrors.textContent = confirmError.message;
                    cardErrors.classList.remove("hidden");
                } else {
                    window.location.href = "{{ route('payment.success') }}"; // ✅ Redirection après succès
                }
            } else {
                window.location.href = "{{ route('payment.success') }}"; // ✅ Redirection après succès
            }
        });
    });

</script>


@include("includes.footer")

<div class="max-w-4xl mx-auto p-6 bg-gray-100 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-6">💳 Paiement de votre abonnement</h2>

    <form id="subscription-form">
        @csrf
        <!-- 📜 Sélection de la spécialité -->
        <div class="mb-4">
            <label class="font-semibold">Sélectionnez votre spécialité :</label>
            <select id="specialty" class="w-full p-3 border rounded">
                @foreach($specialtyPrices as $specialty => $price)
                    <option value="{{ $specialty }}" data-price="{{ $price }}">
                        {{ $specialty }} - {{ number_format($price, 2) }}€ / mois
                    </option>
                @endforeach
            </select>
        </div>

        <!-- 📩 Informations utilisateur -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">Nom :</label>
                <input type="text" id="name" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="font-semibold">Email :</label>
                <input type="email" id="email" class="w-full p-2 border rounded" required>
            </div>
        </div>

        <div class="grid grid-cols-3 gap-4 mt-4">
            <div>
                <label class="font-semibold">Adresse :</label>
                <input type="text" id="address" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="font-semibold">Code Postal :</label>
                <input type="text" id="postal_code" class="w-full p-2 border rounded" required>
            </div>
            <div>
                <label class="font-semibold">Ville :</label>
                <input type="text" id="city" class="w-full p-2 border rounded" required>
            </div>
        </div>

        <div class="mt-4">
            <label class="font-semibold">Pays :</label>
            <select id="country" class="w-full p-3 border rounded">
                <option value="FR">France</option>
            </select>
        </div>

        <div class="mt-4">
            <label class="font-semibold">Téléphone :</label>
            <input type="text" id="phone" class="w-full p-2 border rounded" required>
        </div>

        <!-- 💳 Paiement Stripe -->
        <div class="mt-6">
            <h3 class="font-bold text-lg mb-3">💳 Informations de Paiement</h3>
            <div class="bg-gray-100 p-5 rounded-lg shadow-md space-y-4">
                <div id="card-element" class="p-3 border rounded bg-white"></div>
            </div>
            <p id="card-errors" class="text-red-500 text-sm mt-2 hidden"></p>
        </div>

        <button type="submit" class="mt-6 w-full bg-green-500 text-white p-3 rounded hover:bg-green-600 transition-all">
            🔒 S'abonner pour {{ number_format($price, 2) }}€ / mois
        </button>
    </form>

    <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md mt-4">
        <p class="text-sm italic">
            5% de votre abonnement sera reversé à une association choisie par Doctopet.
        </p>
    </div>

    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let stripe = Stripe("{{ config('services.stripe.key') }}");
            let elements = stripe.elements();
            let card = elements.create('card');
            card.mount('#card-element');

            let form = document.querySelector('#subscription-form');
            let cardErrors = document.getElementById('card-errors');

            form.addEventListener('submit', async function(event) {
                event.preventDefault();

                // Création du PaymentMethod
                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                });

                if (error) {
                    cardErrors.textContent = error.message;
                    cardErrors.classList.remove('hidden');
                } else {
                    // Passer le paymentMethod.id à Livewire
                @this.set('paymentMethodId', paymentMethod.id);
                @this.processSubscription();
                }
            });
        });
    </script>

</div>

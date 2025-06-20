    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des stocks | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>
<body>
@include("includes.header")
<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Gérer votre abonnement</h2>

        <div class="mb-4">
            <h3 class="font-semibold">Plan actuel :</h3>
            <p>{{ auth()->user()->subscription('default') ? auth()->user()->subscription('default')->stripe_price : 'Aucun abonnement' }}</p>
        </div>

        @if(auth()->user()->hasActiveSubscription())
            <form method="POST" action="{{ route('subscription.cancel') }}">
                @csrf
                <button class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">Annuler l'abonnement</button>
            </form>
        @else
            <h3 class="font-semibold mt-6">Souscrire à un abonnement</h3>
            <form method="POST" action="{{ route('subscription.subscribe') }}">
                @csrf
                <select name="plan_id" class="w-full p-3 border rounded">
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}">{{ $plan->name }} - {{ $plan->price }}€</option>
                    @endforeach
                </select>
                <input type="text" name="payment_method" placeholder="ID Stripe de la carte" class="w-full p-2 border rounded mt-2">
                <button class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-2">Souscrire</button>
            </form>
        @endif
    </div>
</body>

@include("includes.footer")
</html>

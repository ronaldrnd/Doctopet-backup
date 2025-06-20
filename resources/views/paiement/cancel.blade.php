@include("includes.header")

    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement refusé | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>
<body>

<div class="max-w-lg mx-auto p-6 bg-white shadow-md rounded-lg text-center">
    <h2 class="text-2xl font-bold text-red-600">❌ Paiement annulé</h2>
    <p class="mt-4">Votre paiement n’a pas été complété. Vous pouvez réessayer à tout moment.</p>
    <a href="{{ route('paiement') }}" class="mt-6 inline-block px-6 py-3 bg-blue-500 text-white rounded-lg">
        Revenir au paiement
    </a>
</div>

</body>
@include("includes.footer")
</html>

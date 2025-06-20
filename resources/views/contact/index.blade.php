@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coopération | {{ env("APP_NAME") }}</title>
    @vite('resources/css/app.css')
</head>

<body>

<div class="flex">
    <livewire:dashboard-component />



    <div class="min-h-screen bg-gray-100 p-8 ml-auto mr-auto">
        <div class="bg-white shadow-lg rounded-lg p-6 max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-green-700 mb-6">À propos de Doctopet</h1>

            <!-- Nom de l'entreprise -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Nom de l'entreprise :</h2>
                <p class="text-gray-600">Doctopet</p>
            </div>

            <!-- Adresse -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Adresse du siège social :</h2>
                <p class="text-gray-600">Adresse inconnue</p>
            </div>

            <!-- Représentant -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Nom du représentant :</h2>
                <p class="text-gray-600">Sasha BIRD</p>
            </div>

            <!-- LinkedIn -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Profil LinkedIn :</h2>
                <a href="https://www.linkedin.com/in/sasha-bird-1b3b4b258/" target="_blank" class="text-blue-500 underline">
                    Voir le profil LinkedIn
                </a>
            </div>

            <!-- Téléphone -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Numéro de téléphone (urgence) :</h2>
                <p class="text-gray-600">07 83 74 38 08</p>
            </div>

            <!-- Email contact -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Adresse e-mail :</h2>
                <p class="text-gray-600">contact@doctopet.fr</p>
            </div>

            <!-- Maintenance -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Correction de bugs & maintenance :</h2>
                <p class="text-gray-600">hugo.jacquel@atomixia.fr</p>
            </div>

            <!-- Société maintenance -->
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Société de maintenance :</h2>
                <a href="https://atomixia.fr" target="_blank" class="text-blue-500 underline">
                    Atomixia
                </a>
                <p class="text-gray-600">Représentant : Hugo JACQUEL</p>
            </div>
        </div>
    </div>

</div>
@include("includes.footer")
</body>
</html>

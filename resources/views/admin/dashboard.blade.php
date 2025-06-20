<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Admin | {{ env("APP_NAME") }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex">




@include("admin.menu")
<!-- Contenu principal -->
<div class="flex-1">

    <!-- 🌍 Header -->
    <header class="bg-white shadow-md p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold text-gray-700">🚀 Administration DoctoPet</h1>
        <a href="{{ route('home') }}" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">
            🔙 Retour Site
        </a>
    </header>

    <!-- 🔥 Contenu Dynamique -->
    <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">

        <!-- 🛠️ Gestion Utilisateurs -->
        <a href="{{ route('admin.users') }}" class="group bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 cursor-pointer flex flex-col items-center">
            <svg class="w-16 h-16 text-green-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A9 9 0 1118.88 5.12M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <h3 class="text-xl font-bold mt-4 text-gray-800 group-hover:text-green-600 transition">Gestion Utilisateurs</h3>
            <p class="text-gray-500 text-sm text-center mt-2">Valider les comptes, gérer les accès et suivre l'activité.</p>
        </a>

        <!-- 📜 Logs Système -->
        <a href="{{ route('admin.logs') }}" class="group bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 cursor-pointer flex flex-col items-center">
            <svg class="w-16 h-16 text-blue-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M4 4h16v16H4z" />
            </svg>
            <h3 class="text-xl font-bold mt-4 text-gray-800 group-hover:text-blue-600 transition">Logs Système</h3>
            <p class="text-gray-500 text-sm text-center mt-2">Surveille les actions et événements en temps réel.</p>
        </a>

        <!-- 🚨 Signalements & Warnings -->
        <a href="{{ route('admin.reports') }}" class="group bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 cursor-pointer flex flex-col items-center">
            <svg class="w-16 h-16 text-red-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636a9 9 0 11-12.728 12.728M12 3v9l3 3" />
            </svg>
            <h3 class="text-xl font-bold mt-4 text-gray-800 group-hover:text-red-600 transition">Signalements & Warnings</h3>
            <p class="text-gray-500 text-sm text-center mt-2">Gère les signalements et sanctions des utilisateurs.</p>
        </a>

        <!-- 🎖️ Accès Ambassadeur -->
        <a href="{{ route('admin.ambassadors') }}" class="group bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 cursor-pointer flex flex-col items-center">
            <svg class="w-16 h-16 text-yellow-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M9 3v4m6-4v4M3 21h18M5 17h14M5 13h14M5 9h14" />
            </svg>
            <h3 class="text-xl font-bold mt-4 text-gray-800 group-hover:text-yellow-600 transition">Accès Ambassadeur</h3>
            <p class="text-gray-500 text-sm text-center mt-2">Crée et gère les accès spéciaux des ambassadeurs.</p>
        </a>


        <!-- 🎖️ Accès Ambassadeur -->
        <a href="{{ route('admin.cabinets') }}" class="group bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 cursor-pointer flex flex-col items-center">
            <svg class="w-16 h-16 text-yellow-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M9 3v4m6-4v4M3 21h18M5 17h14M5 13h14M5 9h14" />
            </svg>
            <h3 class="text-xl font-bold mt-4 text-gray-800 group-hover:text-yellow-600 transition">Gérer les cabinets</h3>
            <p class="text-gray-500 text-sm text-center mt-2">Gérer les cabinets.</p>
        </a>

        <!-- 🎖️ Accès Ambassadeur -->
        <a href="{{ route('admin.user_map') }}" class="group bg-white p-6 rounded-lg shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 cursor-pointer flex flex-col items-center">
            <svg class="w-16 h-16 text-yellow-500 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M9 3v4m6-4v4M3 21h18M5 17h14M5 13h14M5 9h14" />
            </svg>
            <h3 class="text-xl font-bold mt-4 text-gray-800 group-hover:text-yellow-600 transition">Carte utilisateurs</h3>
            <p class="text-gray-500 text-sm text-center mt-2">Carte utilisateurs</p>
        </a>






    </div>

</div>

</body>
</html>

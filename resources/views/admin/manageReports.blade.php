<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les reports (Panel Admin) | {{ env("APP_NAME") }}</title>
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
    <div class="p-6">
        @livewire('admin.manage-reports')
    </div>
</div>

</body>
</html>

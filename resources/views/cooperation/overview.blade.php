@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coopération | {{ env("APP_NAME") }}</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 ">
<!-- Sidebar (Dashboard) -->
<div class="flex">


<livewire:dashboard-component />

<div class="flex-1 p-6" >
    <h1 class="text-3xl font-bold text-green-700 mb-6  items-center">
        🤝 Espace de Coopération
    </h1>

    <div class="gap-6">
        <!-- Module Messagerie Pro -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <livewire:chat-with-professionals />
        </div>

        <!-- Module Transfert de Rendez-vous -->
        <div class="bg-white shadow-lg rounded-lg p-6">
            <livewire:transfer-rdv />
        </div>
    </div>
</div>


</div>
</body>

@include("includes.footer")
</html>

@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des professionel par spécialité | {{env("APP_NAME")}}</title>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" type="module" defer></script>
    -->
    @vite('resources/css/app.css')
</head>
<body>
<div class="flex">
    <livewire:dashboard-component />
    <div class="w-fill-available bg-gradient-to-br from-gray-100 to-gray-300 p-10">
        <h1 class="text-3xl font-bold text-center text-green-700 mb-10">Liste des Spécialités</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($specialities as $speciality)
                <div class="bg-white rounded-lg shadow-md p-5 hover:shadow-lg transition">
                    <div class="flex flex-col items-center">
                        <!-- Image de la spécialité -->
                        <img src="{{ asset('img/specialities/' . $speciality->id . '.jpg') }}"
                             alt="Image de la spécialité {{ $speciality->nom }}"
                             class="w-32 h-32 rounded-full object-cover mb-4">

                        <!-- Nom de la spécialité -->
                        <h2 class="text-xl font-bold text-gray-800 text-center mb-2">
                            {{ $speciality->nom }}
                        </h2>

                        <!-- Description -->
                        <p class="text-gray-600 text-sm text-center mb-4">
                            {{ $speciality->description ?? 'Description non disponible.' }}
                        </p>

                        <!-- Bouton voir plus -->
                        <a href="{{ route('specialities.index', $speciality->id) }}"
                           class="bg-green-600 text-white px-4 py-2 rounded-md text-sm font-bold hover:bg-green-700 transition">
                            Voir les professionnels
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
</body>

@include("includes.footer")
</html>

<div class="min-h-screen bg-gray-100 p-10">
    <h1 class="text-4xl font-bold text-green-700 mb-10">Gérer vos Rendez-vous</h1>

    <!-- Barre de recherche -->
    <div class="relative mb-8 flex items-center w-full">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Recherchez une prestation (ex : Manucure, Vaccination...)"
            class="flex-grow p-4 border border-gray-300 rounded-l-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500"
        />
        <div class="bg-green-500 flex items-center justify-center p-4 rounded-r-lg">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </div>
    </div>

    <!-- Slider pour la distance -->
    <div class="mb-8">
        <label class="block text-gray-700 font-bold mb-2">Distance maximale (km) : {{ $maxDistance }}</label>
        <input
            type="range"
            wire:model.live="maxDistance"
            min="1"
            max="50"
            class="w-full"
        />
    </div>

    <!-- Conteneur principal en flex -->
    <div class="flex gap-6">
        <!-- Résultats de recherche -->
        <div class="flex-1 space-y-6 overflow-y-auto max-h-screen">
            @if($services->isEmpty() && $search)
                <p class="text-gray-500 text-center">Aucun résultat trouvé pour "{{ $search }}".</p>
            @elseif(!$services->isEmpty())
                @foreach($services as $service)
                    <a href="/rdv/create/{{ $service->id }}" class="block bg-white shadow-md rounded-lg p-6 hover:shadow-xl transition-shadow duration-300">
                        <h3 class="text-xl font-bold text-green-700">{{ $service->name }}</h3>
                        <p class="text-gray-600">
                            <strong>Vétérinaire :</strong> {{ $service->user->name }}
                        </p>
                        <p class="text-gray-600">
                            <strong>Adresse :</strong> {{ $service->user->address }}
                        </p>
                        <p class="text-gray-600">
                            <strong>Prix :</strong> {{ $service->price }} €
                        </p>
                        <p class="text-gray-600">
                            <strong>Durée :</strong> {{ $service->duration }} minutes
                        </p>
                    </a>
                @endforeach
            @else
                <p class="text-gray-500">Chargement des services...</p>
            @endif
        </div>

        <!-- Carte de géolocalisation -->
        <div class="flex-1">
            @if($latitude && $longitude)
                <iframe
                    class="w-full h-[600px] rounded-lg shadow-md"
                    frameborder="0"
                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $longitude - 0.05 }},{{ $latitude - 0.05 }},{{ $longitude + 0.05 }},{{ $latitude + 0.05 }}&layer=mapnik&marker={{ $latitude }},{{ $longitude }}">
                </iframe>
            @else
                <p class="text-gray-500 text-center">Impossible de charger la carte. Aucune position disponible.</p>
            @endif
        </div>
    </div>

</div>

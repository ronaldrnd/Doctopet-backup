<div class="max-w-4xl mx-auto p-8 bg-white shadow-lg rounded-lg border border-gray-200 mt-12">
    <h2 class="text-3xl font-bold text-center text-green-700 mb-6">📅 Prendre Rendez-vous</h2>

    <p class="text-center text-gray-600 text-lg mb-6">
        Service : <span class="font-semibold text-indigo-600">{{ $service->name }}</span>
    </p>

    <!-- Détails du Service -->
    <div class="bg-gray-100 p-4 rounded-lg mb-6">
        <h3 class="text-lg font-semibold text-gray-700">🔍 Détails du Service</h3>
        <p class="text-gray-600"><strong>🧑‍⚕️ Consultant :</strong> {{ $provider->name }}</p>
        <p class="text-gray-600"><strong>📍 Adresse :</strong> {{ $provider->address ?? 'Non renseignée' }}</p>
        <p class="text-gray-600"><strong>📞 Téléphone :</strong> {{ $provider->phone_number ?? 'Non renseigné' }}</p>
        <p class="text-gray-600"><strong>⏳ Durée :</strong> {{ $service->duration }} minutes</p>
        <p class="text-gray-600"><strong>💰 Prix :</strong> <span class="font-bold text-green-600">{{ number_format($service->price, 2) }} €</span></p>
        <p class="text-gray-600 mt-3"><strong>📜 Description :</strong> {{ $service->description }}</p>
    </div>

    <!-- Sélection de l'animal -->
    <div class="mb-6">
        <label class="block text-gray-700 font-semibold mb-2">🐾 Sélectionnez votre animal :</label>
        <select wire:model.live="selectedAnimal" class="w-full border p-3 rounded-lg">
            <option value="">Sélectionnez un animal</option>
            @foreach($userAnimals as $animal)
                <option value="{{ $animal->id }}">{{ $animal->espece->emoji }} - {{ $animal->nom }}</option>
            @endforeach
        </select>
    </div>

    <!-- Module calendrier affiché seulement si un animal est sélectionné -->
    @if($selectedAnimal)
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-green-700 mb-4">📅 Disponibilités</h3>
            @livewire('calendar-availability', [
            'service_id' => $service->id,
            'animalID' => $selectedAnimal,
            'specializedServiceId' => null
            ])
        </div>
    @else
        <p class="text-gray-500 text-center">Veuillez sélectionner un animal pour voir les disponibilités.</p>
    @endif
</div>

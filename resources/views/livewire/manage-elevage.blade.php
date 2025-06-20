<div class="p-6 bg-gray-100 shadow-md rounded-lg w-fill-available mx-auto">
    <h2 class="text-3xl font-bold text-green-700 mb-6">🐶✨ Gérer votre Élevage</h2>

    <!-- ✅ Formulaire d'ajout d'un nouvel animal -->
    <div class="mb-6 bg-gray-100 p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">➕ Ajouter une nouvelle portée</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4" x-data="{ races: @js($races) }">
            <select wire:model="especeId"
                    x-on:change="$wire.call('updateRaces', $event.target.value)"
                    class="w-full p-2 border rounded bg-white">
                <option value="">🐾 Sélectionnez une espèce</option>
                @foreach($especes as $espece)
                    <option value="{{ $espece->id }}">{{ $espece->nom }}</option>
                @endforeach
            </select>

            <select wire:model="raceId"
                    class="w-full p-2 border rounded bg-white">
                <option value="">🐕 Sélectionnez une race</option>
                @foreach($races as $race)
                    <option value="{{ $race->id }}">{{ $race->nom }}</option>
                @endforeach
            </select>

            <input type="number" wire:model="age" placeholder="📅 Âge (mois)" class="p-2 border rounded bg-white">
            <input type="text" wire:model="taille" placeholder="📏 Taille (cm)" class="p-2 border rounded bg-white">
            <input type="number" wire:model="stock" placeholder="🐕 Nombre" class="p-2 border rounded bg-white">
        </div>

        <button wire:click="addAnimal"
                class="mt-4 px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition duration-300">
            ✅ Ajouter
        </button>
    </div>

    <!-- ✅ Liste des animaux en élevage -->
    <div class="overflow-x-auto bg-gray-50 p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">📋 Votre Élevage d'animaux</h3>
        <table class="w-full border-collapse">
            <thead>
            <tr class="bg-green-500 text-white">
                <th class="p-2">🐾 Espèce</th>
                <th class="p-2">🐕 Race</th>
                <th class="p-2">📅 Âge</th>
                <th class="p-2">📏 Taille</th>
                <th class="p-2">🐕 Nombre</th>
                <th class="p-2">⚡ Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($elevages as $elevage)
                <tr class="border-b hover:bg-gray-100 transition">
                    <td class="p-2 font-medium">{{ $elevage->espece->nom }}</td>
                    <td class="p-2">{{ $elevage->race->nom ?? '❌ Non renseigné' }}</td>
                    <td class="p-2">{{ $elevage->age }} mois</td>
                    <td class="p-2">{{ $elevage->taille }} cm</td>
                    <td class="p-2 font-bold text-center text-green-600">{{ $elevage->stock }}</td>
                    <td class="p-2 text-center">
                        <button wire:click="decreaseStock({{ $elevage->id }})"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition duration-300">
                            Supprimer 1
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- ✅ Formulaire de contact avec les admins -->
    <div class="mt-6 bg-gray-100 p-4 rounded-lg shadow-md">
        <h3 class="text-lg font-semibold text-gray-700 mb-2">✉️ Contacter les Administrateurs</h3>
        <input type="text" wire:model="title" class="w-full p-2 border rounded mb-2" placeholder="📌 Titre du message">
        <textarea wire:model="message"
                  class="w-full p-2 border rounded"
                  placeholder="📝 Écrivez votre message ici..."></textarea>
        <button wire:click="sendMessage"
                class="mt-2 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition duration-300">
            📩 Envoyer
        </button>
        @if(session()->has('success'))
            <p class="text-green-600 mt-2">{{ session('success') }}</p>
        @endif
    </div>
</div>

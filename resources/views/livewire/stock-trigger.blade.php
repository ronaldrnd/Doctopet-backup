<div class="w-full mx-auto p-6 bg-gray-100 shadow-lg rounded-lg mt-10">
    <h2 class="text-3xl font-bold text-center mb-6 text-green-700">📊 Gestion des Seuils de Stock</h2>

    <!-- 🔍 Recherche -->
    <div class="mb-6">
        <input type="text" wire:model="search" placeholder="🔍 Rechercher un actif..."
               class="w-full p-3 border rounded-md shadow focus:ring-2 focus:ring-green-500">
    </div>

    <!-- 📜 Liste des seuils de stock -->
    <div class="bg-gray-50 p-4 rounded-lg shadow-md overflow-auto">
        <table class="w-full border-collapse text-sm md:text-base">
            <thead>
            <tr class="bg-green-600 text-white text-left">
                <th class="p-3">💊 Actif</th>
                <th class="p-3 text-center">📦 Seuil Min</th>
                <th class="p-3 text-center">📦 Montant</th>
                <th class="p-3 hidden md:table-cell">🏢 Fournisseur</th>
                <th class="p-3 text-center">🔔 Alerte</th>
                <th class="p-3 text-center">⚙️ Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($triggers as $trigger)
                <tr class="border-b hover:bg-gray-100">
                    <td class="p-3 font-semibold">{{ $trigger->actif->nom }}</td>
                    <td class="p-3 text-center">{{ $trigger->montant }}</td>
                    <td class="p-3 text-center">{{ $trigger->ask_montant }}</td>
                    <td class="p-3 hidden md:table-cell">{{ $trigger->fournisseur->nom }}</td>
                    <td class="p-3 text-center">
                        @if ($trigger->actif->stock <= $trigger->seuil)
                            <span class="px-3 py-1 bg-red-500 text-white rounded-full">🛑 Stock Bas</span>
                        @else
                            <span class="px-3 py-1 bg-green-500 text-white rounded-full">✅ OK</span>
                        @endif
                    </td>
                    <td class="p-3 flex flex-col md:flex-row gap-2 justify-center">
                        <button wire:click="edit({{ $trigger->id }})"
                                class="px-3 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition-all">
                            ✏️ Modifier
                        </button>
                        <button wire:click="delete({{ $trigger->id }})"
                                class="px-3 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition-all">
                            🗑️ Supprimer
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        @if ($triggers->isEmpty())
            <p class="text-center text-gray-500 mt-4">Aucun seuil défini.</p>
        @endif
    </div>

    <!-- ➕ Formulaire Ajout Seuil -->
    <div class="mt-8 p-6 bg-white rounded-lg shadow-lg">
        <h3 class="text-xl font-semibold text-green-700 mb-4">➕ Définir un seuil</h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">💊 Actif :</label>
                <select wire:model="selectedActif" class="w-full p-3 border rounded-md shadow">
                    <option value="">🔍 Sélectionner un actif</option>
                    @foreach ($actifs as $actif)
                        <option value="{{ $actif->id }}">{{ $actif->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-semibold">📦 Seuil minimum :</label>
                <input type="number" wire:model="seuil" min="1" class="w-full p-3 border rounded-md shadow">
            </div>

            <div>
                <label class="font-semibold">📦 Montant souhaité dans le mail :</label>
                <input type="number" wire:model="default_montant" min="1" class="w-full p-3 border rounded-md shadow">
            </div>

            <div>
                <label class="font-semibold">🏢 Fournisseur :</label>
                <select wire:model="selectedFournisseur" class="w-full p-3 border rounded-md shadow">
                    <option value="">🔍 Sélectionner un fournisseur</option>
                    @foreach ($fournisseurs as $fournisseur)
                        <option value="{{ $fournisseur->id }}">{{ $fournisseur->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="font-semibold">⚙️ Méthode :</label>
                <select wire:model="triggerMethod" class="w-full p-3 border rounded-md shadow">
                    <option value="manual">📋 Manuel</option>
                    <option value="automatic">⚡ Automatique</option>
                </select>
            </div>
        </div>

        <button wire:click="saveTrigger"
                class="mt-6 w-full bg-green-600 text-white p-3 rounded hover:bg-green-700 transition-all">
            💾 Enregistrer
        </button>
    </div>


    <style>
        /* ✅ Responsive Design amélioré */
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
            .hidden.md\:table-cell {
                display: none;
            }
        }
    </style>
</div>



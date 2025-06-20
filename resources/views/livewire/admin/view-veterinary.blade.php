<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-6">🩺 Modifier un Vétérinaire</h2>

    <!-- 📝 Formulaire de modification du vétérinaire -->
    <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">👨‍⚕️ Modifier les informations</h3>
        <input type="text" wire:model="name" class="w-full p-2 border rounded mb-2">
        <button wire:click="updateVeterinarian" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Enregistrer les modifications
        </button>
    </div>

    <!-- 🏥 Cabinets associés -->
    <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">🏥 Cabinets associés :</h3>
        @if($linkedCabinets->isEmpty())
            <p class="text-gray-600">Aucun cabinet associé.</p>
        @else
            <ul>
                @foreach($linkedCabinets as $cabinet)
                    <li class="text-gray-700 flex justify-between items-center">
                        📍 {{ $cabinet->nom }} - {{ $cabinet->adresse }}
                        <button wire:click="unlinkCabinet({{ $cabinet->id }})"
                                class="ml-4 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            ❌ Dissocier
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- 🔎 Recherche et sélection des cabinets -->
    <div class="mb-6 relative">
        <h4 class="text-lg font-semibold mb-3">🔗 Associer un Cabinet</h4>
        <input type="text" wire:model.live="cabinetSearch" placeholder="Rechercher un cabinet..." class="w-full p-2 border rounded mb-2" />

        <div x-data="{ open: false }" @click.away="open = false" class="relative">
            <div @click="open = !open" class="cursor-pointer bg-gray-200 p-2 rounded">🔽 Sélectionner un cabinet</div>
            <div x-show="open" class="absolute z-10 bg-white border rounded shadow-lg w-full mt-1 max-h-48 overflow-y-auto">
                @foreach($filteredCabinets as $cabinet)
                    <div class="p-2 hover:bg-gray-100 cursor-pointer" wire:click="linkCabinet({{ $cabinet->id }})">
                        🏥 {{ $cabinet->nom }} - {{ $cabinet->adresse }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- 🏅 Spécialités associées -->
    <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">🏅 Spécialités :</h3>
        @if($specialites->isEmpty())
            <p class="text-gray-600">Aucune spécialité associée.</p>
        @else
            <ul>
                @foreach($specialites as $specialite)
                    <li class="text-gray-700 flex justify-between items-center">
                        🎖️ {{ $specialite->nom }}
                        <button wire:click="removeSpecialite({{ $specialite->id }})"
                                class="ml-4 px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                            ❌ Retirer
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

    <!-- 🔗 Associer une nouvelle spécialité -->
    <div class="mb-6">
        <h4 class="text-lg font-semibold mb-3">🔗 Associer une Spécialité</h4>
        <select wire:model="specialiteId" class="w-full p-2 border rounded mb-2">
            <option value="">Sélectionnez une spécialité</option>
            @foreach($allSpecialites as $specialite)
                <option value="{{ $specialite->id }}">{{ $specialite->nom }}</option>
            @endforeach
        </select>
        <button wire:click="addSpecialite" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Ajouter
        </button>
    </div>

    @if(session()->has('success'))
        <p class="text-green-600 font-semibold">{{ session('success') }}</p>
    @endif
</div>


<div class="p-6 bg-gray-100 w-full">
    <h1 class="text-4xl font-bold text-green-700 mb-6">📦 Gestion des Stocks</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- 📋 Liste des stocks -->
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">📋 Votre Stock</h2>

            <div class="overflow-auto max-h-[400px]">
                @forelse($stocks as $stock)
                    <div class="p-4 mb-4 border rounded-lg shadow-sm flex justify-between items-center bg-gray-50">
                        <div>
                            <p class="text-lg font-bold">💊 {{ $stock->actif->nom }} <span class="text-sm text-gray-600">({{ $stock->actif->type }})</span></p>
                            <p class="text-gray-600">Quantité : <strong>{{ $stock->stock }}</strong></p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Aucun stock enregistré.</p>
                @endforelse
            </div>
        </div>

        <!-- ⚙️ Gestion des stocks -->
        <div class="bg-white p-4 shadow rounded-lg">
            <h2 class="text-2xl font-bold mb-4 text-gray-800">⚙️ Gérer les Stocks</h2>

            <div class="space-y-4">
                <select wire:model.defer="selectedActifId" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
                    <option value="">🔍 Sélectionnez un actif</option>
                    @foreach($actifs as $actif)
                        <option value="{{ $actif->id }}">💊 {{ $actif->nom }} ({{ $actif->type }}) - {{$actif->prix}} €</option>
                    @endforeach
                </select>

                <input type="number" wire:model.defer="newStockAmount" placeholder="Quantité"
                       class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">

                <label class="flex items-center space-x-2">
                    <input type="checkbox" wire:model.defer="addAsExpense" checked>
                    <span class="text-sm text-gray-600">💸 Ajouter comme dépense</span>
                </label>

                <div class="flex flex-col sm:flex-row gap-2">
                    <button wire:click="addStock"
                            class="flex-1 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                        ➕ Ajouter au Stock
                    </button>
                    <button wire:click="useStock"
                            class="flex-1 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                        ➖ Utiliser du Stock
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 🆕 Section Ajout d'Actif -->
    <div class="mt-10 bg-white p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">🆕 Ajouter un Actif</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <input type="text" wire:model.defer="newActif.nom" placeholder="Nom de l'actif" class="p-2 border rounded">
            <input type="text" wire:model.defer="newActif.code_ATC" placeholder="Code ATC" class="p-2 border rounded">
            <input type="text" wire:model.defer="newActif.code_CIP" placeholder="Code CIP" class="p-2 border rounded">
            <input type="text" wire:model.defer="newActif.type" placeholder="Type (Boîte, Flacon...)" class="p-2 border rounded">
            <input type="number" wire:model.defer="newActif.prix" placeholder="Prix (€)" class="p-2 border rounded">
        </div>

        <button wire:click="addActif"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
            ➕ Ajouter Actif
        </button>
    </div>

    <!-- 🏢 Section Ajout de Fournisseur -->
    <div class="mt-10 bg-white p-6 shadow rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">🏢 Ajouter un Fournisseur</h2>

        <input type="text" wire:model.defer="nomFournisseur" placeholder="Nom"
               class="w-full p-2 mb-2 border rounded-lg focus:ring focus:ring-green-300">

        <input type="email" wire:model.defer="emailFournisseur" placeholder="Adresse Email"
               class="w-full p-2 mb-2 border rounded-lg focus:ring focus:ring-green-300">

        <input type="text" wire:model.defer="adresseFournisseur" placeholder="Adresse Postale"
               class="w-full p-2 mb-4 border rounded-lg focus:ring focus:ring-green-300">

        <button wire:click="addFournisseur"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            ➕ Ajouter Fournisseur
        </button>
    </div>

    <livewire:stock-trigger/>


    <!-- Messages -->
    @if (session()->has('message'))
        <div class="mt-4 p-4 bg-green-100 text-green-800 border border-green-400 rounded">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mt-4 p-4 bg-red-100 text-red-800 border border-red-400 rounded">
            {{ session('error') }}
        </div>
    @endif





    <!-- 📜 Historique des Stocks -->
    <div class="mt-10 bg-white p-6 shadow rounded-lg" x-data="{ open: false }">
        <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center justify-between p-4 bg-gray-100 rounded-lg cursor-pointer hover:bg-green-100 transition duration-300"
            @click="open = !open">
            📜 Historique des Stocks
            <span x-show="!open" class="text-lg transition-transform transform hover:scale-110">🔽</span>
            <span x-show="open" class="text-lg transition-transform transform hover:scale-110">🔼</span>
        </h2>

        <div x-show="open" x-transition class="mt-4 space-y-3">
            @forelse($logStocks as $log)
                <div class="p-4 border-l-4 {{ $log->action === 'add' ? 'border-green-500' : 'border-red-500' }} bg-gray-50 rounded-lg shadow-sm hover:bg-gray-200 transition">
                    <p class="text-gray-800 font-bold flex items-center">
                        {{ $log->action === 'add' ? '➕ Achat' : '➖ Utilisation' }} de
                        <span class="ml-1 text-green-600">{{ $log->number }} {{ Str::plural('unité', $log->number) }}</span>
                        de <strong class="ml-1 text-blue-600">{{ $log->actif->nom }}</strong>
                    </p>
                    <p class="text-gray-600 text-sm mt-1">
                        📅 Date : {{ \Carbon\Carbon::parse($log->date)->format('d/m/Y') }}
                    </p>
                    <p class="text-gray-500 text-sm italic mt-1">
                        📝 Détails : {{ $log->description }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500 italic">Aucune activité enregistrée dans l'historique des stocks.</p>
            @endforelse
        </div>
    </div>
</div>

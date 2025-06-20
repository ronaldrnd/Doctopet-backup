<div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-6">🩺 Ajouter un Vétérinaire & Cabinet</h2>

    <!-- 🏥 Ajout Vétérinaire -->
    <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">➕ Ajouter un Vétérinaire</h3>
        <input type="text" wire:model="vetoName" placeholder="Nom du vétérinaire"
               class="w-full p-2 border rounded mb-2">
        <button wire:click="addVeterinary" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
            Ajouter Vétérinaire
        </button>
    </div>

    <!-- 🏢 Ajout Cabinet -->
    <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">🏥 Ajouter un Cabinet</h3>
        <input type="text" wire:model="cabinetName" placeholder="Nom du cabinet"
               class="w-full p-2 border rounded mb-2">
        <input type="text" wire:model="cabinetAddress" placeholder="Adresse"
               class="w-full p-2 border rounded mb-2">
        <input type="text" wire:model="cabinetPhone" placeholder="Téléphone"
               class="w-full p-2 border rounded mb-2">
        <button wire:click="addCabinet" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Ajouter Cabinet
        </button>
    </div>

    @if(session()->has('success'))
        <p class="text-green-600 font-semibold">{{ session('success') }}</p>
    @elseif(session()->has('error'))
        <p class="text-red-600 font-semibold">{{ session('error') }}</p>
    @endif

    <!-- 🔍 Barre de recherche -->
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="🔍 Rechercher un vétérinaire..."
               class="w-full p-2 border rounded">
    </div>

    <!-- 📋 Liste des vétérinaires -->
    <div class="overflow-x-auto bg-gray-50 p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-3">📋 Liste des Vétérinaires</h3>
        <table class="w-full border-collapse">
            <thead>
            <tr class="bg-green-500 text-white">
                <th class="p-2 text-left">Nom</th>
                <th class="p-2 text-left">Action</th>
            </tr>
            </thead>
            <tbody>
            @forelse($veterinarians as $veto)
                <tr class="border-b">
                    <td class="p-2">{{ $veto->name }}</td>
                    <td class="p-2">
                        <a href="{{ route('admin.view_veterinary', $veto->id) }}"
                           class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                            Voir / Modifier
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2" class="p-2 text-center text-gray-600">Aucun vétérinaire trouvé.</td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <!-- 📌 Pagination -->
        <div class="mt-4">
            {{ $veterinarians->links() }}
        </div>
    </div>
</div>

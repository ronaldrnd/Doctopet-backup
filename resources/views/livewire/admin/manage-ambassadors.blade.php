<div class="p-6 bg-white shadow-lg rounded-lg space-y-10">
    <h2 class="text-2xl font-bold text-center text-green-700">🎖️ Gestion des Ambassadeurs</h2>

    <!-- Bouton Générer un code -->
    <div class="text-center">
        <button wire:click="generateCode"
                class="px-6 py-2 bg-green-600 text-white font-semibold rounded hover:bg-green-700 transition">
            ➕ Générer un code
        </button>
    </div>

    <!-- Liste des codes -->
    <div>
        <h3 class="text-lg font-bold mb-2">📜 Codes générés</h3>
        <ul class="bg-gray-100 rounded shadow divide-y">
            @forelse($codes as $code)
                <li class="p-3 flex justify-between">
                    <span class="font-mono text-blue-700">{{ $code->code }}</span>
                    <span class="text-gray-600 text-sm">{{ $code->created_at->format('d/m/Y H:i') }}</span>
                </li>
            @empty
                <li class="p-3 text-gray-500 text-center">Aucun code généré.</li>
            @endforelse
        </ul>
    </div>

    <!-- Recherche et gestion ambassadeurs -->
    <div>
        <h3 class="text-lg font-bold mb-2">🧑‍⚕️ Professionnels</h3>
        <input type="text"
               wire:model.live="search"
               placeholder="🔍 Rechercher un professionnel par nom ou email"
               class="w-full border border-gray-300 p-2 rounded-md mb-4 focus:ring-2 focus:ring-green-500">

        <div class="space-y-2">
            @forelse($professionals as $pro)
                <div class="flex items-center justify-between p-4 bg-white border rounded shadow">
                    <div>
                        <p class="font-bold text-gray-800">{{ $pro->name }}</p>
                        <p class="text-sm text-gray-500">{{ $pro->email }}</p>
                    </div>

                    <button wire:click="toggleAmbassador({{ $pro->id }})"
                            class="px-4 py-1 text-sm rounded font-semibold transition
                            {{ $pro->is_ambassador ? 'bg-red-500 text-white hover:bg-red-600' : 'bg-blue-500 text-white hover:bg-blue-600' }}">
                        {{ $pro->is_ambassador ? 'Retirer Ambassadeur' : 'Nommer Ambassadeur' }}
                    </button>
                </div>
            @empty
                <p class="text-gray-500 text-center">Aucun professionnel trouvé.</p>
            @endforelse
        </div>
    </div>
</div>

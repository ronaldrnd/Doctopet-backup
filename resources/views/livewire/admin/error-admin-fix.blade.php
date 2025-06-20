<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-red-700 mb-6">⚠️ Remontée des erreurs</h1>

    <div x-data="{ activeTab: 'users' }">
        <div class="flex gap-4 mb-4">
            <button @click="activeTab = 'users'" :class="activeTab === 'users' ? 'bg-red-600 text-white' : 'bg-gray-200'" class="px-4 py-2 rounded">👤 Utilisateurs</button>
            <button @click="activeTab = 'cabinets'" :class="activeTab === 'cabinets' ? 'bg-red-600 text-white' : 'bg-gray-200'" class="px-4 py-2 rounded">🏥 Cabinets</button>
            <button @click="activeTab = 'vets'" :class="activeTab === 'vets' ? 'bg-red-600 text-white' : 'bg-gray-200'" class="px-4 py-2 rounded">🩺 Vétérinaires</button>
        </div>

        @if(session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session()->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif


        <!-- Utilisateurs sans coordonnées -->
        <div x-show="activeTab === 'users'">
            <h2 class="text-2xl font-bold text-red-700 mb-6">👤 Utilisateurs sans coordonnées</h2>
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <thead class="bg-red-600 text-white">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Adresse</th>
                    <th class="p-3">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($usersWithoutCoordinates as $user)
                    <tr class="border-b">
                        <td class="p-3">{{ $user->name }}</td>
                        <td class="p-3">
                            <input type="text" wire:model.defer="editingAddress.{{ $user->id }}" class="border rounded px-2 w-[70%] py-1" value="{{$user->address}}" />
                            <button wire:click="updateAddress({{ $user->id }}, 'user')" class="bg-green-500 text-white px-2 py-1 rounded">💾</button>
                        </td>
                        <td class="p-3">
                            <button wire:click="attemptToFix({{ $user->id }}, 'user')" class="bg-blue-600 text-white px-3 py-1 rounded">🔍 Corriger</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <!-- Cabinets sans coordonnées -->
        <div x-show="activeTab === 'cabinets'">
            <h2 class="text-2xl font-bold text-red-700 mb-6">🏥 Cabinets sans coordonnées</h2>
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <thead class="bg-red-600 text-white">
                <tr>
                    <th class="p-3">Nom</th>
                    <th class="p-3">Adresse</th>
                    <th class="p-3">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cabinetsWithoutCoordinates as $cabinet)
                    <tr class="border-b">
                        <td class="p-3">{{ $cabinet->nom }}</td>
                        <td class="p-3">
                            <input type="text" wire:model.defer="editingAddress.{{ $cabinet->id }}" class="border rounded px-2 py-1" />
                            <button wire:click="updateAddress({{ $cabinet->id }}, 'cabinet', editingAddress[{{ $cabinet->id }}])" class="bg-green-500 text-white px-2 py-1 rounded">💾</button>
                        </td>
                        <td class="p-3">
                            <button wire:click="attemptToFix({{ $cabinet->id }}, 'cabinet')" class="bg-blue-600 text-white px-3 py-1 rounded">🔍 Corriger</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
        {{ $modeEdit ? '✏ Modifier le Cabinet' : '➕ Ajouter un Cabinet' }}
    </h2>

    @if(session()->has('message'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="mb-4">
            <label class="block text-gray-700">Nom du cabinet :</label>
            <input type="text" wire:model="nom" class="w-full p-2 border rounded">
            @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Adresse :</label>
            <input type="text" wire:model="adresse" class="w-full p-2 border rounded">
            @error('adresse') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Latitude :</label>
                <input type="text" wire:model="latitude" class="w-full p-2 border rounded">
                @error('latitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div>
                <label class="block text-gray-700">Longitude :</label>
                <input type="text" wire:model="longitude" class="w-full p-2 border rounded">
                @error('longitude') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="flex space-x-4 mt-4">
            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
                💾 {{ $modeEdit ? 'Mettre à jour' : 'Créer' }}
            </button>

            @if($modeEdit)
                <button type="button" wire:click="delete"
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 transition">
                    🗑 Supprimer
                </button>
            @endif
        </div>
    </form>
</div>

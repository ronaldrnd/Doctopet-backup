<div class="w-fill-available bg-gray-100 p-10 relative">
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br opacity-70"></div>

    <div class="relative bg-white shadow-xl rounded-lg p-6 md:p-8 w-full max-w-4xl mx-auto">
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div x-data="{ editing: false }" x-on:closeEditMode.window="editing = false">
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-green-700 text-center md:text-left">
                    🏥 Clinique : {{ $name }}
                </h1>


                @if($isMemberClinic)
                    <a href="{{route("clinique.params",$clinic->id)}}">
                    <button
                            class="bg-green-500 text-white px-4 py-2 rounded-md font-bold hover:bg-green-400 transition mt-4 md:mt-0">
                       Paramètre
                    </button>
                    </a>
                @endif

                @if ($isOwner)
                    <button @click="editing = !editing"
                            class="bg-yellow-500 text-white px-4 py-2 rounded-md font-bold hover:bg-yellow-600 transition mt-4 md:mt-0">
                        <span x-show="!editing">Modifier</span>
                        <span x-show="editing">Annuler</span>
                    </button>
                @endif
            </div>

            <!-- MODE AFFICHAGE -->
            <div x-show="!editing" class="space-y-6">
                <p><strong>📍 Adresse :</strong> {{ $address }}</p>
                <p><strong>📞 Téléphone :</strong> {{ $phone }}</p>
                <p><strong>🕒 Horaires :</strong> {{ $opening_time }} - {{ $closing_time }} </p>
                <p><strong>👤 Responsable :</strong> {{ $clinic->owner->name ?? 'Non assigné' }}</p>

                <div>
                    <h2 class="text-xl font-semibold text-gray-800 mb-2">👥 Membres</h2>
                    @forelse($clinic->users as $user)
                        <div class="p-2 border-b">
                            <p class="font-semibold">{{ $user->name }} <span class="text-sm text-gray-500">({{ $user->email }})</span></p>
                        </div>
                    @empty
                        <p class="text-gray-500">Aucun membre</p>
                    @endforelse
                </div>
            </div>

            <!-- MODE ÉDITION -->
            <div x-show="editing" x-cloak>
                <form wire:submit.prevent="updateClinic">
                    <div class="mb-4">
                        <label class="block font-medium">Nom de la clinique</label>
                        <input type="text" wire:model="name" class="w-full border rounded p-2 mt-1">
                        @error('name') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Adresse</label>
                        <input type="text" wire:model="address" class="w-full border rounded p-2 mt-1">
                        @error('address') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Téléphone</label>
                        <input type="text" wire:model="phone" class="w-full border rounded p-2 mt-1">
                        @error('phone') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium">Horaire</label>

                    <input type="text" wire:model="opening_time" class="w-full border rounded p-2 mt-1">
                    <input type="text" wire:model="closing_time" class="w-full border rounded p-2 mt-1">
                        @error('opening_time') <span class="text-red-500">{{ $message }}</span> @enderror
                        @error('closing_time') <span class="text-red-500">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
                            Sauvegarder
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

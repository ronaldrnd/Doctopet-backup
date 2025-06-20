<div x-data="{ open: false }" class="bg-gray-100">
    <h1 class="text-2xl font-bold text-green-700">🔄 Demande de Transfert</h1>

    <!-- Formulaire d'envoi -->
    <div class="bg-white shadow p-4 rounded-lg mb-6">
        <label class="font-bold text-gray-700">Sélectionnez un Rendez-vous :</label>
        <select wire:model="selectedAppointment" class="w-full p-2 border rounded-lg">
            <option value="">Choisissez un rendez-vous</option>
            @foreach($appointments as $appointment)
                <option value="{{ $appointment->id }}">
                    {{
                        $appointment->service->name
                        . " - " . $appointment->user->name
                        . " (" . $appointment->animal->nom . ")"
                        . " - " . \Carbon\Carbon::parse($appointment->date)->format("d/m/Y")
                        . " - [" . \Carbon\Carbon::parse($appointment->start_time)->format("H:i")
                        . " - " . \Carbon\Carbon::parse($appointment->end_time)->format("H:i") . "]"
                    }}
                </option>
            @endforeach
        </select>

        <!-- Recherche dynamique du professionnel -->
        <label class="font-bold text-gray-700 mt-4">Sélectionnez un Professionnel :</label>

        <div class="relative">
            <input
                type="text"
                wire:model.live="search"
                @focus="open = true"
                @click.away="open = false"
                class="w-full p-2 border rounded-lg"
                placeholder="Rechercher un vétérinaire..."
            >

            @if (!empty($filteredProfessionals))
                <div class="absolute w-full bg-white shadow-md rounded mt-2 max-h-40 overflow-y-auto" x-show="open">
                    @foreach ($filteredProfessionals as $user)
                        <button wire:click="selectUser({{ $user->id }})"
                                class="block w-full text-left px-4 py-2 flex items-center hover:bg-gray-200">
                            <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('img/default_profile.png') }}"
                                 alt="Profil" class="w-10 h-10 rounded-full border-2 border-gray-300 mr-3">
                            <div>
                                <span class="block font-semibold text-gray-800">{{ $user->name }}</span>
                                <span class="block text-sm text-gray-500">📍 {{ $user->address ?? 'Adresse non renseignée' }}</span>
                            </div>
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Affichage du professionnel sélectionné -->
        @if ($selectedProfessional)
            <p class="mt-2 text-green-600 font-bold">
                ✅ Sélectionné : {{ $selectedProfessional->name }}
            </p>
        @endif

        <button wire:click="sendTransferRequest" class="bg-green-600 text-white px-4 py-2 rounded-lg mt-4">
            📤 Envoyer la Demande
        </button>
    </div>

    <!-- Liste des demandes reçues -->
    <h3 class="text-lg font-bold text-blue-700">📥 Demandes Reçues</h3>
    <div class="space-y-4">
        @foreach($requests as $request)
            <div class="bg-gray-50 p-4 rounded-lg shadow flex justify-between">
                <div>
                    <p><strong>De :</strong> {{ $request->sender->name }}</p>
                    <p><strong>Rendez-vous :</strong> {{ $request->appointment->service->name }} - {{ $request->appointment->user->name }}</p>
                    <p><strong>Date :</strong> {{ $request->appointment->date }}</p>
                </div>
                <div class="flex space-x-2">
                    <button wire:click="acceptTransfer({{ $request->id }})" class="bg-green-600 text-white px-4 py-2 rounded-lg">
                        ✅ Accepter
                    </button>
                    <button wire:click="refuseTransfer({{ $request->id }})" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                        ❌ Refuser
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>

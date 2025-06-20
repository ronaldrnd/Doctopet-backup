<div class="container mx-auto py-8 bg-gray-100 px-4">
    <!-- Titre -->
    <h2 class="text-3xl font-bold text-green-700 mb-6 flex items-center">
        📋 Détails du Rendez-vous
    </h2>

    <!-- Informations du rendez-vous -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 transition-all hover:shadow-xl">
        <h3 class="text-xl font-semibold text-gray-800 flex items-center">
            📅 Informations Générales
        </h3>
        <div class="mt-4 space-y-2 text-gray-700">
            <p class="flex items-center"> 🗓️ <strong class="ml-2 mr-2">Date : </strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} </p>
            <p class="flex items-center"> ⏰ <strong class="ml-2 mr-2">Heure : </strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }} </p>
            <p class="flex items-center"> 🐾 <strong class="ml-2 mr-2">Animal : </strong> {{ $appointment->animal->nom }} </p>
            <p class="flex items-center"> 👤 <strong class="ml-2 mr-2">Propriétaire : </strong> {{ $appointment->user->name }} </p>
            <p class="flex items-center"> 🩺 <strong class="ml-2 mr-2">Service : </strong> {{ $appointment->service->name }} </p>

            <p class="flex items-center">
                🏷️ <strong class="ml-2">Statut : </strong>
                <span class="ml-2 px-3 py-1 rounded-full text-white font-semibold cursor-pointer"
                      :class="{
                        'bg-yellow-500': '{{ $appointment->status }}' === 'pending',
                        'bg-green-500': '{{ $appointment->status }}' === 'confirmed',
                        'bg-red-500': '{{ $appointment->status }}' === 'canceled'
                    }"
                      x-data="{ open: false }"
                      @click="open = !open">
                    {{ $appointment->status === 'pending' ? '🟡 En attente' : ($appointment->status === 'confirmed' ? '✅ Accepté' : '❌ Refusé') }}
                </span>

            </p>
        </div>
    </div>



        <!-- Décision accepter ou refuser -->
        <div class="bg-white shadow-lg rounded-lg p-4 mt-6 transition-all hover:shadow-xl mb-5">
            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                🏷️ Modifier le statut du rendez-vous
            </h3>

            <p class="text-sm text-gray-600 mt-2">
                Vous pouvez mettre à jour le statut du rendez-vous ci-dessous. Cette action informera automatiquement le client.
            </p>

            <div class="flex items-center space-x-4 mt-4">

                <!-- Boutons pour modifier le statut -->
                <button wire:click="updateStatus('confirmed')"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition flex items-center">
                    ✅ Accepter
                </button>
                <button wire:click="updateStatus('canceled')"
                        class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 transition flex items-center">
                    ❌ Refuser
                </button>
            </div>
        </div>


        <!-- Upload des fichiers -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 transition-all hover:shadow-xl">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">📂 Document du rendez-vous (facture, ordonnance, etc)</h3>

            <!-- Liste des fichiers -->
            @if (!$uploadedFiles->isEmpty())
                <ul class="space-y-2 mb-4">
                    @foreach ($uploadedFiles as $file)
                        <li class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                            <span class="text-gray-700 truncate">{{ $file->file_name }}</span>

                            <div class="flex space-x-2">
                                <button wire:click="downloadFile({{ $file->id }})" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                    ⬇️ Télécharger
                                </button>

                                <button wire:click="deleteFile({{ $file->id }})" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                    🗑️ Supprimer
                                </button>
                            </div>
                        </li>

                    @endforeach
                </ul>
            @else
                <p class="text-gray-500">Aucun fichier disponible.</p>
            @endif

            <!-- Upload de nouveaux fichiers -->
            <input type="file" multiple wire:model="files" class="w-full border rounded-md p-2 mb-2">
            <button wire:click="uploadFiles" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                📤 Télécharger
            </button>
        </div>


<!-- Section Historique Médical -->
    <div class="bg-white shadow-lg rounded-lg p-6 transition-all hover:shadow-xl mt-6">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">📚 Historique Médical de {{ $appointment->animal->nom }}</h3>

        <!-- Liste des historiques -->
        @if ($activeMedicalHistories->isNotEmpty())
            <ul class="space-y-2 mb-4">
                @foreach ($activeMedicalHistories as $history)
                    <li class="bg-gray-100 p-3 rounded-md text-gray-700">
                        {{ $history->modification }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucun historique médical disponible.</p>
        @endif

        <!-- Formulaire d'ajout -->
        <textarea wire:model="medicalHistory" class="w-full h-24 px-4 py-2 border rounded-md mb-4" placeholder="Ajouter une nouvelle note médicale..."></textarea>
        <button wire:click="addMedicalHistory" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
            ➕ Ajouter à l'historique
        </button>
    </div>





    <!-- Section Medicament Formulaire -->
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6 transition-all hover:shadow-xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">💊 Médicaments Utilisés</h3>

        <div class="space-y-4">
            <select wire:model.defer="selectedActifId" class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">
                <option value="">🔍 Sélectionnez un médicament disponible</option>
                @foreach($actifs as $stock)
                    <option value="{{ $stock->actif->id }}">
                        💊 {{ $stock->actif->nom }} ({{ $stock->actif->type }}) - 🏷️ Quantité restante : {{ $stock->stock }}
                    </option>
                @endforeach
            </select>

            <input type="number" wire:model.defer="usedStockAmount" placeholder="Quantité utilisée"
                   class="w-full p-2 border rounded focus:ring-2 focus:ring-green-500">

            <button wire:click="useActif"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full">
                ➖ Utiliser le Médicament
            </button>
        </div>
    </div>





    <!-- Rédaction d'un avis -->
    <div class="bg-white shadow-lg rounded-lg p-6 transition-all hover:shadow-xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">📝 Compte rendu du rendez-vous</h3>
        <textarea wire:model="comment" class="w-full h-32 px-4 py-2 border rounded-md"></textarea>
        <button wire:click="saveComment" wire:loading.attr="disabled" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
            💾 Sauvegarder
        </button>
    </div>

    <!-- Notification -->
    @if ($successMessage)
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ $successMessage }}
        </div>
    @endif
</div>

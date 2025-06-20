    <div class=" bg-gradient-to-r bg-gray-100 p-10 w-fill-available">
        <div class="bg-white shadow-2xl rounded-lg p-8 max-w-4xl mx-auto relative">


            <!-- ✅ Notifications de succès -->
            @if (session()->has('success'))
                <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6 shadow-md">
                    {{ session('success') }}
                </div>
            @endif

            <!-- ❌ Notifications d'erreur -->
            @if (session()->has('error'))
                <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6 shadow-md">
                    {{ session('error') }}
                </div>
            @endif


            <!-- Informations de l'animal -->
            <div class="flex items-center mb-6">
                <!-- Photo -->
                <div>
                    @if ($photo)
                        <img src="{{ asset($photo)}}" alt="Photo de l'animal" class="w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-lg">
                    @else
                        <div class="w-32 h-32 bg-gray-300 rounded-full flex items-center justify-center shadow-lg">
                            @php
                                if(isset($animal->race))
                                    $isFind = file_exists(public_path('img/races/' . $race . '.png'));
                                else
                                    $isFind = null;
                                @endphp
                            <img src=" {{asset( $isFind ?  'img/races/' . $race . '.png' : 'img/races/default.png')}}"
                                 alt="Photo par défaut"
                                 class="w-28 h-28 object-cover rounded-full">
                        </div>
                    @endif
                </div>

                <!-- Détails -->
                <div class="ml-6 space-y-2">
                    <h1 class="text-3xl font-extrabold text-green-700 flex items-center">
                        🐾 {{ $nom }}
                    </h1>
                    <p class="text-gray-700">🦴 <strong>Espèce :</strong> {{ $espece }}</p>
                    <p class="text-gray-700">📏 <strong>Race :</strong> {{ $race ?? 'Non renseignée' }}</p>
                    <p class="text-gray-600">🎂 <strong>Date de naissance :</strong> {{ \Carbon\Carbon::parse($date_naissance)->format('d/m/Y') }}</p>
                    <p class="text-gray-600">⚖️ <strong>Poids :</strong> {{ $poids }} kg</p>
                    <p class="text-gray-600">📏 <strong>Taille :</strong> {{ $taille ?? 'Non renseignée' }} cm</p>
                    <p class="text-gray-500 mt-2">🩺 <strong>Historique médical :</strong> {{ $historique_medical ?? 'RAS' }}</p>
                </div>
            </div>

            <!-- Formulaire pour modifier -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-green-700 flex items-center mb-4">✏️ Modifier les informations</h2>
                <form wire:submit.prevent="updateAnimal" class="space-y-5">
                    <!-- Nom -->
                    <div>
                        <label class="block text-gray-700 font-semibold">🐶 Nom :</label>
                        <input type="text" wire:model="nom" placeholder="Nom de l'animal" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Date de naissance -->
                    <div>
                        <label class="block text-gray-700 font-semibold">🎂 Date de naissance :</label>
                        <input type="date" wire:model="date_naissance" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('date_naissance') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Historique médical -->
                    <div>
                        <label class="block text-gray-700 font-semibold">🩺 Historique médical :</label>
                        <textarea wire:model="historique_medical" placeholder="Historique médical" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500"></textarea>
                        @error('historique_medical') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Poids -->
                    <div>
                        <label class="block text-gray-700 font-semibold">⚖️ Poids (kg) :</label>
                        <input type="number" step="0.1" wire:model="poids" placeholder="Poids en kg" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('poids') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Taille -->
                    <div>
                        <label class="block text-gray-700 font-semibold">📏 Taille (cm) :</label>
                        <input type="number" step="0.1" wire:model="taille" placeholder="Taille en cm" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('taille') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nouvelle photo -->
                    <div>
                        <label class="block text-gray-700 font-semibold">📸 Nouvelle photo :</label>
                        <input type="file" wire:model="newPhoto" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('newPhoto') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if ($newPhoto)
                        <div class="mt-4">
                            <p class="font-semibold text-gray-700">Aperçu de la nouvelle photo :</p>
                            <img src="{{ $newPhoto->temporaryUrl() }}" alt="Nouvelle photo" class="w-32 h-32 rounded-full object-cover mt-2 border-2 border-green-500">
                        </div>
                    @endif

                    <!-- Bouton de mise à jour -->
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-green-700 transition">
                        💾 Mettre à jour
                    </button>
                </form>
            </div>

            <!-- Dossiers médicaux -->
            <div class="mt-10">
                <h2 class="text-2xl font-bold text-green-700 flex items-center mb-4">📂 Dossiers médicaux</h2>
                @if ($dossiers->isEmpty())
                    <p class="text-gray-600">Aucun dossier médical disponible pour cet animal.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($dossiers as $dossier)
                            <li class="p-4 bg-gray-50 border-l-4 border-green-500 rounded-lg shadow">
                                <p class="text-gray-800 font-bold">📅 Date : {{ \Carbon\Carbon::parse($dossier->date)->format('d/m/Y') }}</p>
                                <p class="text-gray-700">📝 Description : {{ $dossier->description }}</p>
                                <p class="text-gray-700">👨‍⚕️ Vétérinaire : {{ $dossier->veterinaire->name }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

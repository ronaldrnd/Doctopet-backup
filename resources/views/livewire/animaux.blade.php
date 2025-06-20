<div class="min-h-screen  bg-gray-100  p-10 w-full">
    <h1 class="text-3xl font-extrabold text-green-700 mb-8 flex items-center">
        🐾 Mes Animaux
    </h1>


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


    <!-- Dropdown pour le formulaire d'ajout d'animal -->
    <div class="relative mb-8">
        <div x-data="{ open: false }">
            <button
                @click="open = !open"
                class="bg-green-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-green-700 transition flex items-center shadow-md">
                <i class="fas fa-plus mr-2"></i> Ajouter un animal
            </button>

            <!-- Formulaire d'ajout d'animal -->
            <div
                x-show="open"
                x-transition
                class="z-10 bg-white shadow-lg rounded-lg mt-4 p-6 w-full max-w-lg"
                @click.away="open = false">
                <h2 class="text-xl font-bold text-green-700 mb-4 flex items-center">
                    📝 Informations sur l'animal
                </h2>
                <form wire:submit.prevent="saveAnimal" class="space-y-5">
                    <!-- Nom -->
                    <div>
                        <label class="block text-gray-700 font-semibold">🐶 Nom :</label>
                        <input type="text" wire:model="nom" placeholder="Nom de l'animal" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('nom')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Espèce -->
                    <div>
                        <label class="block text-gray-700 font-semibold">🦴 Espèce :</label>
                        <select wire:model="selectedEspece" wire:change="updateRaces($event.target.value)" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                            <option value="">Sélectionnez une espèce</option>
                            @foreach($especes as $espece)
                                <option value="{{ $espece->id }}">{{ $espece->nom }}</option>
                            @endforeach
                        </select>
                        @error('selectedEspece')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Race -->
                    <div>
                        <label class="block text-gray-700 font-semibold">📏 Race :</label>
                        <select wire:model="selectedRace" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500" @if(empty($races)) disabled @endif>
                            <option value="">Sélectionnez une race</option>
                            @foreach($races as $race)
                                <option value="{{ $race->id }}">{{ $race->nom }}</option>
                            @endforeach
                        </select>
                        @error('selectedRace')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Historique médical -->
                    <div>
                        <label class="block text-gray-700 font-semibold">🩺 Historique médical :</label>
                        <textarea wire:model="historique_medical" placeholder="Historique médical" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500"></textarea>
                        @error('historique_medical')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Poids -->
                    <div>
                        <label class="block text-gray-700 font-semibold">⚖️ Poids (kg) :</label>
                        <input type="number" step="0.1" wire:model="poids" placeholder="Poids en kg" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('poids') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Taille -->
                    <div>
                        <label class="block text-gray-700 font-semibold">📏 Taille (cm) :</label>
                        <input type="number" step="0.1" wire:model="taille" placeholder="Taille en cm" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('taille') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Date de naissance -->
                    <div>
                        <label class="block text-gray-700 font-semibold">🎂 Date de naissance :</label>
                        <input type="date" wire:model="date_naissance" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-green-500">
                        @error('date_naissance')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bouton d'envoi -->
                    <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg w-full hover:bg-green-700 shadow-md transition">
                        ➕ Ajouter l'animal
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Liste des animaux -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($animaux as $animal)
            <div class="bg-white shadow-lg rounded-lg p-6 flex flex-col items-center transition-transform duration-300 hover:scale-105">
                <!-- Photo de l'animal -->
                <a href="{{ route('animal.view', $animal->id) }}">
                    <div class="mb-4">
                        @if($animal->photo)
                            <img src="{{ asset($animal->photo)}}" alt="Photo de {{ $animal->nom }}" class="w-32 h-32 rounded-full object-cover border-2 border-green-500 shadow">
                        @else
                            <div class="w-32 h-32 bg-gray-300 rounded-full flex items-center justify-center shadow-lg">
                                @php
                                    if(isset($animal->race))
                                        $isFind = file_exists(public_path('img/races/' . $animal->race->nom . '.png'));
                                    else
                                        $isFind = null;
                                @endphp

                                <img src=" {{asset( $isFind ?  'img/races/' . $animal->race->nom . '.png' : 'img/races/default.png')}}"
                                     alt="Photo par défaut"
                                     class="w-28 h-28 object-cover rounded-full">
                            </div>
                        @endif
                    </div>
                </a>

                <!-- Informations sur l'animal -->
                <h3 class="text-lg font-bold text-green-700">{{ $animal->nom }}</h3>
                <p class="text-gray-600 mt-2"><strong>🦴 Espèce :</strong> {{ $animal->espece->nom ?? 'Non renseignée' }}</p>
                <p class="text-gray-600"><strong>📏 Race :</strong> {{ $animal->race->nom ?? 'Non renseignée' }}</p>
                <p class="text-gray-600"><strong>⚖️ Poids :</strong> {{ $animal->poids }} kg</p>
                <p class="text-gray-600"><strong>📏 Taille :</strong> {{ $animal->taille ?? 'Non renseignée' }} cm</p>
                <p class="text-gray-500 text-sm mt-2"><strong>🎂 Date de naissance :</strong> {{ \Carbon\Carbon::parse($animal->date_naissance)->format('d/m/Y') }}</p>
                <p class="text-gray-500 text-sm"><strong>🩺 Historique médical :</strong> {{ $animal->historique_medical ?? 'RAS' }}</p>
            </div>
        @endforeach
    </div>


    <div class="bg-green-500 text-white p-6 mb-8 rounded-lg shadow-md flex flex-col md:flex-row items-center justify-between mt-8">
        <div>
            <h2 class="text-2xl font-bold">Adoptez votre futur compagnon avec nos éleveurs partenaires !</h2>
            <p class="mt-2">Trouvez un éleveur près de chez vous et adoptez un animal en toute confiance.</p>
        </div>
        <a href="{{ route('find.breeder') }}"
           class="mt-4 md:mt-0 bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">
            Trouver un éleveur
        </a>
    </div>

</div>

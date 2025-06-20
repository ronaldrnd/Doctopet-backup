<div class="p-6 bg-gray-100 shadow-lg rounded-lg w-full mx-auto mt-10">
    <!-- 🏆 Progress Bar -->
    <p class="text-center mt-6 mb-6 font-bold">Étape {{$step}} sur 4</p>
    <div class="relative w-full bg-gray-200 h-3 rounded-full overflow-hidden mb-6">
        <div class="bg-green-500 h-3 rounded-full transition-all duration-300" style="width: {{ ($step / 4) * 100 }}%;"></div>
    </div>

    <!-- Bouton Étape Précédente -->
    @if($step > 1)
        <div class="mt-6 text-center mb-6">
            <button wire:click="$set('step', {{ $step - 1 }})"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition shadow-md">
                ⬅️ Étape Précédente
            </button>
        </div>
    @endif

    <!-- Étape 1 : Sélection de l'espèce -->
    @if ($step === 1)
        <h2 class="text-2xl font-bold text-center mb-6">🐾 Choisissez une espèce</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($especes as $espece)
                <button wire:click="selectEspece({{ $espece->id }})"
                        class="flex flex-col items-center bg-gray-100 p-5 rounded-lg text-center hover:bg-green-100 transition transform hover:scale-105 shadow-md">
                    <div class="w-full flex justify-center">
                        @php
                            $isFind = file_exists(public_path('img/especes/' . lcfirst($espece->nom) . '.png'));
                        @endphp
                        <img class="w-full max-w-[120px] h-auto mb-2 object-cover rounded-md"
                             src="{{ asset($isFind ? 'img/especes/' . lcfirst($espece->nom) . '.png' : 'img/especes/default.png') }}"
                             alt="{{ $espece->nom }}">
                    </div>
                    <span class="font-semibold text-lg text-gray-700 mt-5">{{ $espece->nom }}</span>
                </button>
            @endforeach
        </div>

        <!-- Étape 2 : Sélection de la race -->
    @elseif ($step === 2)
        <h2 class="text-2xl font-bold text-center mb-6">🐕‍🦺 Sélectionnez une race</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($races as $race)
                <button wire:click="selectRace({{ $race->id }})"
                        class="flex flex-col items-center bg-gray-100 p-5 rounded-lg text-center hover:bg-blue-100 transition transform hover:scale-105 shadow-md">
                    <div class="w-full flex justify-center">
                        @php
                            $isFind = file_exists(public_path('img/races/' . $race->nom . '.png'));
                        @endphp
                        <img class="w-full max-w-[100px] h-auto object-cover rounded-md"
                             src="{{ asset($isFind ? 'img/races/' . $race->nom . '.png' : 'img/races/default.png') }}"
                             alt="{{ $race->nom }}">
                    </div>
                    <span class="font-semibold text-lg text-gray-700">{{ $race->nom }}</span>
                </button>
            @endforeach
        </div>

        <!-- Étape 3 : Localisation -->
    @elseif ($step === 3)
        <h2 class="text-2xl font-bold mb-6">Où voulez-vous chercher ?</h2>

        <div class="mt-6 text-center mb-6">
            <button wire:click="$set('step', {{ $step + 1 }})"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition shadow-md">
                ➡️ Étape Suivante
            </button>
        </div>

        <!-- Champ de recherche d'adresse -->
        <div class="flex items-center mb-4">
            <input type="text" wire:model.live="userAddress" class="w-full border rounded-lg p-4" placeholder="Votre adresse">
            <button onclick="getLocation(); showUpdatingMessage();"
                    class="ml-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Utiliser ma position
            </button>
        </div>

        <!-- Message de mise à jour -->
        <div id="updating-message" class="hidden text-green-600 font-medium mt-2">
            Votre position est en train de se mettre à jour...
        </div>

        <!-- Carte OpenStreetMap -->
        <div class="flex justify-center mt-6">
            <iframe class="w-full h-[400px] rounded-lg shadow-md"
                    frameborder="0"
                    src="https://www.openstreetmap.org/export/embed.html?bbox={{ $longitude - 0.05 }},{{ $latitude - 0.05 }},{{ $longitude + 0.05 }},{{ $latitude + 0.05 }}&layer=mapnik&marker={{ $latitude }},{{ $longitude }}">
            </iframe>
        </div>

        <!-- Étape 4 : Résultats -->
    @elseif ($step === 4)
        <h2 class="text-2xl font-bold text-center mb-6">🏡 Trouvez votre éleveur</h2>

        <!-- Slider pour la distance -->
        <div class="mb-8">
            <label class="block text-gray-700 font-bold mb-2">Distance maximale (km) : {{ $maxDistance }}</label>
            <input type="range" wire:model.lazy="maxDistance" min="1" max="50" class="w-full">
        </div>

        <div class="space-y-4">
            @foreach($breeders as $breeder)
                <div class="bg-white p-5 rounded-lg shadow-lg flex items-center hover:bg-gray-50 transition">
                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-green-500 mr-4">
                        <img src="{{ asset('storage/' . $breeder->eleveur->profile_picture) }}" alt="Photo de {{ $breeder->eleveur->name }}">
                    </div>
                    <div>
                        <p class="text-lg font-bold text-gray-800">{{ $breeder->eleveur->name }}</p>
                        <p class="text-gray-600 text-sm">🐶 {{ $breeder->stock }} {{\App\Models\Espece::find($especeId)->nom}} {{\App\Models\Race::find($raceId)->nom}}</p>
                        <p class="text-gray-500 text-xs">📍 {{ number_format($breeder->distance, 2) }} km</p>
                    </div>

                    <a href="{{ route('contact-breeder', ['id' => $breeder->eleveur->id]) }}"
                       class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition block text-center mt-4 ml-32">
                        📩 Contacter l'éleveur
                    </a>
                </div>
            @endforeach

            @if(empty($breeders))
                <p class="text-gray-500 text-center">Il n'y a pas encore d'offre pour adopter un(e) {{\App\Models\Espece::find($especeId)->nom}} {{\App\Models\Race::find($raceId)->nom}}</p>
            @endif
        </div>
    @endif





<script>

        function showUpdatingMessage() {
            const messageElement = document.getElementById('updating-message');
            messageElement.classList.remove('hidden'); // Affiche le message
            setTimeout(() => {
                messageElement.classList.add('hidden'); // Cache le message après 3 secondes
            }, 4000);
        }


        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;
                        let lat = document.getElementById('latitude').value;
                        let long = document.getElementById('longitude').value;

                        document.getElementById('latitude').dispatchEvent(new Event('input'));
                        document.getElementById('longitude').dispatchEvent(new Event('input'));

                        console.log("Position register");

                        // Attendre 2 secondes avant d'envoyer l'événement Livewire
                        setTimeout(() => {
                            Livewire.dispatch('updateLocation', { lat, long });
                        }, 2000);

                    },
                    function (error) {
                        alert("Erreur lors de la géolocalisation : " + error.message);
                    }
                );
            } else {
                alert("La géolocalisation n'est pas prise en charge par ce navigateur.");
            }
        }
    </script>
</div>

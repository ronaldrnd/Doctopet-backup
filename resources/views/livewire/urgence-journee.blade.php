<div class="container bg-gray-100  mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-green-700 mb-6">🚑 Urgence Journée</h1>

    <!-- Phase 1 : Adresse -->
    <div class="mb-6" x-data="{ showSuggestions: false, selectSuggestion(address, lat, lon) {
        $wire.selectAddress(address, lat, lon);
        showSuggestions = true;
    }}">
        <label for="address" class="block text-lg font-medium text-gray-700">📍 Indiquez votre adresse</label>
        <div class="mt-2 flex space-x-4 relative">
            <input
                type="text"
                id="address"
                wire:model.debounce.500ms="userAddress"
                x-on:input.debounce.500ms="$wire.searchAddress()"
                x-on:focus="showSuggestions = true"
                x-on:click.away="showSuggestions = false"
                class="w-full border rounded-lg p-4"
                placeholder="Adresse complète (Rue, Ville, Code Postal)">

            <button
                onclick="getLocation()"
                class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                📌 Géolocalisez-moi
            </button>

            <!-- Auto-complétion des adresses avec Alpine.js -->
            <ul x-show="showSuggestions && $wire.suggestions.length > 0"
                class="absolute top-full left-0 w-full bg-white border border-gray-300 rounded-md shadow-lg z-10 mt-2"
                x-transition.opacity>
                <template x-for="suggestion in $wire.suggestions" :key="suggestion.display_name">
                    <li class="p-3 hover:bg-gray-200 cursor-pointer"
                        x-text="suggestion.display_name"
                        x-on:click="$wire.SetData(suggestion.display_name, suggestion.lat, suggestion.lon)">
                    </li>
                </template>
            </ul>
        </div>

        <!-- Message de mise à jour -->
        <p x-show="$wire.message" class="mt-4 text-blue-600 font-medium" x-text="$wire.message"></p>

        <button
            wire:click="updateCoordinatesFromAddress"
            class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
            🔎 Rechercher
        </button>
    </div>

    <!-- Slider pour la distance -->
    <div class="mb-6">
        <label for="distance" class="block text-lg font-medium text-gray-700">
            🎯 Rayon de recherche : <span class="text-green-600 font-bold">{{ $distance }} km</span>
        </label>
        <input
            type="range"
            id="distance"
            wire:model.live="distance"
            min="2"
            max="50"
            step="1"
            class="w-full">
    </div>

    <!-- Phase 2 : Liste des vétérinaires -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @foreach($veterinarians as $vet)
            <div class="bg-white shadow-md rounded-lg p-6 flex items-center">
                <!-- Photo du vétérinaire -->
                <div class="w-20 h-20 rounded-full overflow-hidden mr-6">
                    @if(isset($vet->profile_picture))
                        <img src="{{ asset('storage/' . $vet->profile_picture) }}" alt="Photo de {{ $vet->name }}" class="object-cover w-full h-full">
                    @else
                        <img src="{{ asset('images/default-vet.png') }}" alt="Vétérinaire non inscrit" class="object-cover w-full h-full">
                    @endif
                </div>

                <div class="flex-grow">
                    <h3 class="text-xl font-bold text-green-700">{{ $vet->name }}</h3>
                    <p class="text-gray-600 text-sm">📍 {{ $vet->address }}</p>
                    <p class="text-gray-600 text-sm font-bold">📏 Distance : ~{{ number_format($vet->distance, 2) }} km</p>

                    @if(isset($vet->phone_number))
                        <p class="text-sm font-bold">🚨 Appeler ce vétérinaire pour une urgence :</p>
                        <a href="tel:{{ $vet->phone_number }}" class="mt-4 block text-blue-600 hover:underline">
                            📞 {{ $vet->phone_number }}
                        </a>
                    @else
                        <p class="text-red-600 font-bold">⚠️ Ce vétérinaire n'est pas inscrit sur DoctoPet.</p>
                        <p class="text-sm">Vous pouvez contacter son cabinet pour une prise en charge.</p>
                    @endif

                    <!-- Bouton pour signaler un problème -->

                </div>
            </div>
        @endforeach


        @foreach($externalVeterinarians as $vet)
                <div class="bg-white shadow-md rounded-lg p-6 flex items-center">

                    <!-- Photo du vétérinaire -->
                    <div class="w-20 h-20 rounded-full overflow-hidden mr-6">
                            <img src="{{ asset('img/default-vet.png') }}" alt="Vétérinaire non inscrit" class="object-cover w-full h-full">
                    </div>

                    <div class="flex-grow">
                    <h3 class="text-xl font-bold text-green-700">{{ $vet['name'] }}</h3>
                    <p class="text-gray-600 text-sm">📍 {{ $vet['address'] }}</p>

                    <p class="text-gray-600 text-sm font-bold">📏 Distance : ~{{ number_format($vet['distance'], 2) }} km</p>
                        <p class="text-sm font-bold">🚨 Appeler ce vétérinaire pour une urgence :</p>


                        <p class="mt-4 block text-blue-600 hover:underline">📞 {{ $vet['phone_number'] }}</p>

                    </div>

                    <button wire:click="openModal"
                            class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        🚨
                    </button>
                </div>
            @endforeach
    </div>




    <!-- Champs cachés pour les coordonnées -->
    <input type="hidden" id="latitude" wire:model="latitude">
    <input type="hidden" id="longitude" wire:model="longitude">

    <!-- Script JS pour la géolocalisation -->

    @if ($showModal)
        <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h2 class="text-xl font-bold text-red-600 mb-4">🚨 Signaler un problème</h2>

                <input type="text" wire:model="nom" class="w-full border rounded-lg p-3 mt-2" placeholder="Votre nom">
                @error('nom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input type="text" wire:model="prenom" class="w-full border rounded-lg p-3 mt-2" placeholder="Votre prénom">
                @error('prenom') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input type="email" wire:model="email" class="w-full border rounded-lg p-3 mt-2" placeholder="Votre email">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <input type="text" wire:model="libelle" class="w-full border rounded-lg p-3 mt-2" placeholder="Sujet du problème">
                @error('libelle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <textarea wire:model="message" class="w-full border rounded-lg p-3 mt-4" placeholder="Détails du problème"></textarea>
                @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                <div class="flex justify-end mt-4">
                    <button wire:click="submitSignalement"
                            class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Envoyer
                    </button>
                    <button wire:click="closeModal"
                            class="ml-2 bg-gray-400 text-white px-4 py-2 rounded-md hover:bg-gray-500">
                        Annuler
                    </button>
                </div>
            </div>
        </div>
    @endif



    <script>
        function getLocation() {

            console.log("oui");

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        document.getElementById('latitude').value = position.coords.latitude;
                        document.getElementById('longitude').value = position.coords.longitude;

                        let lat = document.getElementById('latitude').value;
                        let long = document.getElementById('longitude').value;


                        document.getElementById('latitude').dispatchEvent(new Event('input'));
                        document.getElementById('longitude').dispatchEvent(new Event('input'));

                        // Attendre 2 secondes avant d'envoyer l'événement Livewire
                        console.log("j'envoie le msg")

                        Livewire.dispatch('updateLocation', { lat, long });

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

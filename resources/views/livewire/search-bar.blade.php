<div class="bg-white p-4 rounded-lg shadow-md w-[90%]  mx-auto">

    <!-- Champs cachés pour les coordonnées -->
    <input type="hidden" id="latitude" wire:model="latitude">
    <input type="hidden" id="longitude" wire:model="longitude">





    <div class="bg-white p-6 rounded-lg shadow-md w-[90%] mx-auto">

        <!-- Sélection de l'animal -->
        <div class="mb-4">
            <label class="block text-lg font-semibold text-gray-700 flex items-center">
                🐾 Sélection de l'animal :
            </label>
            <select wire:model.live="selectedAnimal" class="w-full border p-3 rounded-lg mt-2 bg-gray-100 focus:ring-2 focus:ring-green-500">
                <option value="">Sélectionnez un animal</option>
                @foreach($userAnimals as $animal)
                    <option value="{{ $animal->id }}">
                        {{$animal->espece->emoji}} - {{ $animal->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Localisation avec bouton mise à jour -->
        <div class="mb-4">
            <label class="block text-lg font-semibold text-gray-700 flex items-center">
                📍 Adresse de recherche :
            </label>
            <div class="relative mt-2">
                <input type="text" wire:model.live="location"
                       class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-green-500 bg-gray-100"
                       placeholder="Ville ou localisation">
                <button onclick="getLocation()"
                        class="absolute right-3 top-1/2 transform -translate-y-1/2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                    Localiser 📍
                </button>
            </div>
        </div>

        <!-- Barre de recherche -->
        <div class="mb-4">
            <label class="block text-lg font-semibold text-gray-700 flex items-center">
                🔍 Recherche de service :
            </label>
            <div class="relative mt-2 flex">
                <input type="text" wire:model.live="query" placeholder="Nom, profession, prestation..."
                       class="w-full border p-3 rounded-lg bg-gray-100 focus:ring-2 focus:ring-green-500"
                       @if(!$selectedAnimal) disabled class="opacity-50 cursor-not-allowed" @endif>
                <button wire:click="searchByQuery"
                        class="ml-2 px-4 py-3 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition">
                    Rechercher 🔍
                </button>
            </div>
        </div>

    </div>



    <!-- Suggestions -->
    @if(!empty($suggestions))
        <div class="bg-white border mt-1 w-full rounded-lg shadow-lg">
            @foreach($suggestions['services'] as $serviceName => $services)
                <div wire:click="selectService('{{ $serviceName }}')" class="p-2 hover:bg-gray-100 cursor-pointer">
                    {{ $serviceName }} ({{ count($services) }} résultats)
                </div>
            @endforeach
            @foreach($suggestions['specialties'] as $specialty)
                <div wire:click="selectSpecialty({{ $specialty->id }})" class="p-2 hover:bg-gray-100 cursor-pointer text-blue-700">
                     {{ $specialty->nom }}
                </div>
            @endforeach
        </div>
    @endif






@if(count($searchResults) > 0)

        <div class="mt-6">
            <h2 class="text-xl md:text-2xl font-bold mb-6">Propositions de rendez-vous ({{count($searchResults)}})</h2>

            <!-- 🔄 Filtre par distance -->
            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2">Distance maximale (km) : {{ $maxDistance }}</label>
                <input type="range" wire:model.lazy="maxDistance" min="1" max="50" class="w-full">
            </div>


            <div class="flex gap-4 mb-4">
                <button onclick="sortResults('price')" class="px-4 py-2 border rounded-lg bg-gray-100">
                    💰 Prix <span id="sort-price">🔽</span>
                </button>

                <button onclick="sortResults('distance')" class="px-4 py-2 border rounded-lg bg-gray-100">
                    📍 Distance <span id="sort-distance">🔽</span>
                </button>

                <button onclick="sortResults('rating')" class="px-4 py-2 border rounded-lg bg-gray-100">
                    ⭐ Note <span id="sort-rating">🔽</span>
                </button>
            </div>





            <div class="space-y-4"  id="results-container">
                @foreach($searchResults as $serviceName => $services)
                    @foreach($services as $service)
                        @php
                            $user = \App\Models\User::find($service["user"]["id"]);
                            $service = \App\Models\Service::find($service["id"]);
                            $distance = $this->calculateDistance($this->latitude, $this->longitude, $user->latitude, $user->longitude);
                            $rating = \App\Models\Review::where('specialist_id', $user->id)->avg('rating') ?? 0;
                        @endphp
                        @if($user->accept_online_rdv)
                            <!-- Affichage normal avec prise de RDV -->
                            <div class="bg-white p-4 border rounded-lg shadow-md grid grid-cols-1 md:grid-cols-[1fr_3fr] gap-4 hover:shadow-lg transition duration-300"


                                 data-price="{{ $service->price }}"
                                 data-distance="{{ $distance }}"
                                 data-rating="{{ $rating }}">

                                <div class="p-4 border-b md:border-b-0 md:border-r border-gray-200">
                                    <div class="flex items-center space-x-3 mb-4">
                                        <div class="w-24 h-16 rounded-full overflow-hidden border-2 border-green-500">
                                            <img src="{{ asset('storage/' . ($user->profile_picture ?? 'default.jpg')) }}"
                                                 alt="Photo de {{ $user->name ?? 'Utilisateur' }}"
                                                 class="object-cover w-full h-full max-h-100% max-w-100%">
                                        </div>
                                        <div class="bg-white p-4 border rounded-lg shadow-md">

                                            <h3 class="text-lg font-bold text-green-700">{{ $user->name ?? 'Inconnu' }}</h3>
                                            <p class="text-gray-600 text-sm">{{ $user->firstSpecialite()->nom }}</p>
                                            <p class="text-gray-500 text-xs">{{ $user->address ?? 'Adresse inconnue' }}</p>
                                            <p class="text-gray-700 font-bold">💰 Prix : {{ $service->price }}€</p>
                                            <p class="text-gray-700 font-bold">📍 Distance : {{ round($distance, 1) }} km</p>
                                            <p class="text-gray-700 font-bold">⭐ Note : {{ round($rating, 1) }}</p>
                                        </div>
                                    </div>
                                    <div class="bg-white p-4 border rounded-lg shadow-md">

                                        <h3 class="text-lg font-bold text-green-700">{{ $service->name ?? 'Inconnu' }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $service->description }}</p>
                                    </div>

                                </div>



                                <!-- Section Calendrier -->
                                <div class="w-full p-4">
                                    <livewire:calendar-availability
                                        :service_id="$service->id"
                                        :animalID="$selectedAnimal"
                                        :specializedServiceId="$selectedSpecializedService[$service->id] ?? null"
                                    />
                                </div>
                            </div>
                        @else
                            <!-- Affichage du mode "RDV par téléphone uniquement" -->
                            <div class="bg-gray-50 p-4 border rounded-lg shadow-md hover:shadow-lg transition duration-300">
                                <div class="flex items-center space-x-3 mb-4">
                                    <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-gray-500">
                                        <img src="{{ asset('storage/' . ($user->profile_picture ?? 'default.jpg')) }}"
                                             alt="Photo de {{ $user->name ?? 'Utilisateur' }}"
                                             class="object-cover w-full h-full">
                                    </div>
                                    <div>
                                        <h3 class="text-lg font-bold text-gray-700">{{ $user->name ?? 'Inconnu' }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $user->firstSpecialite()->nom }}</p>
                                        <p class="text-gray-500 text-xs">{{ $user->address ?? 'Adresse inconnue' }}</p>
                                    </div>
                                </div>

                                <div class="bg-yellow-100 text-yellow-800 p-3 rounded-lg mb-3 text-sm">
                                    📞 Ce professionnel préfère être contacté par téléphone pour la prise de rendez-vous.
                                </div>

                                <div class="flex justify-between">
                                    <p class="text-gray-700 font-bold">📍 Adresse :</p>
                                    <p class="text-gray-600">{{ $user->address ?? 'Non renseignée' }}</p>
                                </div>

                                <div class="flex justify-between mt-2">
                                    <p class="text-gray-700 font-bold">📞 Téléphone :</p>
                                    <p class="text-gray-600">
                                        <a class="underline text-blue-500" href="tel:{{$user->phone_number}}">{{$user->phone_number}}</a>
                                    </p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>


    @elseif($isSearch)

        <div>
            <span class="text-black text-lg text-center items-center ">Votre recherche n'a pas donnée de résultat.</span>
        </div>

    @endif






    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    Livewire.dispatch('updateLocation', { lat: position.coords.latitude, long: position.coords.longitude });
                });
            }
        }
    </script>

    <script>
        let currentSort = {
            price: "asc",
            distance: "asc",
            rating: "asc"
        };

        function sortResults(type) {
            let resultsContainer = document.getElementById('results-container');
            let items = Array.from(resultsContainer.children);

            items.sort((a, b) => {
                let aValue, bValue;

                if (type === "price") {
                    aValue = parseFloat(a.dataset.price);
                    bValue = parseFloat(b.dataset.price);
                    console.log(aValue + " VS " + bValue);
                } else if (type === "distance") {
                    aValue = parseFloat(a.dataset.distance);
                    bValue = parseFloat(b.dataset.distance);
                } else if (type === "rating") {
                    aValue = parseFloat(a.dataset.rating);
                    bValue = parseFloat(b.dataset.rating);
                }

                return currentSort[type] === "asc" ? aValue - bValue : bValue - aValue;
            });

            currentSort[type] = currentSort[type] === "asc" ? "desc" : "asc";
            document.getElementById(`sort-${type}`).innerText = currentSort[type] === "asc" ? "🔼" : "🔽";

            resultsContainer.innerHTML = "";
            items.forEach(item => resultsContainer.appendChild(item));
        }
    </script>



</div>




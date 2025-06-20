<div class="min-h-screen bg-gray-100 p-10 w-fill-available">
    <h1 class="text-4xl font-bold text-green-700 mb-10">Prendre Rendez-vous</h1>

    <!-- Champs cachés pour les coordonnées -->
    <input type="hidden" id="latitude" wire:model="latitude">
    <input type="hidden" id="longitude" wire:model="longitude">

    <!-- Barre de progression mise à jour -->
    <div class="w-fill-available bg-gray-200 rounded-full h-2.5 mb-8">
        @php
            $totalSteps = 6.5; // Inclut l'étape 2.5
            $progress = ($step / $totalSteps) * 100;
        @endphp
        <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $progress }}%;"></div>
    </div>

    <!-- Navigation entre les étapes -->
    <div class="flex items-center justify-between mb-6">
        @if($step > 1)
            <button wire:click="goToPreviousStep"
                    class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">
                Précédent
            </button>
        @else
            <div class="w-24"></div> <!-- Espace réservé pour aligner -->
        @endif

        <p class="text-gray-700 font-bold flex-1 text-center">Étape {{ $step }} sur 6</p>

        @if($step < 6)
            <button wire:click="goToNextStep"
                    class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                Suivant
            </button>
        @else
            <div class="w-24"></div> <!-- Espace réservé pour aligner -->
        @endif
    </div>



    <!-- Étape 1 : Choix de l'animal -->
    @if($step === 1)
        <h2 class="text-2xl font-bold mb-6">Choisissez un animal</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($userAnimals as $animal)
                <div
                    wire:click="selectAnimal({{ $animal->id }})"
                    class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-transform duration-300 hover:animate-shake cursor-pointer"
                >
                    <div class="mb-4">
                        @if($animal->photo)
                            <img src="{{ asset($animal->photo) }}"
                                 alt="Photo de {{ $animal->nom }}"
                                 class="w-32 h-32 rounded-full object-cover border-2 border-green-500">
                        @else
                            <div class="w-24 h-24 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                                <i class="fas fa-paw text-3xl"></i>
                            </div>
                        @endif
                    </div>
                    <h3 class="text-lg font-bold text-green-700">{{ $animal->nom }}</h3>
                    <p class="text-gray-600 mt-2"><strong>Espèce:</strong> {{ $animal->espece->nom ?? 'Non renseignée' }}</p>
                    <p class="text-gray-600"><strong>Race:</strong> {{ $animal->race->nom ?? 'Non renseignée' }}</p>
                </div>
            @endforeach
        </div>

        @if(count($userAnimals) == 0)
            <p class="text-1xl font-bold mb-6">Vous n'avez aucun animaux pour l'instant.</p>
        @endif
    @endif


    @if($step == 1)

    <div class="bg-green-500 text-white p-6 rounded-lg shadow-md flex flex-col md:flex-row items-center justify-between mt-8">
        <div>
            <h2 class="text-2xl font-bold">Adoptez votre futur compagnon avec nos éleveurs partenaires !</h2>
            <p class="mt-2">Trouvez un éleveur près de chez vous et adoptez un animal en toute confiance.</p>
        </div>
        <a href="{{ route('find.breeder') }}"
           class="mt-4 md:mt-0 bg-white text-green-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200">
            Trouver un éleveur
        </a>
    </div>
    @endif



    <!-- Étape 2 : Choix de la spécialité -->
    @if($step === 2)
        <h2 class="text-2xl font-bold mb-6">Choisissez une spécialité</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @php
            $veto = \App\Models\Specialite::where('nom', 'Vétérinaire généraliste')->first();
            @endphp
            <!-- Vétérinaire généraliste -->
            <div
                wire:click="selectSpecialite({{ $veto->id }})"
                class="cursor-pointer bg-white rounded-lg shadow-md p-5 hover:shadow-lg transition transform hover:scale-105"
            >
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/specialities/1.jpg') }}" alt="Vétérinaire Généraliste" class="w-32 h-32 rounded-full object-cover mb-4">
                    <h2 class="text-xl font-bold text-gray-800 text-center mb-2">Vétérinaire Généraliste</h2>
                    <p class="text-gray-600 text-sm text-center">{{ $veto->description ?? 'Description non disponible.' }}</p>
                </div>
            </div>

            <!-- Groupe de vétérinaires spécialisés -->
            <div
                wire:click="selectSpecialite('veterinary_group')"
                class="cursor-pointer bg-white rounded-lg shadow-md p-5 hover:shadow-lg transition transform hover:scale-105"
            >
                <div class="flex flex-col items-center">
                    <img src="{{ asset('img/specialities/2.jpg') }}" alt="Vétérinaire Spécialisé" class="w-32 h-32 rounded-full object-cover mb-4">
                    <h2 class="text-xl font-bold text-gray-800 text-center mb-2">Vétérinaire Spécialisé</h2>
                    <p class="text-gray-600 text-sm text-center space-y-1">

                        <strong>Vétérinaire généraliste</strong>,
                        <strong>Dermatologie</strong> vétérinaire,
                        <strong>Cardiologie</strong> vétérinaire,
                        <strong>Chirurgie</strong> vétérinaire,
                        <strong>Dentisterie</strong> vétérinaire,
                        <strong>Ophtalmologie</strong> vétérinaire,
                        <strong>Orthopédie</strong> vétérinaire,
                        <strong>Neurologie</strong> vétérinaire,
                        <strong>Comportementaliste</strong> vétérinaire,
                        <strong>Anesthésiste</strong> vétérinaire,
                        <strong>Oncologie</strong> vétérinaire,
                        <strong>Auxiliaire</strong> vétérinaire,
                        <strong>Vétérinaire équin</strong>,
                        <strong>Cliniques d’urgence</strong> vétérinaire,
                        <strong>Médecine interne</strong> vétérinaire,
                        <strong>Auxiliaires</strong> vétérinaires.
                    </p>
                </div>
            </div>

            <!-- Autres spécialités non vétérinaires -->
            @foreach($specialites as $specialite)
                @if(!str_contains(strtolower($specialite->nom), 'vétérinaire') &&
                    !in_array($specialite->nom, [
                        'Soins à domicile', 'Spécialiste NAC', 'Services sauvetage animalier'
                    ]))
                    <div
                        wire:click="selectSpecialite({{ $specialite->id }})"
                        class="cursor-pointer bg-white rounded-lg shadow-md p-5 hover:shadow-lg transition transform hover:scale-105"
                    >
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('img/specialities/' . $specialite->id . '.jpg') }}" alt="{{ $specialite->nom }}" class="w-32 h-32 rounded-full object-cover mb-4">
                            <h2 class="text-xl font-bold text-gray-800 text-center">{{ $specialite->nom }}</h2>
                            <p class="text-gray-600 text-sm text-center">{{ $specialite->description ?? 'Description non disponible.' }}</p>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endif



    <!-- Étape 2.5 : Choisissez un type de vétérinaire -->
    @if($step === 2.5)
        <h2 class="text-2xl font-bold mb-6">Choisissez un type de vétérinaire</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($veterinarySpecialties as $specialite)
                <div
                    wire:click="selectVeterinarySpecialite({{ $specialite->id }})"
                    class="cursor-pointer bg-white rounded-lg shadow-md p-5 hover:shadow-lg transition transform hover:scale-105"
                >
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('img/specialities/' . $specialite->id . '.jpg') }}"
                             alt="{{ $specialite->nom }}"
                             class="w-32 h-32 rounded-full object-cover mb-4">
                        <h2 class="text-xl font-bold text-gray-800 text-center">{{ $specialite->nom }}</h2>
                        <p class="text-gray-600 text-sm text-center">{{ $specialite->description ?? 'Description non disponible.' }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


    <!-- Étape 3 : Choix du type de prestation -->
    @if($step === 3)
        <h2 class="text-2xl font-bold mb-6">Choisissez un type de prestation</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($serviceTypes as $serviceType)
                <div wire:click="selectServiceType({{ $serviceType->id }})" class="cursor-pointer bg-white shadow-md rounded-lg p-6 hover:shadow-lg">
                    <h3 class="text-xl font-bold">{{ $serviceType->libelle }}</h3>
                </div>
            @endforeach
        </div>
    @endif


    <!-- Étape 4 : Choix du service précis -->
    @if($step === 4)
        <h2 class="text-2xl font-bold mb-6">Précisez votre besoin</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($preciseServices as $service)
                <div wire:click="selectPreciseService({{ $service->id }})"
                     class="cursor-pointer bg-white shadow-md rounded-lg p-6 hover:shadow-lg">
                    <h3 class="text-xl font-bold">{{ $service->name }}</h3>
                    <p class="text-gray-600">{{ $service->description }}</p>
                </div>
            @endforeach
        </div>
    @endif


    <!-- Étape 4 : Raisons -->
    @if($step === 4)
        <h2 class="mt-5 text-2xl font-bold mb-6">Souhaitez vous ajouter des détails pour votre rendez vous ?</h2>
        <textarea wire:model="reason" class="w-full border rounded-lg p-4"></textarea>
    @endif

    <!-- Étape 5 : Géolocalisation -->
    @if($step === 5)
        <h2 class="text-2xl font-bold mb-6">Où voulez-vous chercher ?</h2>

        <!-- Champ de recherche d'adresse -->
        <div class="flex items-center mb-4" x-data="{ updating: false }">
            <input type="text" wire:model.live="userAddress" class="w-full border rounded-lg p-4" placeholder="Votre adresse">
            <button
                onclick="getLocation(); showUpdatingMessage();"
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
            <iframe
                class="w-full h-[400px] rounded-lg shadow-md"
                frameborder="0"
                src="https://www.openstreetmap.org/export/embed.html?bbox={{ $longitude - 0.05 }},{{ $latitude - 0.05 }},{{ $longitude + 0.05 }},{{ $latitude + 0.05 }}&layer=mapnik&marker={{ $latitude }},{{ $longitude }}">
            </iframe>
        </div>
    @endif


    <!-- Étape 6 : Propositions -->
    @if($step === 6)
        <h2 class="text-2xl font-bold mb-6">Propositions de rendez-vous</h2>

        <p class="font-bold mb-6">{{ count($services) }} résultats</p>

        <!-- Slider pour la distance -->
        <div class="mb-8">
            <label class="block text-gray-700 font-bold mb-2">Distance maximale (km) : {{ $maxDistance }}</label>
            <input type="range" wire:model.lazy="maxDistance" min="1" max="50" class="w-full">
        </div>

        <!-- Conteneur des propositions -->
        <div class="space-y-6">
            @foreach($services as $service)
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm flex flex-col lg:flex-row p-4 hover:shadow-md transition duration-300">
                    <!-- Partie gauche : Informations sur le professionnel -->
                    <div class="lg:w-1/3 flex flex-col items-center lg:items-start text-center lg:text-left p-4 border-r border-gray-200">
                        <a href="{{ route('profil', $service->user->id) }}" class="flex items-center space-x-4 mb-4">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-green-500">
                                <img src="{{ asset('storage/' . $service->user->profile_picture) }}" alt="Photo de {{ $service->user->name }}" class="object-cover w-full h-full">
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-green-700 hover:underline">{{ $service->user->name }}</h3>
                                <p class="text-gray-600 text-sm">{{ \App\Models\Specialite::find($this->specialiteId)->nom }}</p>
                            </div>
                        </a>

                        <p class="flex items-center text-gray-600 text-sm mb-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                            {{ $service->user->address }}
                        </p>

                        <div class="w-full mt-4">
                            <h4 class="text-lg font-semibold text-gray-700 mb-2">Choisissez votre formule :</h4>

                            <!-- Formule de base -->
                            <div class="p-4 bg-gray-50 border rounded-lg flex items-center mb-4">
                                <input type="radio"
                                       wire:model="selectedSpecializedService.{{ $service->id }}"
                                       id="base_{{ $service->id }}"
                                       value="null"
                                wire:change="updateSession({{ $service->id }})"
                                @if(isset($selectedSpecializedService[$service->id]) && $selectedSpecializedService[$service->id] === 'null') checked @endif>
                                <div class="ml-4">
                                    <label for="base_{{ $service->id }}" class="font-medium text-gray-700 cursor-pointer">Formule de base</label>
                                    <p class="text-gray-500 text-sm">{{ $service->description }}</p>
                                    <p class="text-green-700 font-bold">{{ $service->price }}€</p>
                                </div>
                            </div>


                            <!-- Prestations spécialisées -->
                            @if($service->specializedServices->count() > 0)
                                <h5 class="text-md font-semibold text-gray-600 mb-2">Prestations spécialisées :</h5>
                                <div class="space-y-3">
                                    @foreach($service->specializedServices as $specializedService)
                                        @php
                                            $animal = \App\Models\Animal::find($this->animalId);
                                            $isEligible = ($animal->poids >= $specializedService->min_weight && $animal->poids <= $specializedService->max_weight) &&
                                                          ($animal->hauteur >= $specializedService->min_height && $animal->hauteur <= $specializedService->max_height);
                                        @endphp
                                        @if($isEligible)
                                            <div class="p-4 bg-gray-50 border rounded-lg flex items-center">
                                                <input type="radio"
                                                       wire:model="selectedSpecializedService.{{ $service->id }}"
                                                       id="special_{{ $specializedService->id }}"
                                                       value="{{ $specializedService->id }}"
                                                       wire:change="updateSession({{ $service->id }})">
                                                <div class="ml-4">
                                                    <label for="special_{{ $specializedService->id }}" class="font-medium text-gray-700 cursor-pointer">{{ $specializedService->name }}</label>
                                                    <p class="text-gray-500 text-sm">{{ $specializedService->description }}</p>
                                                    <p class="text-green-700 font-bold">{{ $specializedService->price }}€</p>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Partie droite : Calendrier -->

                    <div class="lg:w-2/3 p-4">
                        @if(isset($selectedSpecializedService[$service->id]))
                            @livewire('calendar-availability', [
                            'service_id' => $service->id,
                            'animalID' => $animalId,
                            'specializedServiceId' => $selectedSpecializedService[$service->id] ?? null
                            ], key($service->id))
                        @else
                            <div class="flex items-center justify-center h-full bg-gray-100 text-gray-500 rounded-lg">
                                <p>Sélectionnez une formule pour voir les disponibilités.</p>
                            </div>
                        @endif
                    </div>

                </div>
            @endforeach

            @if(count($services) === 0)
                <p class="text-gray-500 text-center">Il n'y a pas de prestations disponibles actuellement.</p>
            @endif



                @if($vetoExternes->isNotEmpty())
                    <div class="mt-6 bg-gray-100 p-6 rounded-lg">
                        <h3 class="text-xl font-bold text-green-900">Vétérinaires Externes Disponibles</h3>
                        <p class="text-gray-600">Ces vétérinaires ne sont pas inscrits sur Doctopet, mais vous pouvez les contacter directement.</p>

                        <ul class="mt-4 space-y-4">
                            @foreach($vetoExternes as $veto)
                                @php
                                    $cabinetProche = $veto->cabinets->sortBy('distance')->first();
                                @endphp
                                <li class="bg-white p-4 shadow-md rounded-lg">
                                    <h4 class="text-lg font-bold text-green-700">{{ $veto->name }}</h4>
                                    <p class="text-gray-600">{{ $cabinetProche->nom }}, {{ $cabinetProche->adresse }}</p>
                                    <p class="text-gray-600">📞 {{ $cabinetProche->tel }}</p>
                                    <a href="tel:{{ $cabinetProche->tel }}" class="mt-2 inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                                        Appeler
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
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

<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-green-700 text-center mb-6">🔍 Résultats pour "{{ $speciality->nom }}"</h1>

    <!-- Formulaire de recherche par adresse -->

    @php
    $check = session()->get("come_from_searchbar");

    // Vient de la barre de recherche
    if(isset($check) && $check){
        session()->forget("come_from_searchbar");
    }
    @endphp

    <div class="flex flex-col md:flex-row items-center justify-center mb-6 space-y-4 md:space-y-0 md:space-x-4 @if($check) hidden   @endif ">
        <input type="text" wire:model="userAddress"
               class="w-full md:w-2/3 border p-3 rounded-lg shadow-md"
               placeholder="Entrez une adresse...">
        <button wire:click="updateCoordinatesFromAddress"
                class="bg-green-600 text-white px-4 py-2 rounded-md">
            📍 Rechercher
        </button>
    </div>



    <!-- Barre de filtre par distance -->
    <div class="flex items-center justify-center mb-6">
        <label class="block font-bold text-gray-700 mr-4">Distance : {{ $distance }} km</label>
        <input type="range" wire:model.lazy="distance" min="1" max="300" class="w-1/2">
    </div>

    <!-- Grid des résultats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
        <!-- Professionnels internes -->
        @foreach($specialistUsers as $user)
            <div class="bg-white p-8 shadow-lg rounded-lg flex flex-col">
                <!-- Infos du professionnel -->
                <a  class="flex items-center space-x-3">
                    <img src="{{ asset('storage/' . ($user->profile_picture ?? 'img/avatar/default_avatar.png')) }}"
                         class="w-12 h-12 rounded-full border-2 border-green-500">
                    <div>
                        <h2 class="text-lg font-bold text-green-700 mt-5">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm mb-5">📍 {{ $user->address ?? 'Adresse non renseignée' }}</p>
                    </div>
                </a>
                <a href="{{ route('profil', $user->id) }}"
                   class="mt-auto bg-green-600 text-white text-center py-2 px-4 rounded-md block hover:bg-green-700 transition">
                    📅 Prendre RDV
                </a>
            </div>
        @endforeach



        <!-- Vétérinaires externes -->
        @foreach($externalVeterinarians as $vet)
        @if($vet->nearestCabinet)
            <div class="bg-white p-8 shadow-lg rounded-lg flex flex-col">
                <!-- Infos vétérinaire externe -->
                <a href="#" class="flex items-center space-x-3">
                    <img src="{{ asset('img/avatar/default_avatar.png') }}"
                         class="w-12 h-12 rounded-full border-2 border-blue-500">
                    <div>
                        <h2 class="text-lg font-bold text-blue-700 mt-3">{{ $vet->name }}</h2>
                        <p class="text-gray-500 text-sm mb-2">📍 {{ $vet->nearestCabinet->adresse ?? 'Adresse non renseignée' }}</p>
                    </div>
                </a>

                <a href="tel:{{ $vet->nearestCabinet->tel ?? '#' }}"
                   class="mt-2 bg-green-600 text-white text-center py-2 px-4 rounded-md block hover:bg-green-700 transition">
                    📞 {{$vet->nearestCabinet->tel}}
                </a>

            </div>
        @endif
        @endforeach
    </div>
</div>

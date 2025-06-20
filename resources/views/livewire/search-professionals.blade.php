<div x-data="{ showDropdown: false }" class="container mx-auto bg-gray-100 px-4 py-8">
    <h1 class="text-4xl font-extrabold text-green-700 mb-8 text-center">📚 ANNUAIRE DES PROFESSIONNELS</h1>

    <!-- Barre de recherche avec Livewire & Alpine.js -->
    <div class="flex justify-center relative">
        <input type="text" wire:model.live="searchTerm"
               x-on:input="showDropdown = $event.target.value.length > 0"
               class="w-full max-w-xl p-4 rounded-full border border-gray-300 focus:outline-none focus:ring-4 focus:ring-green-500 shadow-lg"
               placeholder="🔎 Rechercher un professionnel par nom...">

        <!-- Prévisualisation des résultats -->
        <div x-show="showDropdown" @click.away="showDropdown = false"
             class="absolute top-full left-0 w-full max-w-xl mt-2 bg-white border border-gray-300 rounded-lg shadow-xl z-50">
            @if($professionals->isNotEmpty())
                <ul class="divide-y divide-gray-200">
                    @foreach($professionals as $professional)
                        <li class="px-4 py-3 hover:bg-green-100 cursor-pointer flex items-center space-x-3"
                            @click="window.location='{{ route('profil', $professional->id) }}'">
                            <img src="{{ $professional->profile_picture ? asset('storage/' . $professional->profile_picture) : asset('img/default_profile.png') }}"
                                 alt="{{ $professional->name }}" class="w-10 h-10 rounded-full shadow-md">
                            <span class="text-gray-700 font-medium">{{ $professional->name }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="px-4 py-3 text-gray-600 text-center">😿 Aucun professionnel trouvé.</p>
            @endif
        </div>
    </div>

    <!-- Affichage des résultats complets -->
    <div class="mt-10 transition-all duration-300" x-show="!showDropdown || '{{ $searchTerm }}' === ''">
        @if($professionals->isEmpty() && $searchTerm)
            <p class="text-center text-gray-600 text-lg">🔍 Aucun professionnel trouvé pour "{{ $searchTerm }}".</p>
        @elseif($professionals->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($professionals as $professional)
                    <div class="bg-white p-6 rounded-lg shadow-md text-center hover:shadow-lg transition transform hover:scale-105">
                        <img src="{{ $professional->profile_picture ? asset('storage/' . $professional->profile_picture) : asset('img/default_profile.png') }}"
                             alt="{{ $professional->name }}" class="w-24 h-24 rounded-full mx-auto mb-4 border-4 border-green-500 shadow-md">

                        <h3 class="text-2xl font-bold text-green-700 mb-2">{{ $professional->name }}</h3>

                        <!-- Affichage des spécialités -->
                        <div class="text-gray-600 text-sm space-y-1 mb-4">
                            @if($professional->specialites->isNotEmpty())
                                <p class="font-semibold text-green-600">🩺 Spécialités :</p>
                                @foreach($professional->specialites as $specialite)
                                    <p>• {{ $specialite->nom }}</p>
                                @endforeach
                            @else
                                <p class="text-gray-500">Spécialité non renseignée</p>
                            @endif
                        </div>

                        <a href="{{ route('profil', $professional->id) }}"
                           class="inline-block bg-green-600 text-white px-5 py-2 rounded-full hover:bg-green-700 transition shadow-lg">
                            Voir le profil
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-500 text-lg">💡 Commencez à taper pour rechercher des professionnels.</p>
        @endif
    </div>
</div>

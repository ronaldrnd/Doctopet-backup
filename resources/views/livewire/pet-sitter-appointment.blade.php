<div class="min-h-screen bg-gray-100 p-10 w-full" x-data="{ showResults: false }">
    <h1 class="text-3xl font-bold text-green-700 mb-6">Réservation chez un Pet-Sitter</h1>

    <!-- 🐾 Informations sélectionnées -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-bold text-gray-700 mb-2">Animal sélectionné :</h2>
        <p class="text-gray-600"><strong>Nom :</strong> {{ $animal->nom }}</p>
        <p class="text-gray-600"><strong>Espèce :</strong> {{ $animal->espece->nom }}</p>
        <p class="text-gray-600"><strong>Race :</strong> {{ $animal->race->nom }}</p>

        <h2 class="text-xl font-bold text-gray-700 mt-4">Service sélectionné :</h2>
        <p class="text-gray-600"><strong>Spécialité :</strong> {{ $specialite->nom }}</p>
        <p class="text-gray-600"><strong>Type de service :</strong> {{ $serviceType->libelle }}</p>
        <p class="text-gray-600"><strong>Service choisi :</strong> {{ $serviceTemplate->name }}</p>
    </div>

    <!-- 🔍 Recherche des Pet-Sitters -->
    <button wire:click="fetchAvailablePetSitters"
            x-on:click="showResults = true"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg w-full mb-6 hover:bg-blue-700 transition">
        Rechercher des Pet-Sitters disponibles
    </button>

    <!-- 📌 Résultats des Pet-Sitters (s'affichent dynamiquement) -->
    <div x-show="showResults">
        @if(count($availablePetSitters) > 0)
            <h2 class="text-xl font-bold text-gray-700 mt-4 mb-4">Pet-Sitters disponibles :</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($availablePetSitters as $petSitter)
                    <div wire:click="selectPetSitter({{ $petSitter->id }})"
                         class="cursor-pointer bg-white rounded-lg shadow-md p-5 hover:shadow-lg transition transform hover:scale-105">
                        <div class="flex flex-col items-center">
                            <img src="{{ $petSitter->profile_picture ? asset('storage/' . $petSitter->profile_picture) : asset('img/default_profile.png') }}"
                                 alt="{{ $petSitter->name }}"
                                 class="w-32 h-32 rounded-full object-cover mb-4 border-2 border-green-500">
                            <h2 class="text-xl font-bold text-gray-800 text-center mb-2">{{ $petSitter->name }}</h2>
                            <p class="text-gray-600 text-sm text-center">{{ $petSitter->address }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center mt-4">Aucun Pet-Sitter trouvé pour ce service.</p>
        @endif
    </div>

    @if($selectedPetSitter)
        <!-- 🏡 Pet-Sitter sélectionné -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-6">
            <h2 class="text-xl font-bold text-gray-700">Pet-Sitter sélectionné :</h2>
            <p class="text-gray-600"><strong>Nom :</strong> {{ $selectedPetSitter->name }}</p>
            <p class="text-gray-600"><strong>Adresse :</strong> {{ $selectedPetSitter->address }}</p>
        </div>



        <div class="text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4 mt-4">
                Semaine du {{ $currentWeek->startOfWeek()->translatedFormat('d F Y') }}
                au {{ $currentWeek->endOfWeek()->translatedFormat('d F Y') }}
            </h3>

            <div class="flex justify-between">
                <button wire:click="previousWeek"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg"
                        @if($currentWeek->lessThanOrEqualTo(Carbon\Carbon::now()->startOfWeek())) disabled @endif>
                    Semaine précédente
                </button>

                <button wire:click="nextWeek" class="px-4 py-2 bg-green-500 text-white rounded-lg">
                    Semaine suivante
                </button>
            </div>
        </div>



        <!-- 📅 Calendrier des créneaux -->
        @if(count($availableSlots) > 0)
            <h2 class="text-xl font-bold text-gray-700 mt-6">Choisissez un créneau :</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
                @foreach($availableSlots as $date => $slots)
                    <div class="border border-gray-300 rounded-lg shadow-md p-4 bg-white flex flex-col justify-between">
                        <h4 class="text-lg font-bold text-gray-800 mb-4 text-center">
                            {{ \Carbon\Carbon::parse($date)->translatedFormat('l d F') }}
                        </h4>
                        <div class="flex flex-col gap-2">
                            @foreach($slots as $slot)
                                <form method="POST" action="{{ route('rdv.confirm') }}">
                                    @csrf
                                    <input type="hidden" name="animalId" value="{{ $animalId }}">
                                    <input type="hidden" name="serviceId" value="{{ $slot['service_id'] }}">
                                    <input type="hidden" name="selectedSlot[date]" value="{{ $date }}">
                                    <input type="hidden" name="selectedSlot[start_time]" value="{{ $slot['start_time'] }}">
                                    <input type="hidden" name="selectedSlot[end_time]" value="{{ $slot['end_time'] }}">
                                    <button type="submit" class="w-full bg-green-100 py-2 rounded-lg mt-2">
                                        {{ $slot['start_time'] }} - {{ $slot['end_time'] }}
                                    </button>
                                </form>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- ✅ Confirmation -->
        <button wire:click="saveAppointment"
                class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-6 w-full hover:bg-blue-700 transition">
            Confirmer la réservation
        </button>
    @endif
</div>

<script>
    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
            @this.set('latitude', position.coords.latitude);
            @this.set('longitude', position.coords.longitude);
            });
        } else {
            alert("Géolocalisation non supportée par votre navigateur.");
        }
    }
</script>

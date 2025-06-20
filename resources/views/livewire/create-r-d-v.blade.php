<div class="min-h-screen bg-gray-100 p-10" x-data="{ selectedAnimalId: null, selectedSpecializedId: null , selectedSlot: { date: null, start_time: null } }">
    <div class="relative bg-white shadow-md rounded-lg p-8">
        <h1 class="text-3xl font-bold text-green-700 mb-6">
            Prendre rendez-vous pour <span class="text-blue-600">{{ $service->name }}</span>
        </h1>

        <!-- Vétérinaire Info -->
        <div class="bg-gradient-to-r from-green-50 to-white p-6 rounded-lg shadow-md mb-8">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('storage/' . $service->user->profile_picture) }}" alt="Profil vétérinaire"
                     class="w-16 h-16 rounded-full border border-gray-300">
                <div>
                    <h2 class="text-lg font-bold text-green-700">{{ $service->user->name }}</h2>
                    <p class="text-gray-500">Adresse : {{ $service->user->address ?? 'Non renseignée' }}</p>
                    <p class="text-gray-500">Téléphone : {{ $service->user->phone_number ?? 'Non renseigné' }}</p>
                </div>
            </div>
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            <!-- Choix de l'animal -->
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Choisissez votre animal</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($userAnimals as $animal)
                        <div wire:click="selectAnimal({{ $animal->id }})"
                             x-on:click="selectedAnimalId = {{ $animal->id }}"
                             class="p-4 border rounded-lg cursor-pointer hover:bg-gray-100 transition"
                             :class="{ 'border-green-500 bg-green-50': selectedAnimalId === {{ $animal->id }} }">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset($animal->photo) }}" alt="Photo de l'animal"
                                     class="w-16 h-16 rounded-full">
                                <div>
                                    <h4 class="font-bold text-gray-700">{{ $animal->nom }}</h4>
                                    <p class="text-gray-500">{{ $animal->race->nom }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @error('animalId') <span class="text-red-500">{{ $message }}</span> @enderror
            </div>

            <!-- Formules -->
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Choisissez une formule</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if(count($specializedServices) == 0)
                        <div
                            wire:click="selectFormula(null)"
                            x-on:click="selectedSpecializedId = null"
                            class="p-4 border rounded-lg transition cursor-not-allowed"
                            :class="{
        'border-green-500 bg-green-50': !specializedServiceId,
        'cursor-not-allowed opacity-50': {{ count($specializedServices) }} === 0
    }"
                        >
                            <h4 class="font-bold text-green-600">Formule de base</h4>
                            <p class="text-gray-600">Durée : {{ $service->duration }} min</p>
                            <p class="text-gray-600">Prix : {{ $service->price }} €</p>
                        </div>

                    @else
                    @foreach($specializedServices as $specialized)
                        <div wire:click="selectFormula({{ $specialized->id }})"
                             x-on:click="selectedSpecializedId = {{ $specialized->id }}"
                             class="p-4 border rounded-lg cursor-pointer hover:bg-gray-100 transition"
                             :class="{ 'border-blue-500 bg-blue-50': parseInt(selectedSpecializedId) == {{ $specialized->id }} }">
                            <h4 class="font-bold text-blue-600">{{ $specialized->name }}</h4>
                            <p class="text-gray-600">Durée : {{ $specialized->duration }} min</p>
                            <p class="text-gray-600">Prix : {{ $specialized->price }} €</p>
                        </div>
                    @endforeach
                    @endif
                </div>
            </div>

            <!-- Navigation Buttons for Week -->
            <div class="flex justify-between mb-6">
                <button wire:click="previousWeek" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                    Semaine précédente
                </button>
                <button wire:click="nextWeek" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300">
                    Semaine suivante
                </button>
            </div>

            <!-- Prochaines Disponibilités -->
            <div>
                <h3 class="text-lg font-bold text-gray-700 mb-2">Prochaines disponibilités</h3>
                @if(count($availableSlots) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($availableSlots as $slot)
                            <div wire:click="selectSlot('{{ $slot['date'] }}', '{{ $slot['start_time'] }}')"
                                 x-on:click="selectedSlot = { date: '{{ $slot['date'] }}', start_time: '{{ $slot['start_time'] }}' }"
                                 class="p-4 border rounded-lg cursor-pointer hover:bg-gray-100 transition"
                                 :class="{ 'border-green-500 bg-green-50': selectedSlot.start_time === '{{ $slot['start_time'] }}' && selectedSlot.date === '{{ $slot['date'] }}' }">
                                <h4 class="font-bold text-gray-700">
                                    {{ ucfirst(\Carbon\Carbon::parse($slot['date'])->translatedFormat('l j F Y')) }}
                                </h4>
                                <p class="text-gray-600">Heure : {{ $slot['start_time'] }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    @if(!$animalId && count($specializedServices) == 0)
                        <p class="text-green-500">Sélectionnez d'abord un animal.</p>
                    @elseif(!$animalId && count($specializedServices) > 0 && $specializedServiceId)
                        <p class="text-green-500">Sélectionnez d'abord un animal.</p>
                    @elseif($animalId && count($specializedServices) > 0 &&  !$specializedServiceId)
                        <p class="text-green-500">Sélectionnez une prestation spécialisée</p>
                    @elseif(!$animalId && count($specializedServices) > 0 &&  !$specializedServiceId)
                        <p class="text-green-500">Sélectionnez d'abord un animal puis une prestation spécialisée</p>
                    @else
                        <p class="text-red-500">Aucun créneau disponible pour les critères sélectionnés. Veuillez modifier votre sélection.</p>
                    @endif
                @endif
            </div>




            <!-- Message -->
            <div>
                <label for="message" class="block text-gray-700">Message</label>
                <textarea wire:model="message" id="message" class="w-full p-2 border rounded-lg"></textarea>
            </div>

            <button type="submit" wire:loading.attr="disabled" class="bg-green-600 text-white px-4 py-2 rounded-lg">
                Envoyer la demande de rendez-vous
            </button>

        </form>


    </div>

    <div wire:loading wire:target="submit" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 z-50">
        <img src="{{ asset('img/utils/loading.gif') }}" alt="Chargement..." class="h-20 w-20">
    </div>

</div>

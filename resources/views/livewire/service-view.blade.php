<div class="min-h-screen bg-gray-100 p-10 w-full">
    <h1 class="text-3xl font-bold text-green-700 mb-6 text-center">🛠️ Mon service : {{$name}}</h1>

    <!-- Formulaire d'ajout -->
    <div  class="mb-8">

        <div x-show="open" x-transition class="mt-6 bg-white shadow p-6 rounded-lg">
            <form wire:submit.prevent="updateService">

                <!-- Informations du service -->
                <div class="mt-6 space-y-6">
                    <label class="font-bold text-gray-700">🏷️ Nom de la prestation</label>
                    <input type="text" wire:model="name" placeholder="Ex: Consultation vétérinaire" class="w-full p-3 border rounded-lg ">

                    <label class="font-bold text-gray-700">📝 Description</label>
                    <textarea wire:model="description" placeholder="Détaillez votre service ici..." class="w-full p-3 border rounded-lg"></textarea>

                    <label class="font-bold text-gray-700">💰 Prix (€)</label>
                    <input type="number" wire:model="price" placeholder="Ex: 50" class="w-full p-3 border rounded-lg">

                    <label class="font-bold text-gray-700">⏳ Durée (minutes)</label>
                    <input type="number" wire:model="duration" placeholder="Ex: 30" class="w-full p-3 border rounded-lg">
                </div>

                <!-- Sélection des espèces interdites -->
                <h3 class="text-lg font-bold mt-6">🚫 Espèces non autorisées</h3>
                <p class="text-sm text-gray-600 italic">Si votre service ne s'applique pas à certaines espèces, sélectionnez-les ici.</p>
                <div class="flex flex-wrap mt-2">
                    @foreach($especes as $espece)
                        <label class="flex items-center mr-4">
                            <input type="checkbox" wire:model="excludedSpecies" value="{{ $espece->id }}" class="mr-2">
                            {{ $espece->emoji }} {{ $espece->nom }}
                        </label>
                    @endforeach
                </div>

                <!-- Formules spécialisées -->
                <h3 class="text-lg font-bold mt-6">⚖️ Paramétrage de la formule</h3>
                <p class="italic text-gray-600">
                    Permet d'ajuster le prix et la durée en fonction du poids et de la taille de l'animal.
                    Cliquez sur <span class="underline">Ajouter une plage</span> pour créer des variantes.
                </p>

                <div class="space-y-4">
                    <table class="w-full border-collapse border border-gray-300 rounded-lg">
                        <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">Poids Min (kg)</th>
                            <th class="p-2 border">Poids Max (kg)</th>
                            <th class="p-2 border">Taille Min (cm)</th>
                            <th class="p-2 border">Taille Max (cm)</th>
                            <th class="p-2 border">Prix (€)</th>
                            <th class="p-2 border">Durée (min)</th>
                            <th class="p-2 border"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($specializedServices as $index => $specializedService)
                            <tr>
                                <td class="border p-2"><input type="number" wire:model="specializedServices.{{ $index }}.min_weight" class="w-full p-2 border rounded-lg"></td>
                                <td class="border p-2"><input type="number" wire:model="specializedServices.{{ $index }}.max_weight" class="w-full p-2 border rounded-lg"></td>
                                <td class="border p-2"><input type="number" wire:model="specializedServices.{{ $index }}.min_height" class="w-full p-2 border rounded-lg"></td>
                                <td class="border p-2"><input type="number" wire:model="specializedServices.{{ $index }}.max_height" class="w-full p-2 border rounded-lg"></td>
                                <td class="border p-2"><input type="number" wire:model="specializedServices.{{ $index }}.price" class="w-full p-2 border rounded-lg"></td>
                                <td class="border p-2"><input type="number" wire:model="specializedServices.{{ $index }}.duration" class="w-full p-2 border rounded-lg"></td>
                                <td class="border p-2 text-center">
                                    <button type="button" wire:click="removeSpecializedService({{ $index }})" class="bg-red-600 text-white px-3 py-1 rounded-lg">🗑</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <button type="button" wire:click="addSpecializedService" class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4">
                        ➕ Ajouter une plage
                    </button>
                </div>

                <!-- Horaires disponibles -->
                <h3 class="text-lg font-bold mt-6">📅 Horaires disponibles</h3>
                <div x-data="calendar(@entangle('schedules'), () => { hasUnsavedChanges = true })" class="flex gap-2 bg-gray-50 border rounded-lg p-4">
                    <div class="flex flex-col border-r pr-2 text-right">
                        @for($hour = 8; $hour <= 23; $hour++)
                            <div class="h-16 flex items-center justify-end text-sm text-gray-600">
                                {{ sprintf('%02d:00', $hour) }}
                            </div>
                            <div class="h-16 flex items-center justify-end text-sm text-gray-600">
                                {{ sprintf('%02d:30', $hour) }}
                            </div>
                        @endfor
                    </div>

                    @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                        <div class="flex flex-col flex-1">
                            <span class="text-center font-bold mb-2">{{ $day }}</span>
                            @for($hour = 8; $hour <= 23; $hour++)
                                @php $timeSlot = sprintf('%02d:00', $hour); @endphp
                                <div
                                    x-on:click="toggleSelection('{{ $day }}', '{{ $timeSlot }}')"
                                    class="h-16 border-b border-gray-300 cursor-pointer hover:bg-red-100 transition"
                                    :class="{ 'bg-red-500': isSelected('{{ $day }}', '{{ $timeSlot }}') }">
                                </div>
                                @php $timeSlot = sprintf('%02d:30', $hour); @endphp
                                <div
                                    x-on:click="toggleSelection('{{ $day }}', '{{ $timeSlot }}')"
                                    class="h-16 border-b border-gray-300 cursor-pointer hover:bg-red-100 transition"
                                    :class="{ 'bg-red-500': isSelected('{{ $day }}', '{{ $timeSlot }}') }">
                                </div>
                            @endfor
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg w-full mt-6">
                    ✅ Enregistrer la prestation
                </button>
            </form>
        </div>
    </div>


    <script>
        function calendar(initialSchedules, onChangeCallback) {
            return {
                selectedSlots: initialSchedules || {},

                toggleSelection(day, time) {
                    time = time + ":00";

                    if (!this.selectedSlots[day]) {
                        this.selectedSlots[day] = [];
                    }

                    const index = this.selectedSlots[day].indexOf(time);
                    if (index === -1) {
                        this.selectedSlots[day].push(time);
                    } else {
                        this.selectedSlots[day].splice(index, 1);
                    }

                @this.set('schedules', this.selectedSlots);
                    if (onChangeCallback) onChangeCallback();
                },

                isSelected(day, time) {
                    time = time + ":00";
                    return this.selectedSlots[day]?.includes(time) || false;
                },
            };
        }
    </script>


    <style>
        .bg-red-500 {
            transition: background-color 0.3s ease;
        }
        .hover\:bg-red-100:hover {
            transition: background-color 0.3s ease;
        }
    </style>
</div>

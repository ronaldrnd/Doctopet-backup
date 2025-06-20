<div class="min-h-screen bg-gray-100 p-10 w-fill-available">

    <!-- Formulaire d'ajout -->
    <div class="min-h-screen bg-gray-100 p-10 w-fill-available">
        <h1 class="text-3xl font-bold text-green-700 mb-6">Gérer mes Prestations</h1>

        <!-- Formulaire d'ajout -->
        <div x-data="{ open: false }" class="mb-8">
            <button @click="open = !open" class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold">
                Ajouter une prestation
            </button>

            <div x-show="open" x-transition class="mt-4 bg-white shadow p-6 rounded-lg">
                <form wire:submit.prevent="saveService">
                    <!-- Explication des modèles -->
                    <p class="text-gray-600 italic mb-3">
                        <strong>📌 Les modèles sont là pour vous aider</strong> : ils proposent des prestations courantes,
                        mais vous êtes libre de définir votre propre service.
                        <!-- Sélection d'un modèle de service -->
                        <label class="font-bold text-gray-700 mt-4">📖 Exemple de services DoctoPet</label>
                        <select wire:model="selectedServiceTemplate" wire:change="applyServiceTemplate($event.target.value)"
                                class="w-full p-2 border rounded-lg bg-gray-100 focus:ring-2 focus:ring-green-500">
                            <option value="">Sélectionnez un modèle</option>
                            @foreach($serviceTemplates as $template)
                                <option value="{{ $template->id }}">{{ $template->name }}</option>
                            @endforeach
                        </select>
                    <p class="text-gray-500 text-sm italic mt-1">
                        Ces modèles sont là pour vous guider, mais vous pouvez modifier librement votre prestation.
                    </p>


                    </p>



                    <!-- Nom du service -->
                    <label class="font-bold text-gray-700 mt-4">Nom de la prestation</label>
                    <input type="text" wire:model="name" placeholder="Nom de la prestation"
                           class="w-full p-2 border rounded-lg">

                    <!-- Description -->
                    <label class="font-bold text-gray-700 mt-4">Description de la prestation</label>
                    <textarea wire:model="description" placeholder="Description"
                              class="w-full p-2 border rounded-lg"></textarea>

                    <!-- Prix -->
                    <label class="font-bold text-gray-700 mt-4">Prix (€)</label>
                    <input type="number" wire:model="price" placeholder="Prix (€)"
                           class="w-full p-2 border rounded-lg">

                    <!-- Durée -->
                    <label class="font-bold text-gray-700 mt-4">Durée (minutes)</label>
                    <input type="number" wire:model="duration" placeholder="Durée (minutes)"
                           class="w-full p-2 border rounded-lg">

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

                    <!-- Paramétrage de la formule -->
                    <h3 class="text-lg font-bold mt-6">⚖️ Paramétrage de la formule</h3>
                    <p class="italic mt-2 mb-2">
                        Ce paramètre permet d'ajuster le prix et la durée en fonction du poids et de la taille de l'animal.<br>
                        Appuyez sur le bouton <span class="underline">Ajouter une plage</span> pour configurer différentes options.
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
                                        <button type="button" wire:click="removeSpecializedService({{ $index }})" class="bg-red-600 text-white px-3 py-1 rounded-lg">Supprimer</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <button type="button" wire:click="addSpecializedService" class="bg-blue-600 text-white px-4 py-2 rounded-lg mt-4">
                            Ajouter une plage
                        </button>
                    </div>

                    <!-- Horaires disponibles -->
                    <div class="flex gap-2 bg-gray-50 border rounded-lg p-4">
                        <!-- Heures -->
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

                        <!-- Jours de la semaine -->
                        @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                            <div class="flex flex-col flex-1">
                                <span class="text-center font-bold mb-2">{{ $day }}</span>
                                @for($hour = 8; $hour <= 23; $hour++)
                                    @php $timeSlot = sprintf('%02d:00', $hour); @endphp
                                    <div wire:click="toggleSlot('{{ $day }}', '{{ $timeSlot }}')"
                                         class="h-16 border-b border-gray-300 cursor-pointer hover:bg-green-100 transition"
                                         :class="{ 'bg-green-500': @js(isset($schedules[$day]) && in_array($timeSlot, $schedules[$day])) }">
                                    </div>
                                    @php $timeSlot = sprintf('%02d:30', $hour); @endphp
                                    <div wire:click="toggleSlot('{{ $day }}', '{{ $timeSlot }}')"
                                         class="h-16 border-b border-gray-300 cursor-pointer hover:bg-green-100 transition"
                                         :class="{ 'bg-green-500': @js(isset($schedules[$day]) && in_array($timeSlot, $schedules[$day])) }">
                                    </div>
                                @endfor
                            </div>
                        @endforeach
                    </div>


                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-lg w-full mt-4">
                        Créer la prestation
                    </button>
                </form>
            </div>
        </div>
    </div>




    <!-- Liste des prestations -->
    <h1 class="text-3xl font-bold text-green-700 mb-6 mt-6">Vos Prestations</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10">
        @foreach($services as $service)
            <div class="bg-white shadow rounded-lg p-6">
                <a href="{{route('professional.service', $service->id)}}">
                    <h3 class="text-xl font-bold text-green-700">{{ $service->name }}</h3>
                    <p class="text-gray-600">{{ $service->description }}</p>
                    <p class="text-gray-600 mt-2"><strong>Durée :</strong> {{ $service->duration }} minutes</p>
                    <p class="text-gray-600"><strong>Prix :</strong> {{ $service->price }} €</p>

                    @if($service->specializedServices->isNotEmpty())
                        <div class="mt-4">
                            <h4 class="text-lg font-bold text-blue-600">Formules spécialisées :</h4>
                            <div class="mt-2 space-y-4">
                                @foreach($service->specializedServices as $specialized)
                                    <div class="p-4 bg-gray-50 rounded-lg border">
                                        <h5 class="text-md font-bold text-blue-700">{{ $specialized->name }}</h5>
                                        <p class="text-gray-600"><strong>Durée :</strong> {{ $specialized->duration }} minutes</p>
                                        <p class="text-gray-600"><strong>Prix :</strong> {{ $specialized->price }} €</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </a>

                <!-- Bouton d'activation/désactivation -->
                <div class="mt-4">
                    <button wire:click="toggleServiceStatus({{ $service->id }})"
                            class="px-4 py-2 rounded-lg text-white font-bold
                               {{ $service->is_enabled ? 'bg-green-600 hover:bg-green-700' : 'bg-gray-500 hover:bg-gray-600' }}">
                        {{ $service->is_enabled ? '✅ Service Activé' : '🚫 Service Désactivé' }}
                    </button>
                </div>
            </div>
        @endforeach
    </div>





    <div class="mt-10 bg-white shadow p-6 rounded-lg">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Faire une demande de nouveau service</h2>

        <label class="font-bold text-gray-700 mt-4">Nom du service demandé</label>
        <input type="text" wire:model="requested_name" placeholder="Nom du service" class="w-full p-2 border rounded-lg">

        <label class="font-bold text-gray-700 mt-4">Description</label>
        <textarea wire:model="requested_description" placeholder="Description" class="w-full p-2 border rounded-lg"></textarea>

        <label class="font-bold text-gray-700 mt-4">Prix suggéré (€)</label>
        <input type="number" wire:model="requested_price" placeholder="Prix" class="w-full p-2 border rounded-lg">

        <label class="font-bold text-gray-700 mt-4">Durée suggérée (minutes)</label>
        <input type="number" wire:model="requested_duration" placeholder="Durée" class="w-full p-2 border rounded-lg">

        <button wire:click="requestNewService" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
            Envoyer la demande
        </button>
    </div>


    <style>
        .bg-green-500 {
            transition: background-color 0.3s ease;
        }
        .hover\:bg-green-100:hover {
            transition: background-color 0.3s ease;
        }
    </style>




</div>

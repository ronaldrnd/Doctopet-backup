<div class="w-full bg-gray-100 py-6 px-4 md:px-8"
     x-data="{
        selectedAppointment: null,
        isAffiche: false,
        showDeleteModal: false,
        showAddExternalModal: false,
        showDeleteExternalModal: false,


        showAppointment(appointment) {
            this.selectedAppointment = appointment;
            this.isAffiche = true;
        }
     }">

    @php
        use Jenssegers\Agent\Agent;
        $agent = new Agent();
        $isMobile = $agent->isMobile();
    @endphp



    <h2 class="text-3xl font-bold text-green-700 mb-6 flex items-center">
        📅 Agenda de la semaine {{ $currentWeekStart->format('d M') }} - {{ $currentWeekStart->copy()->endOfWeek()->format('d M Y') }}
    </h2>

    <!-- Navigation semaine précédente/suivante -->
    <div class="flex justify-between mb-4">
        <button wire:click="previousWeek" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
            ⬅️ Semaine précédente
        </button>
        <button wire:click="nextWeek" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700">
            Semaine suivante ➡️
        </button>
        <button @click="showAddExternalModal = true" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
            ➕ Ajouter un RDV pro
        </button>
    </div>


    @if(!$isMobile)
        <!-- 🖥️ Mode Desktop -->
        <div class="grid grid-cols-8 border border-gray-300 bg-white shadow-md rounded-md overflow-hidden">
            <div class="bg-green-600 text-white font-bold p-3 border-r border-gray-300 text-center">Heures</div>
            @foreach (range(0, 6) as $dayOffset)
                @php
                    $dayKey = $currentWeekStart->copy()->addDays($dayOffset)->format('Y-m-d 00:00:00');
                @endphp
                <div class="bg-green-600 text-white font-bold p-3 text-center border-r border-gray-300">
                    {{ \Carbon\Carbon::parse($dayKey)->translatedFormat('D d M') }}
                </div>
            @endforeach

            @foreach (range(8, 22) as $hour)
                <div class="p-3 border-b border-gray-300 font-bold text-gray-700 text-center">
                    {{ $hour }}h - {{ $hour+1 }}h
                </div>

                @foreach (range(0, 6) as $dayOffset)
                    @php
                        $date_ext = $currentWeekStart->copy()->addDays($dayOffset)->format('Y-m-d');
                        $date = $currentWeekStart->copy()->addDays($dayOffset)->format('Y-m-d 00:00:00');
                        $hourFormatted = str_pad($hour, 2, "0", STR_PAD_LEFT) . ':00:00';
                                $allAppointments = collect($appointments[$date] ?? [])->merge($appointments[$date_ext] ?? []);
                    @endphp



                    <div class="border p-2 relative min-h-full">
                        @if(array_key_exists($date_ext, $appointments) || isset($appointments[$date]))
                            @foreach ($allAppointments  as $appointment)
                                @php
                                    $appointmentStartHour = \Carbon\Carbon::parse($appointment['start_time'])->hour;
$appointmentStartMinutes = \Carbon\Carbon::parse($appointment['start_time'])->minute;

// Vérifier que le rendez-vous commence bien dans cette heure
$isinside = ($appointmentStartHour == $hour);

                                @endphp

                                @if ($isinside)
                                    <div class="flex flex-col items-start p-2 rounded shadow-md w-full
@if(isset($appointment['client_name']))
    bg-green-200 border-l-4 border-green-600
@elseif(isset($appointment['status']) && $appointment['status'] === 'confirmed')
    bg-green-200 border-l-4 border-green-600
@elseif(isset($appointment['status']) && $appointment['status'] === 'pending')
    bg-yellow-200 border-l-4 border-yellow-500
@else
    bg-red-200 border-l-4 border-red-600
@endif">
                                        {{-- 🔥 Vérification si c'est un rendez-vous externe --}}
                                        @if(isset($appointment['client_name']))
                                            <p class="text-xs font-bold truncate break-words whitespace-normal">👤 {{ $appointment['client_name'] }}</p>
                                            <p class="text-xs break-words whitespace-normal">🐾 {{ $appointment['animal_name'] ?? 'Sans animal' }}</p>
                                        @else
                                            <p class="text-xs font-bold truncate break-words whitespace-normal">🐾 {{ $appointment['animal']['nom'] ?? 'Inconnu' }}</p>
                                            <p class="text-xs break-words whitespace-normal">🩺 {{ $appointment['service']['name'] ?? 'Sans service' }}</p>
                                        @endif
                                        <p class="text-xs">⏰ {{ \Carbon\Carbon::parse($appointment['start_time'])->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment['end_time'])->format('H:i') }}</p>


                                        @if(isset($appointment['client_name']))
                                            <!-- Bouton Supprimer pour RDV Externe -->
                                            <button @click="externalAppointmentToDelete = {{ $appointment['id'] }}; showDeleteExternalModal = true"
                                                    class="text-xs bg-purple-600 text-white px-2 py-1 rounded hover:bg-purple-700 transition">
                                                🗑 Supprimer
                                            </button>
                                        @else
                                            <!-- Bouton Voir et Supprimer pour RDV normal -->
                                            <a href="{{ route('appointments.show', $appointment['id']) }}"
                                               class="mt-1 text-xs bg-green-600 text-white px-2 py-1 rounded hover:bg-green-700 transition">
                                                Voir
                                            </a>

                                            <button @click="appointmentToDelete = {{ $appointment['id'] }}; showDeleteModal = true"
                                                    class="text-xs bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700 transition">
                                                🗑 Supprimer
                                            </button>
                                        @endif

                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                @endforeach
            @endforeach
        </div>
    @else
        <!-- 📱 Mode Mobile -->
        <div class="space-y-4">
            @foreach ($appointments as $date => $dayAppointments)
                <div class="bg-white shadow-md p-4 rounded-md">
                    <h3 class="text-lg font-bold text-green-700 mb-3">
                        📆 {{ \Carbon\Carbon::parse($date)->translatedFormat('D d M') }}
                    </h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($dayAppointments as $appointment)
                            <button @click="showAppointment({{ json_encode($appointment) }})"
                                    class="w-8 h-8 md:w-10 md:h-10 rounded-full text-white font-bold flex items-center justify-center
@if($appointment['status'] === 'confirmed') bg-green-500
@elseif($appointment['status'] === 'pending') bg-yellow-500
@else bg-red-500
@endif">
                                🏥
                            </button>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <!-- 📌 Pop-up d'affichage des détails -->
    <div x-show="isAffiche" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300"
         @click.away="isAffiche = false">
        <div class="bg-white p-6 rounded-md shadow-lg max-w-sm w-full">
            <h3 class="text-xl font-bold text-green-700 mb-3">Détails du rendez-vous</h3>

            <p><strong>🐾 Animal :</strong>
                <span x-text="selectedAppointment?.animal?.nom ?? 'Inconnu'"></span>
            </p>
            <p><strong>🩺 Service :</strong>
                <span x-text="selectedAppointment?.service?.name ?? 'Inconnu'"></span>
            </p>
            <p><strong>⏰ Horaire :</strong>
                <span x-text="selectedAppointment?.start_time ?? 'Non défini'"></span> -
                <span x-text="selectedAppointment?.end_time ?? 'Non défini'"></span>
            </p>

            <a :href="'/appointments/' + (selectedAppointment?.id ?? '')"
               class="mt-4 block bg-green-600 text-white px-4 py-2 rounded text-center hover:bg-green-700 transition">
                Voir rendez-vous
            </a>
            <button @click="isAffiche = false" class="mt-2 text-red-500 font-bold">Fermer</button>
        </div>
    </div>

    <div x-show="showDeleteModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-md shadow-lg max-w-sm w-full">
            <h3 class="text-xl font-bold text-red-700 mb-3">Confirmer l'annulation</h3>
            <p class="text-gray-700 text-sm">Indiquez un motif pour l'annulation (facultatif) :</p>
            <textarea x-model="reason" class="w-full p-2 border rounded mt-2"></textarea>

            <div class="flex justify-between mt-4">
                <button @click="showDeleteModal = false" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuler
                </button>
                <button @click="$wire.cancelAppointment(appointmentToDelete, reason); showDeleteModal = false"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Oui, annuler
                </button>
            </div>
        </div>
    </div>


    <div x-show="showDeleteExternalModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white p-6 rounded-md shadow-lg max-w-sm w-full">
            <h3 class="text-xl font-bold text-red-700 mb-3">Confirmer la suppression</h3>
            <p class="text-gray-700 text-sm">Voulez-vous vraiment supprimer ce rendez-vous externe ? Cette action est irréversible.</p>

            <div class="flex justify-between mt-4">
                <button @click="showDeleteExternalModal = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Annuler
                </button>
                <button @click="$wire.deleteExternalAppointment(externalAppointmentToDelete); showDeleteExternalModal = false"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
                    Oui, supprimer
                </button>
            </div>
        </div>
    </div>


    <div x-show="showAddExternalModal" x-cloak class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 overflow-y-auto px-4">
        <div class="bg-white p-8 rounded-lg shadow-2xl w-full max-w-4xl">
            <h3 class="text-2xl font-bold text-green-700 mb-6 text-center">Ajouter un rendez-vous professionnel</h3>

            <form wire:submit.prevent="addExternalAppointment">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="block text-sm font-semibold mb-1">Nom du patient</label>
                        <input type="text" wire:model.defer="externalClientName" class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Adresse email du patient</label>
                        <input type="email" wire:model.defer="externalEmail" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Téléphone du patient</label>
                        <input type="text" wire:model.defer="externalPhone" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Service</label>
                        <select wire:model.defer="externalServiceId" class="w-full border rounded p-2">
                            <option value="">-- Sélectionner un service --</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Nom de l’animal</label>
                        <input type="text" wire:model.defer="externalAnimalName" class="w-full border rounded p-2">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Espèce</label>
                        <select wire:model="externalSpeciesId" wire:change="updateRaces($event.target.value)" class="w-full border rounded p-2">
                            <option value="">-- Choisir une espèce --</option>
                            @foreach($speciesList as $espece)
                                <option value="{{ $espece->id }}">{{ $espece->nom }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-data="{ speciesSelected: @entangle('externalSpeciesId') }">
                        <label class="block text-sm font-semibold mb-1">Race</label>
                        <select wire:model="externalBreedId"
                                class="w-full border rounded p-2 bg-white">
                            <option value="">-- Choisir une race --</option>
                            @foreach($breedList as $race)
                                <option value="{{ $race->id }}">{{ $race->nom }}</option>
                            @endforeach
                        </select>
                    </div>


                    <div>
                        <label class="block text-sm font-semibold mb-1">Date</label>
                        <input type="date" wire:model.defer="externalDate" class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Heure début</label>
                        <input type="time" wire:model.defer="externalStartTime" class="w-full border rounded p-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold mb-1">Heure fin</label>
                        <input type="time" wire:model.defer="externalEndTime" class="w-full border rounded p-2" required>
                    </div>
                </div>

                <div class="flex justify-between mt-8">
                    <button type="button" @click="showAddExternalModal = false"
                            class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit"
                            @click="showAddExternalModal = false"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Ajouter le RDV
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

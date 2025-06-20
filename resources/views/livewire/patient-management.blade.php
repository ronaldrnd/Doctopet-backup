<div class="p-6 bg-gray-100 w-fill-available">
    <h1 class="text-3xl font-bold mb-6 text-green-700">Gestion des Patients</h1>

    <!-- Barre de recherche -->
    <div class="mb-4">
        <input type="text" wire:model.live="searchTerm"
               placeholder="Rechercher un patient..."
               class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Liste des patients -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Patients</h2>

            @forelse($filteredPatients as $patient)
                <div class="flex items-center p-3 border-b hover:bg-gray-50 transition cursor-pointer">
                    <img src="{{ $patient->profile_picture ? asset('storage/' . $patient->profile_picture) : asset('img/default_profile.png') }}"
                         alt="Photo de {{ $patient->name }}"
                         class="w-12 h-12 rounded-full object-cover border-2 border-green-500 shadow">
                    <div class="ml-4">
                        <span class="text-lg font-medium text-gray-700">{{ $patient->name }}</span>
                    </div>
                    <button wire:click="selectPatient({{ $patient->id }})"
                            class="ml-auto px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Voir
                    </button>
                </div>
            @empty
                <p class="text-gray-500 text-center mt-4">Aucun patient trouvé.</p>
            @endforelse
        </div>

        <!-- Détails du patient sélectionné -->
        @if($selectedPatient)
            <div class="md:col-span-2 bg-white shadow rounded-lg p-6">
                <div class="flex items-center mb-6">
                    <img src="{{ $selectedPatient->profile_picture ? asset('storage/' . $selectedPatient->profile_picture) : asset('img/default_profile.png') }}"
                         alt="Photo de {{ $selectedPatient->name }}"
                         class="w-20 h-20 rounded-full object-cover border-2 border-green-500 shadow">
                    <div class="ml-4">
                        <h2 class="text-2xl font-bold text-gray-800">{{ $selectedPatient->name }}</h2>
                        <p class="text-gray-600">{{ $selectedPatient->email }}</p>
                    </div>
                </div>



                <h3 class="text-xl mt-4 mb-2 font-bold text-green-700">Historique des Rendez-vous</h3>

                @if($this->paginatedAppointments->isNotEmpty())
                    <div class="space-y-4">
                        @foreach($this->paginatedAppointments as $appointment)
                            <div class="p-4 bg-gray-50 rounded-lg shadow-sm border border-gray-200">
                                <p class="text-lg font-semibold text-gray-800 flex items-center">
                                    🩺 {{ $appointment->type === 'externe' ? $appointment->service->name : ($appointment->specialized_service_id ? $appointment->specializedService->name : $appointment->service->name) }}
                                </p>
                                <div class="mt-2 text-gray-700 space-y-1">
                                    <p class="flex items-center">
                                        🗓️ <strong class="ml-2 mr-2">Date :</strong>
                                        {{ \Carbon\Carbon::parse($appointment->date)->translatedFormat('l j F Y') }}
                                    </p>
                                    <p class="flex items-center">
                                        ⏰ <strong class="ml-2 mr-2">Heure :</strong>
                                        {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                    </p>
                                    <p class="flex items-center">
                                        🐾 <strong class="ml-2 mr-2">Animal :</strong>
                                        {{ $appointment->type === 'externe' ? $appointment->animal_name : $appointment->animal->nom }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button wire:click="previousPage"
                            class="px-4 py-2 bg-gray-300 rounded {{ $appointmentPage <= 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                            @if($appointmentPage <= 1) disabled @endif>
                        ← Précédent
                    </button>

                    <span class="text-sm text-gray-600">
    Page {{ $appointmentPage }} sur {{ $this->totalPages }}
</span>

                    <button wire:click="nextPage"
                            class="px-4 py-2 bg-gray-300 rounded {{ $appointmentPage >= $this->totalPages ? 'opacity-50 cursor-not-allowed' : '' }}"
                            @if($appointmentPage >= $this->totalPages) disabled @endif>
                        Suivant →
                    </button>


                @else
                    <p class="text-gray-500">Aucun rendez-vous enregistré avec ce patient.</p>
                @endif




                <h3 class="text-xl mt-4 mb-2 font-bold text-green-700">Animaux</h3>
                @foreach($selectedPatient->animaux as $animal)
                    <div class="mb-6 bg-gray-50 p-4 rounded-lg shadow-sm">
                        <div class="flex items-center">
                            @if($animal->photo)
                                <img src="{{ asset($animal->photo) }}" alt="Photo de {{ $animal->nom }}"
                                     class="w-24 h-24 rounded-full object-cover border-2 border-green-500 shadow">
                            @else
                                @php
                                    if(isset($animal->race))
                                        $isFind = file_exists(public_path('img/races/' . $animal->race->nom . '.png'));
                                    else
                                        $isFind = null;
                                @endphp
                                <img src=" {{asset( $isFind ?  'img/races/' . $animal->race->nom . '.png' : 'img/races/default.png')}}" alt="Photo de {{ $animal->nom }}"
                                     class="w-24 h-24 rounded-full object-cover border-2 border-gray-300 shadow">
                            @endif
                            <div class="ml-4">
                                <p class="text-lg font-bold text-gray-800">{{ $animal->nom }}</p>
                                <p class="text-gray-600">Espèce : {{ $animal->espece->nom }}</p>
                                <p class="text-gray-600">Race : {{ $animal->race->nom ?? 'Non spécifiée' }}</p>
                                <p class="text-gray-600">Date de naissance : {{ \Carbon\Carbon::parse($animal->date_naissance)->format('d/m/Y') }}</p>
                                <p class="text-gray-600">Poids : {{ $animal->poids }} kg</p>
                                <p class="text-gray-600">Taille : {{ $animal->taille }} cm</p>
                                    <div class="mt-2">
                                        <label for="historique-{{ $animal->id }}" class="text-sm font-semibold">📝 Historique médical</label>
                                        <textarea
                                            id="historique-{{ $animal->id }}"
                                            wire:model.defer="editAnimalMedicalHistory.{{ $animal->id }}"
                                            class="w-full p-2 mt-1 border rounded shadow-sm"
                                            rows="3"
                                        ></textarea>


                                        <button wire:click="updateMedicalHistory({{ $animal->id }})"
                                                class="mt-2 px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                                            💾 Sauvegarder
                                        </button>
                                    </div>

                            </div>
                        </div>

                        <!-- Vaccins -->
                        <h4 class="text-lg mt-4 font-bold text-gray-700">Carnet de Vaccination</h4>
                        @if($animal->vaccins->isNotEmpty())
                            <ul class="list-disc ml-5 text-gray-700">
                                @foreach($animal->vaccins as $vaccine)
                                    <li>{{ $vaccine->vaccine }} - {{ \Carbon\Carbon::parse($vaccine->vaccination_date)->format('d/m/Y') }} - <a href="{{route("profil",$vaccine->specialist->id)}}" class="underline text-blue-500">{{$vaccine->specialist->name}}</a></li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">Aucun vaccin enregistré pour cet animal.</p>
                        @endif

                        <!-- Ajout de vaccin avec des champs uniques pour chaque animal -->
                        <div class="mt-4 flex space-x-2">
                            <input type="text" wire:model.defer="newVaccineName.{{ $animal->id }}" placeholder="Nom du vaccin"
                                   class="p-2 border rounded w-1/2">
                            <input type="date" wire:model.defer="newVaccineDate.{{ $animal->id }}" class="p-2 border rounded w-1/3">
                            <button wire:click="addVaccine({{ $animal->id }})"
                                    class="px-3 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                ➕ Ajouter
                            </button>
                        </div>
                    </div>
                @endforeach

                <!-- Blocage et signalement du patient -->
                <div class="mt-4 flex space-x-4">
                    @if($selectedPatient->warnings->where('is_blocked', true)->isNotEmpty())
                        <button wire:click="unblockPatient({{ $selectedPatient->id }})"
                                class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            🔓 Débloquer le Patient
                        </button>
                    @else
                        <button wire:click="blockPatient({{ $selectedPatient->id }})"
                                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                            🔒 Bloquer le Patient
                        </button>
                    @endif

                    <!-- Bouton de signalement -->
                    <button wire:click="$set('showReportForm', true)"
                            class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">
                        🚩 Signaler
                    </button>
                </div>

                <!-- Formulaire de signalement -->
                @if($showReportForm)
                    <div class="mt-4 bg-gray-100 p-4 rounded-lg">
                        <h4 class="text-lg font-bold text-gray-700 mb-2">Signaler un problème</h4>
                        <input type="text" wire:model.defer="reportTitle" placeholder="Titre du signalement"
                               class="p-2 border rounded w-full mb-2">
                        <textarea wire:model.defer="reportText" placeholder="Description du problème"
                                  class="p-2 border rounded w-full mb-2" rows="4"></textarea>
                        <button wire:click="submitReport({{ $selectedPatient->id }})"
                                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
                            Envoyer le signalement
                        </button>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Message de succès -->
    @if (session()->has('message'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>

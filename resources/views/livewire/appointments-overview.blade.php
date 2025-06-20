<div class="min-h-screen bg-gray-100 p-10 w-fill-available">
    <h1 class="text-3xl font-bold text-green-700 mb-6">📅 Mes Rendez-vous</h1>

    @php
        use Carbon\Carbon;
        Carbon::setLocale('fr');
    @endphp

        <!-- Prochains Rendez-vous -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">✨ Prochains Rendez-vous</h2>
        @if($upcomingAppointments->isEmpty())
            <p class="text-gray-500">Aucun rendez-vous à venir.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($upcomingAppointments as $appointment)

                    <div class="bg-white shadow-lg rounded-lg p-6 transition-all hover:shadow-xl">
                        <h3 class="text-xl font-bold text-green-700 flex items-center">
                            🩺 {{ $appointment->specialized_service_id ? $appointment->specializedService->name : $appointment->service->name }}
                        </h3>
                        <div class="mt-4 text-gray-700 space-y-2">
                            <p class="flex items-center">
                                🗓️ <strong class="ml-2 mr-2">Date : </strong> {{ Carbon::parse($appointment->date)->translatedFormat('l j F Y') }}
                            </p>
                            <p class="flex items-center">
                                ⏰ <strong class="ml-2 mr-2">Heure : </strong> {{ Carbon::parse($appointment->start_time)->format('H:i') }} - {{ Carbon::parse($appointment->end_time)->format('H:i') }}
                            </p>

                            <p class="flex items-center">
                                🐾 <strong class="ml-2 mr-2">Animal :  </strong>{{$appointment->animal->nom}}
                            </p>

                            <p class="flex items-center">
                                🏷️ <strong class="ml-2 ">Statut : </strong>
                                <span class="font-bold ml-2 px-3 py-1 rounded-full
                                    @if($appointment->status == 'pending') bg-yellow-500 text-black
                                    @elseif($appointment->status == 'confirmed') bg-green-500 text-white
                                    @else bg-red-500 text-white @endif">
                                    {{ $appointment->status === 'pending' ? 'En attente' : ($appointment->status === 'confirmed' ? 'Accepté' : 'Refusé') }}
                                </span>
                            </p>

                            <a href="{{ route('appointments.showPatient', $appointment->id) }}"
                               class="mt-5 inline-block px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all duration-300">
                                 Voir le rendez-vous
                            </a>



                        </div>
                    </div>

                @endforeach
            </div>
        @endif
    </div>

    <!-- Anciens Rendez-vous -->
    <div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">🕰️ Anciens Rendez-vous</h2>
        <div x-data="{ open: false }">
            <button x-on:click="open = !open" class="bg-gray-200 px-4 py-2 rounded-lg hover:bg-gray-300 mb-4">
                Voir les anciens rendez-vous
            </button>


            <div x-show="open" x-transition class="space-y-4">
                @if($pastAppointments->isEmpty())
                    <p class="text-gray-500">Aucun rendez-vous passé.</p>
                @else
                    @foreach($pastAppointments as $appointment)

                        <div class="bg-white shadow-lg rounded-lg p-6 transition-all hover:shadow-xl">
                            <h3 class="text-xl font-bold text-gray-700 flex items-center">
                                🩺 {{ $appointment->service->name }}
                            </h3>
                            <div class="mt-4 text-gray-700 space-y-2">
                                <p class="flex items-center">
                                    🗓️ <strong class="ml-2 mr-2">Date : </strong> {{ Carbon::parse($appointment->date)->translatedFormat('l j F Y') }}
                                </p>
                                <p class="flex items-center">
                                    ⏰ <strong class="ml-2 mr-2">Heure : </strong> {{ Carbon::parse($appointment->start_time)->format('H:i') }} - {{ Carbon::parse($appointment->end_time)->format('H:i') }}
                                </p>

                                <p class="flex items-center">
                                    🐾 <strong class="ml-2 mr-2">Animal :  </strong>{{$appointment->animal->nom}}
                                </p>


                                <p class="flex items-center">
                                    🏷️ <strong class="ml-2">Statut : </strong>
                                    <span class="font-bold ml-2 px-3 py-1 rounded-full
                                        @if($appointment->status == 'pending') bg-yellow-500 text-black
                                        @elseif($appointment->status == 'confirmed') bg-green-500 text-white
                                        @else bg-red-500 text-white @endif">
                                        {{ $appointment->status === 'pending' ? 'En attente' : ($appointment->status === 'confirmed' ? 'Accepté' : 'Refusé') }}
                                    </span>
                                </p>
                            </div>
                            <a href="{{ route('appointments.showPatient', $appointment->id) }}"
                               class=" mt-5 inline-block px-6 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 transition-all duration-300">
                                Voir le rendez-vous
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

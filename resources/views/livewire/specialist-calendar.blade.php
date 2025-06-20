<div class="min-h-screen bg-gray-100 py-6 px-8 w-fill-available" x-data="{ selectedDate: '{{ $selectedDate }}', showPast: false }">
    <h2 class="text-3xl font-bold text-green-700 mb-6 flex items-center">
        📅 Planning des Rendez-vous
    </h2>

    <!-- Calendrier des rendez-vous futurs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($appointments as $date => $dailyAppointments)
            <div class="bg-white shadow-lg rounded-lg p-5 border border-gray-200 transition-all hover:shadow-xl">
                <h3 class="text-lg font-bold text-green-600 mb-3 flex items-center">
                    📌 {{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                </h3>

                <ul>
                    @foreach ($dailyAppointments as $appointment)
                        <li class="p-3 mb-4 bg-gray-100 hover:bg-green-100 rounded-lg cursor-pointer transition-all relative">
                            <a href="{{route("appointments.show",$appointment->id)}}">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm font-semibold text-gray-700 flex items-center">
                                        ⏰ {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                    </span>
                                    <span class="text-xs font-bold uppercase px-3 py-1 rounded-full
                                        @if ($appointment->status === 'confirmed') bg-green-500 text-white
                                        @elseif ($appointment->status === 'canceled') bg-red-500 text-white
                                        @else bg-yellow-500 text-black
                                        @endif">
                                        {{ $appointment->status === 'pending' ? 'En attente' : ($appointment->status === 'confirmed' ? 'Accepté' : 'Refusé') }}
                                    </span>
                                </div>

                                <div class="text-sm text-gray-600 mt-2">
                                    <p class="flex items-center">🐾 <strong class="ml-1">Animal :</strong> {{ $appointment->animal->nom }}</p>
                                    <p class="flex items-center">🩺 <strong class="ml-1">Service :</strong> {{ $appointment->service->name }}</p>
                                </div>

                                <!-- Boutons d'actions pour les rendez-vous en attente -->
                                @if ($appointment->status === 'pending')
                                    <div class="flex justify-end space-x-2 mt-3">
                                        <button wire:click="updateStatus({{ $appointment->id }}, 'confirmed')"
                                                class="bg-green-600 text-white px-3 py-1 rounded-md hover:bg-green-700 transition flex items-center">
                                            ✅ Accepter
                                        </button>
                                        <button wire:click="updateStatus({{ $appointment->id }}, 'canceled')"
                                                class="bg-red-600 text-white px-3 py-1 rounded-md hover:bg-red-700 transition flex items-center">
                                            ❌ Refuser
                                        </button>
                                    </div>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @empty
            <div class="text-center mt-6">
                <p class="text-gray-500 text-sm">Aucun rendez-vous prévu pour les prochains jours.</p>
            </div>
        @endforelse
    </div>

    <!-- Dropdown pour afficher les rendez-vous passés -->
    <div class="mt-10">
        <button @click="showPast = !showPast"
                class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-800 transition">
            <span x-show="!showPast">📂 Afficher les anciens rendez-vous</span>
            <span x-show="showPast">📁 Masquer les anciens rendez-vous</span>
        </button>

        <div x-show="showPast" class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse ($pastAppointments as $date => $dailyAppointments)
                <div class="bg-white shadow-lg rounded-lg p-5 border border-gray-200 transition-all hover:shadow-xl">
                    <h3 class="text-lg font-bold text-red-600 mb-3 flex items-center">
                        🕰 {{ \Carbon\Carbon::parse($date)->locale('fr')->isoFormat('dddd D MMMM YYYY') }}
                    </h3>

                    <ul>
                        @foreach ($dailyAppointments as $appointment)
                            <li class="p-3 mb-4 bg-gray-100 hover:bg-red-100 rounded-lg cursor-pointer transition-all relative">
                                <a href="{{route("appointments.show",$appointment->id)}}">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-semibold text-gray-700 flex items-center">
                                            ⏰ {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}
                                        </span>
                                        <span class="text-xs font-bold uppercase px-3 py-1 rounded-full
                                            @if ($appointment->status === 'confirmed') bg-green-500 text-white
                                            @elseif ($appointment->status === 'canceled') bg-red-500 text-white
                                            @else bg-yellow-500 text-black
                                            @endif">
                                            {{ $appointment->status === 'pending' ? 'En attente' : ($appointment->status === 'confirmed' ? 'Accepté' : 'Refusé') }}
                                        </span>
                                    </div>

                                    <div class="text-sm text-gray-600 mt-2">
                                        <p class="flex items-center">🐾 <strong class="ml-1">Animal :</strong> {{ $appointment->animal->nom }}</p>
                                        <p class="flex items-center">🩺 <strong class="ml-1">Service :</strong> {{ $appointment->service->name }}</p>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                <div class="text-center mt-6">
                    <p class="text-gray-500 text-sm">Aucun ancien rendez-vous à afficher.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

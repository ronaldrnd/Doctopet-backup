<div class="flex flex-col bg-gray-100 w-full">
    <div class="w-full text-center mb-6">
        <!-- 🗓 Titre du calendrier -->
        <h3 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">
            Semaine du {{ $currentWeek->startOfWeek()->translatedFormat('d F Y') }}
            au {{ $currentWeek->endOfWeek()->translatedFormat('d F Y') }}
        </h3>

        <!-- 🔄 Navigation entre semaines -->
        <div class="flex justify-between items-center w-full px-4">
            <button wire:click="previousWeek"
                    class="px-4 py-2 mb-4 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition disabled:bg-gray-300 disabled:cursor-not-allowed"
                    @if($currentWeek->lessThanOrEqualTo(Carbon\Carbon::now()->startOfWeek())) disabled @endif>
                ⬅ Semaine précédente
            </button>
            <button wire:click="nextWeek"
                    class="px-4 py-2 mb-4 rounded-lg bg-green-500 text-white hover:bg-green-600 transition">
                Semaine suivante ➡
            </button>
        </div>

        <!-- 📅 Version Desktop/Tablette : Affichage en une seule ligne -->
        <div class="hidden md:grid grid-cols-{{count($availableSlots)}} gap-2 auto-rows-fr w-full">
            @foreach($availableSlots as $date => $slots)
                <div class="border border-gray-300 rounded-lg shadow-md p-4 bg-white flex flex-col justify-between h-full">
                    <h4 class="text-md font-bold text-gray-800 mb-2 text-center">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('l d F') }}
                    </h4>
                    <div class="flex flex-wrap gap-1 justify-center">
                        @forelse($slots as $slot)
                            <form method="POST" action="{{ route('rdv.confirm') }}">
                                @csrf
                                <input type="hidden" name="animalId" value="{{ $animalID }}">
                                <input type="hidden" name="serviceId" value="{{ $service_id }}">
                                <input type="hidden" name="selectedSlot[date]" value="{{ $date }}">
                                <input type="hidden" name="selectedSlot[start_time]" value="{{ $slot['start_time'] }}">
                                <input type="hidden" name="selectedSlot[end_time]" value="{{ $slot['end_time'] }}">
                                <button type="submit"
                                        class="block w-full bg-green-100 text-green-700 py-1 px-2 rounded-md text-xs hover:bg-green-200 transition">
                                    {{ $slot['start_time'] }} - {{ $slot['end_time'] }}
                                </button>
                            </form>
                        @empty
                            <p class="text-gray-500 text-center text-sm">Aucun créneau</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <!-- 📱 Version Mobile : Slider horizontal pour jours -->
        <div class="md:hidden w-full relative overflow-x-auto whitespace-nowrap flex-nowrap flex gap-2 px-4">
            @foreach($availableSlots as $date => $slots)
                <div class="border border-gray-300 rounded-lg shadow-md p-4 bg-white flex flex-col justify-between min-w-[180px]">
                    <h4 class="text-md font-bold text-gray-800 mb-2 text-center">
                        {{ \Carbon\Carbon::parse($date)->translatedFormat('l d F') }}
                    </h4>
                    <div class="flex flex-col gap-1">
                        @forelse($slots as $slot)
                            <form method="POST" action="{{ route('rdv.confirm') }}">
                                @csrf
                                <input type="hidden" name="animalId" value="{{ $animalID }}">
                                <input type="hidden" name="serviceId" value="{{ $service_id }}">
                                <input type="hidden" name="selectedSlot[date]" value="{{ $date }}">
                                <input type="hidden" name="selectedSlot[start_time]" value="{{ $slot['start_time'] }}">
                                <input type="hidden" name="selectedSlot[end_time]" value="{{ $slot['end_time'] }}">
                                <button type="submit"
                                        class="block w-full bg-green-100 text-green-700 py-1 px-2 rounded-md text-xs hover:bg-green-200 transition">
                                    {{ $slot['start_time'] }} - {{ $slot['end_time'] }}
                                </button>
                            </form>
                        @empty
                            <p class="text-gray-500 text-center text-sm">Aucun créneau</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

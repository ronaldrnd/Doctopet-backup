<div class="w-[90%] max-w-6xl mx-auto bg-gray-100 p-6 md:p-10 text-black flex flex-col md:flex-row gap-12">
    <!-- Formulaire -->
    <div class="w-full md:w-1/2 space-y-12">
        <h1 class="text-2xl font-bold">Calculez votre rentabilité</h1>
        <p>Découvrez le gain de temps et les revenus additionnels que Doctopet peut vous apporter.</p>

        <div class="bg-white p-6 md:p-8 shadow-md rounded-lg">
            <div class="space-y-6">
                <!-- Sélection de la spécialité -->
                <div class="space-y-2">
                    <label class="font-semibold">Quelle profession exercez-vous ?</label>
                    <select wire:model.live="selectedSpecialty" class="w-full p-3 border rounded">
                        @foreach($specialties as $specialty)
                            <option value="{{ $specialty }}">{{ $specialty }}</option>
                        @endforeach
                    </select>
                </div>


                <!-- Acceptation des nouveaux clients -->
                <div class="space-y-2">
                    <label class="font-semibold">Souhaitez-vous accueillir de nouveaux patients ?</label>
                    <div class="flex space-x-4">
                        <button wire:click="toggleAcceptNewClients(true)"
                                class="px-4 py-2 rounded transition-all duration-200
                                    {{ $acceptNewClients ? 'bg-green-500 text-white' : 'bg-gray-300' }}">
                            Oui
                        </button>
                        <button wire:click="toggleAcceptNewClients(false)"
                                class="px-4 py-2 rounded transition-all duration-200
                                    {{ !$acceptNewClients ? 'bg-green-500 text-white' : 'bg-gray-300' }}">
                            Non
                        </button>
                    </div>
                </div>

                @if($acceptNewClients)

                <!-- Nombre de nouveaux clients par mois -->
                <div class="space-y-2">
                    <label class="font-semibold">Combien de nouveaux clients par mois ?</label>
                    <input type="range" wire:model.live="newClients" min="0" max="50" step="1" class="w-full">
                    <p class="text-center">{{ $newClients }} nouveaux clients/mois</p>
                </div>
                @endif


                <!-- Tarif moyen d'une consultation -->
                <div class="space-y-2">
                    <label class="font-semibold">Quel est le tarif moyen d'une consultation (€) ?</label>
                    <input type="number" wire:model.live="avgConsultationPrice" class="w-full p-2 border rounded">
                </div>

                <!-- Rendez-vous non honorés -->
                <div class="space-y-2">
                    <label class="font-semibold">Nombre de rendez-vous non honorés par mois</label>
                    <input type="range" wire:model.live="missedAppointments" min="0" max="25" step="1" class="w-full">
                    <p class="text-center">{{ $missedAppointments }} rendez-vous non honorés/mois</p>
                </div>

                <!-- Nombre de consultations par semaine -->
                <div class="space-y-2">
                    <label class="font-semibold">Nombre de consultations réalisées par semaine</label>
                    <input type="number" wire:model.live="weeklyConsultations" class="w-full p-2 border rounded">
                </div>

                <!-- Temps passé sur l'administratif -->
                <div class="space-y-2">
                    <label class="font-semibold">Heures passées sur l'administratif par mois</label>
                    <input type="number" wire:model.live="adminTime" class="w-full p-2 border rounded">
                </div>
            </div>
        </div>
    </div>

    <!-- Résultats -->
    <div class="w-full md:w-1/2 md:sticky top-10 self-start">
        <div class="p-6 md:p-8 bg-gray-100 rounded-lg shadow-lg">
            <div class="space-y-6">
                <h2 class="text-2xl font-semibold">Résultats estimés :</h2>
                <p class="text-4xl font-bold text-[#43a047]">+{{ $acceptNewClients   ?  (( $newClients  * $avgConsultationPrice ) + ($extraPatients * $avgConsultationPrice))   : $avgConsultationPrice + ($extraPatients * $avgConsultationPrice) + $recoveredRevenue }}€</p>
                <p class="text-lg font-medium text-gray-600">de revenus supplémentaires par mois</p>
                <p class="text-4xl font-bold text-[#43a047]">+{{ $savedTime }}h</p>
                <p class="text-lg font-medium text-gray-600">par mois économisée(s)</p>

                <div class="space-y-4 mt-6">

                    @if($acceptNewClients)

                    <div class="flex items-center space-x-3 bg-white p-3 rounded-lg shadow">
                        <p class="text-lg font-semibold text-[#43a047]">

                            +{{ number_format($newClients * $avgConsultationPrice, 2) }}€
                        </p>
                        <p class="text-gray-600">en accueillant {{ $newClients }} nouveau(x) client(s) par mois</p>
                    </div>
                    @endif

                    <div class="flex items-center space-x-3 bg-white p-3 rounded-lg shadow">
                        <p class="text-lg font-semibold text-[#43a047]">
                            +{{ number_format($extraPatients * $avgConsultationPrice, 2) }}€
                        </p>
                        <p class="text-gray-600">grâce à l'optimisation de votre temps administratif</p>
                    </div>

                    <div class="flex items-center space-x-20 bg-white p-3 rounded-lg shadow">
                        <p class="text-lg font-semibold text-[#43a047]">
                            -53%
                        </p>
                        <p class="text-gray-600">de rendez-vous non honorés</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

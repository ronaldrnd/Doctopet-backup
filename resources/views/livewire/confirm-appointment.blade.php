<div
    x-data="{ showModal: false }"
    class="max-w-3xl mx-auto bg-gray-100 shadow-lg rounded-lg p-6"
>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 flex items-center">
            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2A9 9 0 1 1 3 12a9 9 0 0 1 18 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- En-tête -->
    <div class="text-center mb-6">
        <p class="text-gray-600 mb-2">Merci de confirmer votre rendez-vous avec le spécialiste de santé.</p>
        <p class="text-gray-600">Votre récapitulatif sera envoyé par mail</p>
    </div>

    <!-- Cartes d'information -->
    <div class="bg-gray-100 p-4 rounded-lg shadow-md">
        <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
            <!-- Spécialiste -->
            <div class="flex items-center space-x-4">
                <img src="{{ $service->user->profile_picture ? asset('storage/' . $service->user->profile_picture) : asset('img/default_profile.png') }}"
                     alt="Spécialiste" class="w-16 h-16 rounded-full border-2 border-green-500 shadow-md">
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ $service->user->name }}</p>
                    <p class="text-sm text-gray-600">Spécialiste de santé</p>
                </div>
            </div>

            <!-- Animal -->
            <div class="flex items-center space-x-4">
                <img src="{{ $animal->photo ? asset($animal->photo) : asset('img/default_animal.png') }}"
                     alt="Animal" class="w-16 h-16 rounded-full border-2 border-blue-500 shadow-md">
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ $animal->nom }}</p>
                    <p class="text-sm text-gray-600">Animal concerné</p>
                </div>
            </div>

            <!-- Utilisateur -->
            <div class="flex items-center space-x-4">
                <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('img/default_profile.png') }}"
                     alt="Utilisateur" class="w-16 h-16 rounded-full border-2 border-yellow-500 shadow-md">
                <div>
                    <p class="text-lg font-semibold text-gray-800">{{ $user->name }}</p>
                    <p class="text-sm text-gray-600">Propriétaire</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Détails du rendez-vous -->
    <div class="mt-6 p-4 bg-white rounded-lg shadow-md">
        <h3 class="text-xl font-semibold text-gray-700 mb-3 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
            </svg>
            Détails du Rendez-vous
        </h3>


        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Service -->
            <div class="flex items-center space-x-2">
                <p class="text-gray-700"><strong>Service :</strong>
                    @if ($isSpecialized)
                        {{ $specializedService->name }} (Prestation spécialisée)
                    @else
                        {{ $service->name }}
                    @endif
                </p>
            </div>

            <!-- Prix -->
            <div class="flex items-center space-x-2">
                <p class="text-gray-700"><strong>Prix :</strong>
                    @if ($isSpecialized)
                        {{ $specializedService->price }}€
                    @else
                        {{ $service->price }}€
                    @endif
                </p>
            </div>

            <!-- Date -->
            <div class="flex items-center space-x-2">
                <p class="text-gray-700"><strong>Date :</strong> {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
            </div>

            <!-- Heure -->
            <div class="flex items-center space-x-2">
                <p class="text-gray-700"><strong>Heure :</strong>
                    {{ \Carbon\Carbon::parse($selectedSlotStart)->format('H:i') }} - {{ \Carbon\Carbon::parse($selectedSlotEnd)->format('H:i') }}
                </p>
            </div>
        </div>
    </div>

    <!-- Bouton de confirmation avec Trigger pour la Popup -->
    <div class="text-center mt-6">
        <button @click="showModal = true; console.log('test')" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition shadow-md flex items-center justify-center w-full md:w-auto mx-auto">
            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
            Confirmer le Rendez-vous
        </button>
    </div>

    <!-- Modal de Confirmation -->
    <div>
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg relative w-full max-w-md">
                <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    ✕
                </button>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Confirmation du Rendez-vous</h3>
                <p class="text-gray-600 mb-4">Êtes-vous sûr de vouloir confirmer ce rendez-vous ? En cas de désistement, veuillez prévenir le professionnel au moins 72h à l'avance par téléphone pour éviter les frais de no-show.</p>
                <button wire:click="confirm" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">Je confirme mon rendez-vous</button>
            </div>
        </div>
    </div>
</div>

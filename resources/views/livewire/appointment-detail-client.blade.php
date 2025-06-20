<div class="container mx-auto py-8 bg-gray-100 px-4">
    <!-- Titre -->
    <h2 class="text-3xl font-bold text-blue-700 mb-6 flex items-center">
        📋 Détails de Votre Rendez-vous
    </h2>

    <!-- Informations Générales -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 transition-all hover:shadow-xl">
        <h3 class="text-xl font-semibold text-gray-800 flex items-center">
            📅 Informations du Rendez-vous
        </h3>
        <div class="mt-4 space-y-2 text-gray-700">
            <p class="flex items-center"> 🗓️ <strong class="ml-2 mr-2">Date : </strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }} </p>
            <p class="flex items-center"> ⏰ <strong class="ml-2 mr-2">Heure : </strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }} </p>
            <p class="flex items-center"> 🐾 <strong class="ml-2 mr-2">Animal : </strong> {{ $appointment->animal->nom }} </p>
            <p class="flex items-center"> 🩺 <strong class="ml-2 mr-2">Service : </strong> {{ $appointment->service->name }} </p>

            <p class="flex items-center">🩺 <strong class="ml-2 mr-2">Nom du spécialiste de santé : </strong> <a class="underline text-blue-500 ml-2" href="{{route("profil",$appointment->assignedSpecialist->id)}}"> {{$appointment->assignedSpecialist->name}}</a></p>
            <p class="flex items-center"> 🏥 <strong class="ml-2 mr-2">Adresse du rendez-vous : </strong>
                <a class="underline text-blue-500 ml-2" target="_blank" href="https://www.google.fr/maps/search/{{$appointment->assignedSpecialist->address}}">
                {{ $appointment->assignedSpecialist->address }}
                </a>
            </p>

        </div>
    </div>



    <!-- Carte OpenStreetMap -->
    <div class="flex justify-center mt-6">
        <iframe
            class="w-full h-[400px] rounded-lg shadow-md"
            frameborder="0"
            src="https://www.openstreetmap.org/export/embed.html?bbox={{ $appointment->assignedSpecialist->longitude }},
        {{  $appointment->assignedSpecialist->latitude }},
        {{ $appointment->assignedSpecialist->longitude }},
        {{ $appointment->assignedSpecialist->latitude}}
        &layer=mapnik
        &marker={{ $appointment->assignedSpecialist->latitude }},{{ $appointment->assignedSpecialist->longitude }}">
        </iframe>
    </div>



    <!-- Documents associés -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 transition-all hover:shadow-xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">📂 Documents associés</h3>
        @if (!$uploadedFiles->isEmpty())
            <ul class="space-y-2 mb-4">
                @foreach ($uploadedFiles as $file)
                    <li class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                        <span class="text-gray-700 truncate">{{ $file->file_name }}</span>
                        <button wire:click="downloadFile({{ $file->id }})" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            ⬇️ Télécharger
                        </button>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucun fichier disponible.</p>
        @endif
    </div>

    <!-- Historique Médical -->
    <div class="bg-white shadow-lg rounded-lg p-6 transition-all hover:shadow-xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">📚 Historique Médical de {{ $appointment->animal->nom }}</h3>
        @if ($appointment->animal->medicalHistories->isNotEmpty())
            <ul class="space-y-2 mb-4">
                @foreach ($appointment->animal->medicalHistories as $history)
                    <li class="bg-gray-100 p-3 rounded-md text-gray-700">
                        {{ $history->modification }}
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucun historique médical disponible.</p>
        @endif
    </div>


    @if($appointment->status === 'completed')
        <div class="bg-white shadow-lg rounded-lg p-6 mt-6 transition-all hover:shadow-xl">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">⭐ Laisser un avis</h3>
            @livewire('review-form', ['appointment' => $appointment])
        </div>
    @endif



</div>

<div class="container mx-auto bg-gray-100 py-8 px-4">
    <!-- Titre de la page -->
    <h2 class="text-3xl font-bold text-green-700 mb-6 flex items-center">
        📂 Mes Documents Médicaux
    </h2>

    <!-- 🔹 Message spécial pour les vétérinaires/spécialistes -->
    @if (Auth::user()->type == "S")
        <div class="bg-blue-50 border-l-4 border-blue-400 text-blue-700 p-4 mb-6 rounded-md">
            <p class="italic">
                📌 Pour déposer un document assigné à un rendez-vous avec l'un de vos clients, rendez-vous dans la
                <a href="{{ route('appointments.calendar') }}" class="font-semibold text-blue-600 underline hover:text-blue-800">
                    section Agenda
                </a>, sélectionnez le rendez-vous, puis ajoutez les documents que vous souhaitez.
            </p>
        </div>
    @endif

    <!-- 📋 Affichage des fichiers reçus -->
    <div class="bg-white shadow-lg rounded-lg p-6 mb-6 transition-all hover:shadow-xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">📋 Fichiers reçus</h3>

        @if ($files->isEmpty())
            <p class="text-gray-500">Aucun fichier disponible.</p>
        @else
            <ul class="space-y-2">
                @foreach ($files as $file)
                    <li class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                        <div>
                            <p class="text-gray-700 font-semibold truncate">{{ $file->file_name }}</p>
                            <p class="text-sm text-gray-500">
                                🩺 <strong>Spécialiste :</strong> {{ $file->appointment->service->name }} |
                                🐾 <strong>Animal :</strong> {{ $file->appointment->animal->nom }} |
                                📅 <strong>Date :</strong> {{ \Carbon\Carbon::parse($file->appointment->date)->format('d/m/Y') }}
                            </p>
                        </div>
                        <button wire:click="downloadFile({{ $file->id }})"
                                class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                            ⬇️ Télécharger
                        </button>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>

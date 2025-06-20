<div class="w-fill-available  mx-auto p-6 bg-gray-100 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-green-700 mb-6 flex items-center">📂 Gestion des Documents</h2>

    <!-- Indicateur de stockage -->
    <div class="mb-4 text-gray-700">
        🗄️ Espace utilisé : <strong>{{ number_format($totalStorageUsed / 1024, 2) }} Mo</strong> / 50 Mo
    </div>

    @if(session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif
    @if(session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <!-- Upload de fichiers -->
    <input type="file" wire:model="files" multiple class="w-full border rounded-md p-2 mb-2">
    <button wire:click="uploadFiles" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
        📤 Ajouter Document
    </button>

    <!-- Liste des fichiers -->
    <div class="mt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">📜 Vos Documents</h3>

        @if ($documents->isNotEmpty())
            <ul class="space-y-2">
                @foreach ($documents as $document)
                    <li class="flex justify-between items-center bg-gray-100 p-3 rounded-md">
                        <span class="text-gray-700 truncate">
                            {{ $document->file_name }} ({{ number_format($document->file_size / 1024, 2) }} Mo)
                        </span>

                        <div class="flex space-x-2">
                            <a href="{{ Storage::url($document->file_path) }}" target="_blank"
                               class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                ⬇️ Télécharger
                            </a>

                            <button wire:click="deleteDocument({{ $document->id }})"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                🗑️ Supprimer
                            </button>
                        </div>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500">Aucun document disponible.</p>
        @endif
    </div>
</div>

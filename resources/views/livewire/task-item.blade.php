<div class="min-h-screen bg-gray-100 p-10 w-full">
    <h1 class="text-3xl font-bold text-green-700 mb-6 flex items-center">
        ✏️ Modifier la tâche
    </h1>

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <!-- Nom de la tâche -->
        <label class="font-bold text-gray-700">Nom de la tâche</label>
        <input type="text" wire:model.defer="name" class="w-full p-2 border rounded-lg mb-4">

        <!-- Sélection de la priorité -->
        <label class="font-bold text-gray-700">Priorité</label>
        <select wire:model.defer="priority" class="w-full p-2 border rounded-lg mb-4">
            <option value="">Aucune</option>
            <option value="Urgent">🔥 Urgent</option>
            <option value="Très prioritaire">⚡ Très prioritaire</option>
            <option value="Prioritaire">📌 Prioritaire</option>
        </select>

        <!-- Date d'échéance -->
        <label class="font-bold text-gray-700">Échéance</label>
        <input type="date" wire:model.defer="due_date" class="w-full p-2 border rounded-lg mb-4">

        <!-- Notes -->
        <label class="font-bold text-gray-700">Notes</label>
        <textarea wire:model.defer="description" class="w-full p-2 border rounded-lg min-h-[200px]"></textarea>

        <!-- Boutons d'action -->
        <div class="mt-6 flex justify-between">
            <button   onclick="saveTask()" class="bg-green-600 text-white px-4 py-2 rounded-lg">
                💾 Sauvegarder
            </button>
            <button onclick="deleteTask()" class="bg-red-600 text-white px-4 py-2 rounded-lg">
                🗑 Supprimer
            </button>
        </div>

        @if(session()->has('message'))
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                {{ session('message') }}
            </div>
        @endif
    </div>

    <script>
        function saveTask() {
            Livewire.dispatch('saveTask');
        }
        function deleteTask() {
            Livewire.dispatch('deleteTask');

        }

    </script>
</div>

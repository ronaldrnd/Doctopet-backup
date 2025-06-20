<div class="min-h-screen bg-gray-100 p-10 w-fill-available">
    <h1 class="text-3xl font-bold text-green-700 mb-6 flex items-center">
        ✅ Gestionnaire de Tâches
    </h1>

    <!-- Formulaire d'ajout -->
    <div x-data="{ open: false }" class="mb-8">
        <button @click="open = !open" class="bg-green-600 text-white px-4 py-2 rounded-lg font-bold">
            ➕ Ajouter une tâche
        </button>

        <div x-show="open" x-transition class="mt-4 bg-white shadow p-6 rounded-lg">
            <form wire:submit.prevent="addTask" class="space-y-4">
                <input type="text" wire:model="name" placeholder="Nom de la tâche 📝" class="w-full p-2 border rounded-lg">
                <textarea wire:model="description" placeholder="Description 🏥" class="w-full p-2 border rounded-lg"></textarea>
                <input type="date" wire:model="due_date" class="w-full p-2 border rounded-lg">
                <select wire:model="priority" class="w-full p-2 border rounded-lg">
                    <option value="">Priorité 🚦</option>
                    <option value="Urgent">🔥 Urgent</option>
                    <option value="Très prioritaire">⚡ Très prioritaire</option>
                    <option value="Prioritaire">📌 Prioritaire</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg w-full">
                    ✅ Ajouter
                </button>
            </form>
        </div>
    </div>

    <!-- Liste des tâches -->
    <h2 class="text-xl font-bold mb-4">📅 À faire</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($tasks->where('is_completed', false) as $task)
            <div class="bg-white shadow rounded-lg p-6 border-l-4
                @if($task->priority === 'Urgent') border-red-500
                @elseif($task->priority === 'Très prioritaire') border-yellow-500
                @else border-green-500 @endif">
                <a href="{{route("task.view",$task->id)}}">
                <h3 class="text-xl font-bold">{{ $task->name }}</h3>
                <p class="text-gray-600">{{ $task->description }}</p>
                <p class="text-sm text-gray-400">🕒 {{ $task->due_date ?? 'Pas de date' }}</p>
                <p class="text-sm text-gray-500">⚡ Priorité: {{ $task->priority ?? 'Normale' }}</p>
                </a>
                <button wire:click="toggleComplete({{ $task->id }})" class="mt-4 bg-green-500 text-white px-4 py-2 rounded">
                    ✅ Terminer
                </button>
                <button wire:click="deleteTask({{ $task->id }})" class="mt-2 bg-red-500 text-white px-4 py-2 rounded">
                    🗑 Supprimer
                </button>
            </div>
        @endforeach
    </div>

    <!-- Dropdown des tâches complétées -->
    <h2 class="text-xl font-bold mt-6">✔️ Complétées</h2>
    <details class="bg-gray-200 p-4 rounded-lg mt-4">
        <summary class="cursor-pointer font-bold">Voir les tâches terminées ⬇</summary>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            @foreach($tasks->where('is_completed', true) as $task)
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-xl font-bold text-gray-400">{{ $task->name }}</h3>
                    <button wire:click="toggleComplete({{ $task->id }})" class="mt-4 bg-yellow-500 text-white px-4 py-2 rounded">
                        🔄 Reprendre
                    </button>
                </div>
            @endforeach
        </div>
    </details>
</div>

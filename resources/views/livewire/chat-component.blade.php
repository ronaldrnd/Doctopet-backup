<div class="min-h-screen bg-gray-100 flex flex-col p-4 w-full">

    <!-- 🔍 Barre de recherche -->
    <div class="mb-4">
        <input type="text" wire:model.live="search" placeholder="🔍 Rechercher un professionnel..."
               class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
        @if ($search)
            <div class="bg-white shadow-md rounded mt-2">
                @foreach ($users as $user)
                    <button wire:click="selectUser({{ $user->id }})"
                            class="block w-full text-left px-4 py-2 flex items-center hover:bg-gray-200">
                        <img src="{{ $user->profile_picture ? asset('storage/' . $user->profile_picture) : asset('img/default_profile.png') }}"
                             alt="Profil" class="w-10 h-10 rounded-full border-2 border-gray-300 mr-3">
                        <div>
                            <span class="block font-semibold text-gray-800">{{ $user->name }}</span>
                            <span class="block text-sm text-gray-500">📍 {{ $user->address ?? 'Adresse non renseignée' }}</span>
                        </div>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    <!-- 📩 Conteneur principal -->
    <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4">

        <!-- 📜 Liste des conversations -->
        <div class="lg:w-1/3 w-full bg-white shadow-md rounded-lg p-4">
            <h3 class="text-lg font-bold text-gray-700 mb-4">📩 Mes messages</h3>
            @foreach ($userConversations as $userId => $conversation)
                <button wire:click="selectUser({{ $userId }})"
                        class="block w-full text-left px-4 py-3 flex items-center justify-between border-b hover:bg-gray-100 rounded-md">
                    <div class="flex">
                        <img src="{{ asset('img/default_profile.png') }}" alt="Profil"
                             class="w-12 h-12 rounded-full border-2 border-gray-300 mr-3">
                        <div class="truncate w-full">
                            <span class="font-semibold">{{ \App\Models\User::find($userId)->name }}</span>
                            <p class="text-sm text-gray-500 break-words whitespace-normal line-clamp-2 overflow-hidden">
                                {{ $conversation['last_message']->content }}
                            </p>
                        </div>
                    </div>
                    @if ($conversation['unread_count'] > 0)
                        <span class="bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                            {{ $conversation['unread_count'] }}
                        </span>
                    @endif
                </button>
            @endforeach

            <!-- 🔄 Bouton pour charger plus de conversations -->
            <button wire:click="loadMoreConversations"
                    class="w-full text-blue-600 hover:underline text-sm text-center mt-4">
                Charger plus de conversations
            </button>
        </div>

        <!-- 💬 Fenêtre de conversation -->
        <div class="lg:w-2/3 w-full bg-white shadow-md rounded-lg p-4 flex flex-col h-[500px]">
            @if ($selectedUser)
                <h3 class="text-lg font-bold text-gray-700 mb-2">💬 {{ $selectedUser->name }} (📍 {{$selectedUser->address}})</h3>

                <!-- 📜 Zone des messages -->
                <div class="flex-1 overflow-y-auto border p-3 rounded-lg bg-gray-50">
                    @foreach ($messages as $msg)
                        <div class="mb-2 flex {{ $msg->sender_id == Auth::id() ? 'justify-end' : 'justify-start' }}">
                            <div class="max-w-xs md:max-w-md px-4 py-2 rounded-lg shadow-md
                        {{ $msg->sender_id == Auth::id() ? 'bg-green-200 text-green-900' : 'bg-gray-200 text-gray-900' }}">
                <span class="font-semibold">
                    {{ $msg->sender_id == Auth::id() ? 'Vous' : $selectedUser->name }}
                </span>
                                <p class="text-sm break-words">{{ $msg->content }}</p>
                            </div>
                        </div>
                    @endforeach

                    <!-- ✅ Affichage du message "Vu" -->
                    @if ($this->lastMessageRead())
                        <p class="text-sm text-gray-500 text-right italic mt-1">{{ $this->lastMessageRead() }}</p>
                    @endif

                    @if ($messages->count() >= $perPage)
                        <button wire:click="loadMore"
                                class="text-blue-600 hover:underline text-sm text-center mt-4 w-full">
                            Charger plus de messages
                        </button>
                    @endif
                </div>


                <!-- ✍️ Zone d'écriture (fixée en bas) -->
                <div class="mt-4 flex">
                    <input type="text" wire:model="message" class="w-full px-4 py-2 border rounded-md"
                           placeholder="✍️ Écrivez un message...">
                    <button wire:click="sendMessage"
                            class="ml-2 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                        📤 Envoyer
                    </button>
                </div>
            @else
                <p class="text-gray-500 text-center">Sélectionnez un professionnel pour démarrer une conversation.</p>
            @endif
        </div>

    </div>

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
</div>

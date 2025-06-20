<div class="p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-green-700 mb-6">👥 Gestion des Utilisateurs - ({{count($users)}})</h2>

    <table class="w-full border-collapse border border-gray-300">
        <thead class="bg-gray-200">
        <tr>
            <th class="p-3 border">ID</th>
            <th class="p-3 border">Nom</th>
            <th class="p-3 border">Email</th>
            <th class="p-3 border">Type de compte</th>
            <th class="p-3 border">Vérifié</th>
            <th class="p-3 border">Bloqué</th>
            <th class="p-3 border">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr class="border">
                <td class="p-3">{{$user->id}}</td>
                <td class="p-3">{{ $user->name }}</td>
                <td class="p-3  {{ ($user->type == "S") ? "text-green-700" : "text-black"}}    ">{{$user->type == "S" ? "Professionnel de santé" : "Patient"}}</td>
                <td class="p-3">{{ $user->email }}</td>
                <td class="p-3">{{ $user->is_verified ? '✅' : '❌' }}</td>
                <td class="p-3">{{ $user->is_blocked ? '🚫' : '✅' }}</td>
                <td class="p-3 flex space-x-2">
                    <button wire:click="toggleVerification({{ $user->id }})"
                            class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">
                        {{ $user->is_verified ? '❌ Dévalider' : '✅ Valider' }}
                    </button>
                    <button wire:click="toggleBlock({{ $user->id }})"
                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                        {{ $user->is_blocked ? '🔓 Débloquer' : '🚫 Bloquer' }}
                    </button>

                    @if(!$user->hasRole("Administrateur") || \Illuminate\Support\Facades\Auth::user()->id == $user->id || \Illuminate\Support\Facades\Auth::user()->id == 6)
                    <button
                        class="px-3 py-1 bg-green-700 text-white rounded hover:bg-green-600">
                    <a href="{{route("admin.edit_user",$user->id)}}">
                            Modifier les informations
                        </a>
                    </button>
                        <button wire:click="chrootUser({{ $user->id }})"
                                class="px-3 py-1 bg-red-700 text-white rounded hover:bg-red-600">
                                Se loger dans le compte
                        </button>
                    @endif

                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

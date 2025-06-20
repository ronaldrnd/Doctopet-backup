<div class="p-6">
    <h2 class="text-3xl font-bold text-green-700 mb-6">🏥 Gérer la clinique : {{ $clinic->name }}</h2>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('message') }}
        </div>
    @endif

    @if ($isOwner)
        <div class="mb-8">
            <h3 class="text-xl font-bold mb-4">👥 Gérer les membres</h3>

            <!-- Formulaire d'invitation -->
            <div class="flex items-center gap-2 mb-4">
                <select wire:model="selectedUserId" class="border p-2 rounded w-full max-w-sm">
                    <option value="">Sélectionner un utilisateur à inviter</option>
                    @foreach ($allUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                    @endforeach
                </select>
                <button wire:click="inviteMember" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    ✉️ Inviter
                </button>
            </div>

            <!-- Liste des membres -->
            <ul class="bg-white shadow rounded-lg p-4">
                @foreach ($members as $member)
                    <li class="flex justify-between items-center border-b py-2">
                        <span>{{ $member->name }} ({{ $member->email }})</span>
                        @if ($member->id !== auth()->id())
                            <button wire:click="removeMember({{ $member->id }})"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                ❌ Retirer
                            </button>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    @else
        <div class="mb-8">
            <button wire:click="leaveClinic" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">
                🚪 Quitter la clinique
            </button>
        </div>
    @endif

    <div class="mb-8">
        <h3 class="text-xl font-bold mb-4">🗓️ Mes disponibilités dans la clinique</h3>
        <div class="flex gap-2 bg-gray-50 border rounded-lg p-4 overflow-x-auto">

            <!-- Heures -->
            <div class="flex flex-col border-r pr-2 text-right">
                @for ($hour = 8; $hour <= 23; $hour++)
                    <div class="h-12 flex items-center justify-end text-sm text-gray-600">
                        {{ sprintf('%02d:00', $hour) }}
                    </div>
                    <div class="h-12 flex items-center justify-end text-sm text-gray-600">
                        {{ sprintf('%02d:30', $hour) }}
                    </div>
                @endfor
            </div>

            <!-- Jours de la semaine -->
            @foreach(['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'] as $day)
                <div class="flex flex-col flex-1 min-w-[120px]">
                    <div class="text-center font-bold mb-2">{{ $day }}</div>
                    @for ($hour = 8; $hour <= 23; $hour++)
                        @php $timeSlot1 = sprintf('%02d:00', $hour); $timeSlot2 = sprintf('%02d:30', $hour); @endphp

                        <div wire:click="toggleSlot('{{ $day }}', '{{ $timeSlot1 }}')"
                             class="h-12 border-b border-gray-300 cursor-pointer transition"
                             style="background-color: {{ isset($schedules[$day]) && collect($schedules[$day])->pluck('start_time')->contains($timeSlot1) ? '#48bb78' : 'white' }};">
                        </div>

                        <div wire:click="toggleSlot('{{ $day }}', '{{ $timeSlot2 }}')"
                             class="h-12 border-b border-gray-300 cursor-pointer transition"
                             style="background-color: {{ isset($schedules[$day]) && collect($schedules[$day])->pluck('start_time')->contains($timeSlot2) ? '#48bb78' : 'white' }};">
                        </div>
                    @endfor
                </div>
            @endforeach
        </div>
    </div>
</div>

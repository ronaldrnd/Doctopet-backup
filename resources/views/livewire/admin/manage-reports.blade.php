<div class="p-6 bg-white shadow-md rounded-lg w-full">
    <h2 class="text-2xl font-bold text-red-700 mb-6">🚨 Gestion des Signalements & Avertissements</h2>

    <!-- 📝 Signalements -->
    <div class="mb-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">📢 Signalements d'utilisateurs</h3>
        <table class="w-full border-collapse bg-gray-50 rounded-lg">
            <thead>
            <tr class="bg-red-500 text-white">
                <th class="p-2">📌 ID</th>
                <th class="p-2">👤 Spécialiste</th>
                <th class="p-2">🚨 Signalé</th>
                <th class="p-2">📅 Date</th>
                <th class="p-2">📜 Motif</th>
                <th class="p-2">🛠 Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($reports as $report)
                <tr class="border-b">
                    <td class="p-2 text-center">{{ $report->id }}</td>
                    <td class="p-2 text-center">{{ $report->specialist->name }}</td>
                    <td class="p-2 text-center font-bold">{{ $report->userTarget->name }}</td>
                    <td class="p-2 text-center">{{ $report->date }}</td>
                    <td class="p-2 text-center">{{ $report->text }}</td>
                    <td class="p-2 text-center">
                        <button wire:click="blockUser({{ $report->user_id_target }})"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700">
                            🚫 Bloquer
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </div>

    <!-- ⚠️ Avertissements -->
    <div>
        <h3 class="text-xl font-semibold text-gray-800 mb-4">⚠️ Avertissements Utilisateurs</h3>
        <table class="w-full border-collapse bg-gray-50 rounded-lg">
            <thead>
            <tr class="bg-yellow-500 text-white">
                <th class="p-2">📌 ID</th>
                <th class="p-2">👤 Spécialiste</th>
                <th class="p-2">🚨 Averti</th>
                <th class="p-2">📊 Niveau</th>
                <th class="p-2">🔒 Bloqué</th>
                <th class="p-2">🛠 Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach($warnings as $warning)
                <tr class="border-b">
                    <td class="p-2 text-center">{{ $warning->id }}</td>
                    <td class="p-2 text-center">{{ $warning->specialist->name }}</td>
                    <td class="p-2 text-center font-bold">{{ $warning->userTarget->name }}</td>
                    <td class="p-2 text-center text-lg font-bold">{{ $warning->level }}</td>
                    <td class="p-2 text-center">
                        {{ $warning->is_blocked ? '🚫 Oui' : '✔️ Non' }}
                    </td>
                    <td class="p-2 text-center">
                        <button wire:click="blockUser({{ $warning->user_target_id }})"
                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-700">
                            🚫 Bloquer
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $warnings->links() }}
        </div>
    </div>
</div>

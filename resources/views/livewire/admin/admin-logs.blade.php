<div class="p-6 bg-white shadow-md rounded-lg w-fill-available">
    <h2 class="text-2xl font-bold text-green-700 mb-6">📜 Gestion des Logs</h2>

    <table class="w-full border-collapse">
        <thead>
        <tr class="bg-green-500 text-white">
            <th class="p-2">Utilisateur</th>
            <th class="p-2">Domaine</th>
            <th class="p-2">Contexte</th>
            <th class="p-2">Date</th>
        </tr>
        </thead>
        <tbody>
        @foreach($logs as $log)
            <tr class="border-b">
                <td class="p-2">{{ $log->user->name }}</td>
                <td class="p-2">{{ $log->domaine }}</td>
                <td class="p-2">{{ $log->context }}</td>
                <td class="p-2">{{ $log->date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $logs->links() }}
    </div>
</div>

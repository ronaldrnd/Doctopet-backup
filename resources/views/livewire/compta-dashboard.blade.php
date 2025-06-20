<div class="p-6 bg-gray-100 w-fill-available">
    <h1 class="text-3xl font-bold mb-6 text-green-700">Tableau de Bord Comptable</h1>

    <!-- Filtres de dates -->
    <div x-data="{ startDate: '{{ $startDate }}', endDate: '{{ $endDate }}' }" class="flex items-center mb-6">
        <input type="date"
               x-model="startDate"
               @change="$wire.startDate = startDate"
               class="p-2 border rounded mr-2">

        <input type="date"
               x-model="endDate"
               @change="$wire.endDate = endDate"
               class="p-2 border rounded mr-2">

        <button @click="$wire.updateDateRange(startDate, endDate)"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
            🔄 Mettre à jour
        </button>
    </div>


    <!-- Solde actuel, futur et bénéfices totaux -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="p-4 bg-white shadow rounded-lg text-center">
            <h2 class="text-xl font-bold text-gray-800">💰 Solde Actuel</h2>
            <p class="text-2xl text-green-600 font-bold mt-2">{{ number_format($currentBalance, 2) }} €</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg text-center">
            <h2 class="text-xl font-bold text-gray-800">📆 Solde Futur</h2>
            <p class="text-2xl text-blue-600 font-bold mt-2">{{ number_format($futureBalance, 2) }} €</p>
        </div>
        <div class="p-4 bg-white shadow rounded-lg text-center">
            <h2 class="text-xl font-bold text-gray-800">📈 Bénéfices Totaux</h2>
            <p class="text-2xl text-purple-600 font-bold mt-2">{{ number_format($totalProfits, 2) }} €</p>
        </div>
    </div>


    <!-- Ajout de dépense -->
    <div class="bg-white p-6 shadow rounded-lg mb-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Ajouter une Dépense</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <input type="text" wire:model.defer="newExpenseLibelle" placeholder="Libellé"
                   class="p-2 border rounded w-full">
            <input type="number" wire:model.defer="newExpensePrice" placeholder="Montant (€)" step="0.01"
                   class="p-2 border rounded w-full">
            <input type="date" wire:model.defer="newExpenseDate" class="p-2 border rounded w-full">
        </div>
        <button wire:click="addExpense"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
            ➕ Ajouter
        </button>
    </div>

    <!-- Liste des dépenses -->
    <div class="bg-white p-6 shadow rounded-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Liste des Dépenses ({{ count($expenses) }})</h2>

        <table class="w-full table-auto border-collapse">
            <thead>
            <tr class="bg-gray-200 text-gray-700">
                <th class="p-3 border">Libellé</th>
                <th class="p-3 border">Montant (€)</th>
                <th class="p-3 border">Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach($expenses as $expense)
                <tr class="text-center border-t">
                    <td class="p-3">{{ $expense->libelle }}</td>
                    <td class="p-3 text-red-600 font-bold">-{{ number_format($expense->depense_price, 2) }} €</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($expense->date)->translatedFormat('d M Y') }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="mt-4 text-right">
            <button wire:click="exportRevenuesToExcel"
                    class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                📄 Exporter les Revenus
            </button>

            <button wire:click="exportExpensesToExcel"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                📄 Exporter les Dépenses
            </button>
        </div>

    </div>

    <!-- Graphique des revenus et dépenses -->
    <div class="mt-6 p-6 bg-white shadow rounded-lg">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Évolution des Revenus et Dépenses</h2>
        <canvas id="revenueChart"></canvas>
    </div>



    <script>

            const ctx = document.getElementById('revenueChart');

            const labels = @json($chartLabels);
            const revenuesData = @json($chartRevenues);
            const expensesData = @json($chartExpenses);

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Revenus (€)',
                            data: revenuesData,
                            borderColor: '#FF6384',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: true,
                            tension: 0.4,
                            showLine: true
                        },
                        {
                            label: 'Dépenses (€)',
                            data: expensesData,
                            borderColor: '#36A2EB',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: true,
                            tension: 0.4,
                            showLine: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true },
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                            }
                        }
                    }
                }
            });
    </script>


    <style>

    </style>
</div>

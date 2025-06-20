<div class="max-w-6xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-6">📊 Statistiques Stripe</h2>

    <!-- 💳 Historique des transactions -->
    <div class="mb-6 p-4 bg-gray-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">💰 Historique des Transactions</h3>
        <table class="w-full bg-white shadow-md rounded-lg border border-gray-200">
            <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-3 text-left">Référence</th>
                <th class="p-3 text-left">Montant</th>
                <th class="p-3 text-left">Client</th>
                <th class="p-3 text-left">Date</th>
                <th class="p-3 text-left">Statut</th>
                <th class="p-3 text-left">Reçu</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transactions as $transaction)
                <tr class="border-b">
                    <td class="p-3">{{ $transaction['id'] }}</td>
                    <td class="p-3">{{ $transaction['amount'] }} {{ $transaction['currency'] }}</td>
                    <td class="p-3">{{ $transaction['customer_name'] }}</td>
                    <td class="p-3">{{ $transaction['date'] }}</td>
                    <td class="p-3">
                        @if($transaction['status'] == 'succeeded')
                            ✅ Payé
                        @else
                            ❌ Échoué
                        @endif
                    </td>
                    <td class="p-3">
                        @if($transaction['receipt_url'])
                            <a href="{{ $transaction['receipt_url'] }}" target="_blank" class="text-blue-500">📄 Voir</a>
                        @else
                            N/A
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

    <!-- 📈 Graphique des revenus -->
    <div class="p-4 bg-gray-100 rounded shadow">
        <h3 class="text-lg font-semibold mb-3">📈 Revenus Mensuels</h3>
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const ctx = document.getElementById("revenueChart").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: @json(array_keys($revenues)),
                datasets: [{
                    label: "Revenus (€)",
                    data: @json(array_values($revenues)),
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

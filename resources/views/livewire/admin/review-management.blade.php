<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-4">📌 Gestion des Avis</h2>

    <table class="min-w-full bg-white shadow-md rounded-lg">
        <thead>
        <tr class="bg-gray-200 text-gray-600 uppercase text-sm">
            <th class="py-2 px-4">Utilisateur</th>
            <th class="py-2 px-4">Avis</th>
            <th class="py-2 px-4">Note</th>
            <th class="py-2 px-4">Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($reviews as $review)
            <tr class="border-b text-gray-700">
                <td class="py-2 px-4">{{ $review->user->name }}</td>
                <td class="py-2 px-4">{{ $review->comment }}</td>
                <td class="py-2 px-4 text-yellow-500">
                    {{ str_repeat('⭐', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                </td>
                <td class="py-2 px-4">
                    <button wire:click="acceptReview({{ $review->id }})" class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">✅ Accepter</button>
                    <button wire:click="refuseReview({{ $review->id }})" class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">❌ Refuser</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-4">
        {{ $reviews->links() }}
    </div>
</div>

<div>
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif


        <p class="font-semibold">ℹ️ Information :</p>
        <p class="text-sm mt-2">
            Votre avis sera publié sur le profil du spécialiste de santé animal.
            <br>
            Votre avis est soumis à une validation avant qu'il soit affiché.
        </p>

    <div class="flex items-center mb-4">
        <label class="mr-3 font-semibold">Note :</label>
        @for ($i = 1; $i <= 5; $i++)
            <button type="button" class="text-2xl px-1" wire:click="$set('rating', {{ $i }})">
                @if ($rating >= $i)
                    ⭐
                @else
                    ☆
                @endif
            </button>
        @endfor
    </div>

    <textarea wire:model="comment" class="w-full p-2 border rounded" placeholder="Laissez un commentaire (facultatif)"></textarea>

    <button wire:click="saveReview" class="mt-4 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
        💾 Enregistrer
    </button>
</div>

<div class="max-w-2xl mx-auto bg-white shadow-xl rounded-lg overflow-hidden mt-10 p-8">
    <div class="text-center mb-6">
        <h2 class="text-3xl font-bold text-green-700 mb-2">👋 Bienvenue sur Doctopet, {{ $user->name }} !</h2>
        @if($user->animaux && $user->animaux->isNotEmpty())
            <p class="text-gray-700">Nous avons déjà enregistré votre compagnon 🐾 <strong>{{ $user->animaux->first()->nom }}</strong> !</p>
        @else
            <p class="text-gray-700">Nous avons hâte de prendre soin de votre compagnon !</p>
        @endif
        <p class="text-sm text-gray-500 mt-1">Finalisez votre inscription pour accéder à votre espace personnel 🐶🐱</p>
    </div>

    <form wire:submit.prevent="submit" class="space-y-5">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">📍 Adresse postale (Numero + Nom de rue, Ville, Code postal, Pays)</label>
            <input type="text" wire:model="address" class="w-full border border-gray-300 p-3 rounded-md focus:ring-green-500 focus:border-green-500">
            @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">🔐 Mot de passe</label>
            <input type="password" wire:model="password" class="w-full border border-gray-300 p-3 rounded-md focus:ring-green-500 focus:border-green-500">
            @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">🔁 Confirmation du mot de passe</label>
            <input type="password" wire:model="password_confirmation" class="w-full border border-gray-300 p-3 rounded-md focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="text-center mt-6">
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-full font-semibold shadow-md transition">
                ✅ Activer mon compte
            </button>
        </div>

        <p class="text-sm text-gray-500 mt-6 text-center">
            Vous pourrez compléter votre profil et suivre votre animal après activation.
        </p>
    </form>
</div>

<div class="p-6 bg-white shadow-md rounded-lg max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">
        {{ $modeEdit ? '✏ Modifier un Utilisateur' : '➕ Ajouter un Utilisateur' }}
    </h2>

    @if(session()->has('message'))
        <div class="bg-green-200 text-green-800 p-2 mb-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <form wire:submit.prevent="save">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Infos générales -->
            <div>
                <label class="block text-gray-700">Nom :</label>
                <input type="text" wire:model="name" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Email :</label>
                <input type="email" wire:model="email" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Téléphone :</label>
                <input type="text" wire:model="phone_number" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Genre :</label>
                <select wire:model="gender" class="w-full p-2 border rounded">
                    <option value="M">Homme</option>
                    <option value="F">Femme</option>
                </select>
            </div>

            <div>
                <label class="block text-gray-700">Adresse personnelle :</label>
                <input type="text" wire:model="address" class="w-full p-2 border rounded">
            </div>

            <div>
                <label class="block text-gray-700">Type d'utilisateur :</label>
                <select wire:model="type" class="w-full p-2 border rounded">
                    <option value="C">Patient</option>
                    <option value="S">Professionnel</option>
                </select>
            </div>

            <!-- Champs Pro -->
            @if($type === 'S')
                <div class="col-span-2 bg-gray-100 p-4 rounded">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">🔧 Informations Professionnelles</h3>

                    <label class="block text-gray-700">Adresse professionnelle :</label>
                    <input type="text" wire:model="professional_address" class="w-full p-2 border rounded mb-2">

                    <label class="block text-gray-700">Téléphone professionnel :</label>
                    <input type="text" wire:model="professional_phone" class="w-full p-2 border rounded mb-2">

                    <label class="block text-gray-700">SIREN :</label>
                    <input type="text" wire:model="siren" class="w-full p-2 border rounded mb-2">

                    <label class="block text-gray-700">Spécialités :</label>
                    <select multiple wire:model="selectedSpecialities" class="w-full p-2 border rounded">
                        @foreach($specialities as $speciality)
                            <option value="{{ $speciality->id }}">{{ $speciality->nom }}</option>
                        @endforeach
                    </select>
                </div>
            @endif
        </div>

        <button type="submit" class="bg-green-500 text-white px-4 py-2 mt-4 rounded hover:bg-green-600 transition">
            💾 Enregistrer
        </button>

        @if($modeEdit)
            <!-- Bouton de suppression avec confirmation -->
        @if(!\App\Models\User::find($userId)->hasRole("Administrateur"))

            <button type="button" onclick="confirmDeletion({{ $userId }})"
                    class="bg-red-500 text-white px-4 py-2 mt-4 ml-4 rounded hover:bg-red-600 transition">
                🗑 Supprimer le compte
            </button>
        @endif


        @endif
    </form>
</div>

<script>
    function confirmDeletion(userId) {
        if (confirm('❗ Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible !')) {
        @this.call('delete', userId);
        }
    }
</script>

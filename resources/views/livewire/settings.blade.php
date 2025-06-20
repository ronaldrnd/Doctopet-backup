<div class="w-fill-available mx-auto p-6 bg-gray-100 shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-center mb-6">⚙️ Paramètre du compte</h2>

    <!-- Option d'acceptation automatique des rendez-vous -->
    <div class="mb-6">
        <label class="flex items-center space-x-3">
            <input type="checkbox" @if(Auth::user()->acceptsAutoRDV()) checked @endif wire:model="acceptAutoRDV" wire:change="toggleAutoRDV" class="h-5 w-5 text-green-600">
            <span class="text-gray-800">Accepter automatiquement les rendez-vous</span>
        </label>
        <p class="text-sm text-gray-500 mt-1">Si activé, vos rendez-vous seront automatiquement acceptés.</p>
    </div>


    <!-- Option de prise de rendez-vous en ligne -->
    <div class="mb-6">
        <label class="flex items-center space-x-3">
            <input type="checkbox" @if(Auth::user()->accept_online_rdv) checked @endif wire:model="acceptOnlineRDV" wire:change="toggleOnlineRDV" class="h-5 w-5 text-green-600">
            <span class="text-gray-800">Automatiser mes rendez-vous (prise de RDV en ligne)</span>
        </label>
        <p class="text-sm text-gray-500 mt-1">
            Activez cette option pour permettre aux utilisateurs de prendre rendez-vous en ligne.<br>
            Si désactivé, seul votre numéro de téléphone sera affiché.
        </p>
    </div>



    <!-- Code de parrainage -->
    <div class="mb-6">
        <label class="font-semibold text-gray-800">🎁 Votre code de parrainage</label>
        <input type="text" value="{{ $userReferralCode }}" readonly class="w-full p-3 border rounded bg-gray-200">
        <p class="text-sm text-gray-500 mt-1">Partagez ce code avec d'autres professionnels pour bénéficier de réductions.</p>
    </div>

    <!-- Affichage du parrain et réduction si existants -->
    @if ($vouchAmount)
        <div class="mb-6 bg-green-100 border-l-4 border-green-400 p-4 rounded-md">
            <p class="text-green-700 font-semibold">✅ Vous avez une réduction de {{ $vouchAmount }}€ sur votre prochain abonnement !</p>
            <p class="text-sm text-gray-700">Grâce à <strong>{{ $referrerName }}</strong> qui vous a parrainé.</p>
        </div>
    @endif

    <!-- Saisie du code de parrainage SEULEMENT si aucun n'a été utilisé -->
    @if (!$vouchAmount)
        <div class="mb-6">
            <label class="font-semibold text-gray-800">🎟️ Appliquer un code de parrainage</label>
            <input type="text" wire:model="enteredReferralCode" class="w-full p-3 border rounded" placeholder="Entrez un code">
            <button wire:click="applyReferralCode"
                    class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                ➕ Appliquer le code
            </button>
        </div>
    @else
        <div class="mb-6 bg-gray-200 border-l-4 border-gray-400 p-4 rounded-md">
            <p class="text-gray-700 font-semibold">Vous avez déjà utilisé un code de parrainage.</p>
            <p class="text-sm text-gray-600">Vous ne pouvez bénéficier qu'une seule fois de la réduction de parrainage.</p>
        </div>
    @endif

    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mt-4">
            {{ session('success') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mt-4">
            {{ session('error') }}
        </div>
    @endif


    @if(!$isAmbassador)
    <a href="{{ route('plans') }}" class="block text-center bg-blue-600 text-white px-4 py-2 rounded mt-4 hover:bg-blue-700 transition">
        🏆 Gérer mon abonnement
    </a>
    @else
        <div class="mb-6 bg-green-100 border-l-4 border-green-400 p-4 rounded-md">
            <p class="text-green-700 font-semibold">✅ Vous êtes ambassadeur sur notre plateforme, votre abonnement est offert à vie !</p>
        </div>
    @endif



    <!-- 🏥 Gestion des cliniques -->
    <div class="mt-10 border-t pt-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">🏥 Gérer mes cliniques</h2>

        @if($associatedClinics->count())
            <div class="mt-6">
                <h3 class="text-lg font-bold text-gray-800 mb-3">🏥 Cliniques auxquelles vous êtes associé</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($associatedClinics as $clinic)
                        <a href="{{ route('clinics.manage', ['id' => $clinic->id]) }}"
                           class="block bg-white border border-gray-200 shadow-sm hover:shadow-md p-4 rounded-md transition">
                            <p class="text-green-700 font-semibold">🏥 {{ $clinic->name }}</p>
                            <p class="text-sm text-gray-500">{{ $clinic->address }}</p>

                            @if(Auth::id() === $clinic->owner_id)
                                <span class="text-xs text-white bg-green-500 px-2 py-1 rounded mt-2 inline-block">Responsable</span>
                            @else
                                <span class="text-xs text-white bg-blue-500 px-2 py-1 rounded mt-2 inline-block">Membre</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif



        <!-- Créer une clinique -->
        <div class="mt-4 mb-4">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">➕ Créer une nouvelle clinique</h3>
            <input type="text" wire:model.defer="newClinicName" placeholder="Nom de la clinique"
                   class="w-full p-2 border rounded mb-2">
            <div class="flex gap-2">
                <input type="time" wire:model.defer="newClinicOpeningHour" class="w-1/2 p-2 border rounded">
                <input type="time" wire:model.defer="newClinicClosingHour" class="w-1/2 p-2 border rounded">
            </div>
            <button wire:click="createClinic"
                    class="mt-2 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition w-full">
                ➕ Créer la clinique
            </button>
        </div>

        <!-- Rejoindre une clinique -->
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">🔍 Rejoindre une clinique existante</h3>
            <input type="text" wire:model="searchClinic" placeholder="Rechercher une clinique"
                   class="w-full p-2 border rounded mb-2">

            @if(!empty($searchResults))
                <ul class="bg-white border rounded shadow divide-y max-h-60 overflow-y-auto">
                    @foreach($searchResults as $clinic)
                        <li class="p-3 flex justify-between items-center">
                            <div>
                                <p class="font-bold">{{ $clinic->name }}</p>
                                <p class="text-sm text-gray-500">{{ $clinic->address }}</p>
                            </div>
                            <button wire:click="requestJoinClinic({{ $clinic->id }})"
                                    class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                Rejoindre
                            </button>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>


</div>

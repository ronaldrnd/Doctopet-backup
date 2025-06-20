<div class="w-fill-available bg-gray-100 flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-lg p-8 w-full text-center">


        <h1 class="text-3xl font-bold text-gray-800 flex items-center justify-center mb-6">👩‍⚕️ Inscription Professionnel</h1>

        <!-- Barre de progression -->
        <div class="relative mb-10">
            <div class="absolute top-0 left-0 w-full h-2 bg-gray-200 rounded-full">
                <div style="width: calc(({{ $currentStep }} / 6) * 100%)"
                     class="h-2 bg-green-600 rounded-full transition-all duration-500"></div>
            </div>
        </div>

        <!-- Zone d'affichage des erreurs globales -->
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <p class="font-bold">Veuillez corriger les erreurs suivantes :</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif



        @if ($currentStep === 1)
                <div class="mt-5 mb-5 space-y-6">
                    <!-- Titre de la section -->
                    <h3 class="text-2xl font-bold text-gray-800 flex items-center justify-center mb-6">
                        👤 Informations personnelles
                    </h3>


                    <!-- Nom et Prénom côte à côte -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">🧑 Nom et prénom</label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Prénom -->
                        <div>
                            <input type="text" wire:model="firstName" placeholder="Prénom"
                                   class="w-full px-2 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('firstName')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nom -->
                        <div>
                            <input type="text" wire:model="lastName" placeholder="Nom"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('lastName')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">📧 Adresse Email</label>
                    <input type="email" wire:model="email" placeholder="Adresse email"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('email')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>


                    <!-- Mot de passe -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">🔑 Mot de passe</label>
                        <input type="password" wire:model="password" placeholder="Mot de passe"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('password')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmation du mot de passe -->
                    <div class="mt-4">
                        <label class="block font-semibold text-gray-700 mb-2">🔒 Confirmez le mot de passe</label>
                        <input type="password" wire:model="password_confirmation" placeholder="Confirmez le mot de passe"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('password_confirmation')
                        <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>



                    <!-- Adresse personnelle -->
                    <div>
                        <label class="block font-semibold text-gray-700 mb-2">🏠 Adresse postale (personnelle)</label>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Numéro + Rue -->
                            <input type="text" wire:model="personalStreet" placeholder="Numéro + Rue"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                            <!-- Ville -->
                            <input type="text" wire:model="personalCity" placeholder="Ville"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                            <!-- Code Postal -->
                            <input type="text" wire:model="personalPostalCode" placeholder="Code Postal"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <p class="text-sm text-gray-600 italic mt-1">Cette adresse <span class="font-semibold">ne sera pas communiquée</span> à vos clients.</p>
                        <p class="text-sm text-gray-600 italic mt-1">Il s'agit de <span class="font-semibold">votre adresse personnelle</span> utilisée pour calculer la distance avec vos futurs rendez-vous.</p>

                        @error('personalStreet') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        @error('personalCity') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                        @error('personalPostalCode') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                    </div>


                    <!-- Téléphone personnel -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">📞 Numéro de téléphone (personnel)</label>
                    <input type="text" wire:model="personalPhone" placeholder="Votre numéro personnel"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="text-sm text-gray-600 italic mt-1">Ce numéro restera <span class="font-semibold">strictement privé</span>.</p>
                    <p class="text-sm text-gray-600 italic mt-1">Il sera utilisé pour vous envoyé des <span class="font-semibold">rappels SMS</span> pour vos rendez-vous.</p>
                    @error('personalPhone')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton de continuation -->
                <button wire:click="nextStep"
                        class="w-full md:w-auto bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
                    ➡️ Continuer
                </button>
            </div>
        @endif



        @if ($currentStep === 2)
            <!-- Information Box -->
            <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-md">
                <p class="font-semibold">ℹ️ Information :</p>
                <p class="text-sm mt-2">
                    Les services proposés seront automatiquement liés aux spécialités que vous choisissez.
                    Pour plus de détails, consultez notre
                    <a href="{{ route('docs.guide_specialite') }}" class="underline font-bold text-blue-600 hover:text-blue-800">
                        guide des spécialités
                    </a>.
                </p>
            </div>

            <!-- Titre de l'étape -->
            <h3 class="text-lg font-bold flex items-center mb-4">
                🏢 Informations professionnelles
            </h3>

            <!-- Sélection d'une seule spécialité -->
            <div class="grid grid-cols-4 gap-4 mt-6">
                <!-- Spécialités Vétérinaires -->
                @foreach($vetSpecialities as $vetSpeciality)
                    <div>
                        <h4 class="font-bold text-blue-700 mb-2">🐾 Spécialités Vétérinaires</h4>
                        <button
                            wire:click="handleAddSpeciality({{ $vetSpeciality->id }})"
                            class="px-3 py-2 rounded-md mb-2 w-full text-left
                    {{ $selectedSpeciality == $vetSpeciality->id ? 'bg-green-700 text-white' : 'bg-green-500 text-white' }}">
                            {{ $vetSpeciality->nom }}
                        </button>
                    </div>
                @endforeach

                <!-- Autres spécialités -->
                @foreach($otherSpecialities as $otherSpeciality)
                    <div>
                        <h4 class="font-bold text-gray-700 mb-2">🔧 Autres Spécialités</h4>
                        <button
                            wire:click="handleAddSpeciality({{ $otherSpeciality->id }})"
                            class="px-3 py-2 rounded-md mb-2 w-full text-left
                    {{ $selectedSpeciality == $otherSpeciality->id ? 'bg-blue-700 text-white' : 'bg-blue-500 text-white' }}">
                            {{ $otherSpeciality->nom }}
                        </button>
                    </div>
                @endforeach
            </div>


            <!-- Liste des spécialités sélectionnées -->
            <div class="mt-6">
                <h4 class="font-bold text-gray-700">📋 Ma spécialité :</h4>

                @if (!empty($selectedSpeciality))
                    <div class="flex items-center bg-gray-100 p-2 rounded-lg mt-2">
                        <span>{{ \App\Models\Specialite::find($selectedSpeciality)->nom }}</span>
                        <button wire:click="handleRemoveSpeciality"
                                class="ml-auto text-red-500 font-bold hover:text-red-700">
                            ❌
                        </button>
                    </div>
                @else
                    <p class="text-sm text-gray-500 italic mt-2">Aucune spécialité sélectionnée.</p>
                @endif
            </div>


            <!-- Numéro de SIREN -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-1">📑 Numéro de SIREN</label>
                <input type="text" wire:model="siren" placeholder="Votre numéro de SIREN"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                @error('siren')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Adresse du cabinet -->
            <div class="mb-6">
                <label class="block font-semibold text-gray-700 mb-1">🏥 Adresse de votre cabinet</label>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Numéro + Rue -->
                    <input type="text" wire:model="professionalStreet" placeholder="Numéro + Rue"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                    <!-- Ville -->
                    <input type="text" wire:model="professionalCity" placeholder="Ville"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">

                    <!-- Code Postal -->
                    <input type="text" wire:model="professionalPostalCode" placeholder="Code Postal"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                @error('professionalStreet') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                @error('professionalCity') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
                @error('professionalPostalCode') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
            </div>



            <!-- Numéro de téléphone professionnel -->
            <div class="mb-6 mt-6">
                <label class="block font-semibold text-gray-700 mb-1">📞 Numéro de téléphone professionnel</label>
                <input type="text" wire:model="professionalPhone" placeholder="Votre numéro de téléphone professionnel"
                       class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <p class="text-sm text-gray-600 italic mt-1">
                    Ce numéro sera utilisé pour que vos clients puissent vous joindre pour des questions professionnelles.
                </p>
                @error('professionalPhone')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>


            <!-- Bouton de continuation -->
            <button wire:click="previousStep"
                    class="w-full md:w-auto bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
                ⬅️ Etape précédente
            </button>

            <!-- Bouton de continuation -->
            <button wire:click="nextStep"
                    class="bg-green-700 hover:bg-green-800 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition duration-300">
                ➡️ Continuer
            </button>
        @endif



            @if ($currentStep === 3)
                <h3 class="text-2xl font-bold text-gray-800 mb-4">🔒 Vérification de l'identité</h3>

                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-4 rounded-md mb-6">
                    <p class="font-semibold">Un code de vérification (OTP) a été envoyé à votre adresse email : <strong>{{ $email }}</strong>.</p>
                    <p class="text-sm mt-2">Veuillez entrer le code à 6 chiffres ci-dessous pour finaliser votre inscription.</p>
                </div>

                <div class="mb-4">
                    <input type="text" wire:model="otp" maxlength="6" placeholder="Entrez votre code OTP"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-lg tracking-widest">
                    @error('otp')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                @if (session()->has('error'))
                    <div class="text-red-500 text-sm mt-2">{{ session('error') }}</div>
                @endif

                <button wire:click="verifyOtp"
                        class="mt-4 bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                    ✅ Vérifier le code
                </button>

                <button wire:click="sendOtp"
                        class="mt-4 bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg shadow-md transition">
                    🔄 Renvoyer le code
                </button>
            @endif

    </div>
</div>

<div class="min-h-screen bg-gray-100 flex flex-col items-center justify-center">
    <h1 class="text-3xl  text-green-700 font-bold mb-6">Inscrivez-vous sur Doctopet !</h1>






    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-2xl">

        <!-- Progress Bar -->


        <div class="relative mb-6">
            <div class="absolute top-0 left-0 w-full h-2 bg-gray-200 rounded-full">
                <div style="width: calc(({{ $currentStep + 1 }} / 6) * 100%)"
                     class="h-2 bg-green-600 rounded-full transition-all duration-500 ease-in-out"></div>
            </div>
        </div>

        <!-- Registration Steps -->
        <div x-data="{ currentStep: @entangle('currentStep') || 0, userType: @entangle('userType') || 'client' }"
             class="space-y-12">




            <!-- Step 2 -->
            <div x-show="currentStep === 1" x-transition>



                <h2 class="text-2xl font-bold text-green-700 mb-4">👋 Informations personnelles</h2>
                @foreach ($errors->all() as $error)
                    <p class="text-red-500 text-sm mt-2">{{ $error }}</p>
                @endforeach


                <div
                    x-show="currentStep === 1" x-transition
                    class=" mt-4 mb-4" >
                    <a href="{{route("register.pro")}}" class="bg-blue-600 hover:bg-blue-800 font-semibold text-white px-4 py-2 rounded-full">
                        Vous êtes professionnels ? Venez vous inscrire ici :)
                    </a>
                </div>



                <div class="">
                    <div class="flex space-x-4 mb-5">
                        <label>
                            <input type="radio" wire:model="gender" value="M" class="form-radio">
                            Masculin
                        </label>
                        <label>
                            <input type="radio" wire:model="gender" value="F" class="form-radio">
                            Féminin
                        </label>

                    </div>

                    <div class="mb-5">
                    <label>✨ Prénom : </label>
                    <input type="text" wire:model="name" placeholder="Prénom"
                           class="w-full px-4 py-2 border rounded-lg">

                    </div>

                    <div class="mb-5">
                    <label class="mt-5">✨ Nom : </label>
                    <input type="text" wire:model="surname" placeholder="Nom"
                           class="w-full px-4 py-2 border rounded-lg">
                    </div>


                    <label class="mt-5">📅 Date de naissance : </label>
                    <div class="relative max-w-sm">
                        <!-- Icône de calendrier -->
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                            </svg>
                        </div>

                        <!-- Input type date avec wire:model -->
                        <input type="date" id="birthdate" wire:model="birthdate"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5
                dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 px-4 py-4">
                    </div>

                </div>
                <button wire:click="nextStep"
                        class="bg-green-700 text-white px-4 py-2 rounded-md font-bold hover:bg-green-800 mt-6">
                    Continuer
                </button>
            </div>

            <!-- Step 3 -->
            <div x-show="currentStep === 2" x-transition class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-2xl font-bold text-green-700 mb-6 flex items-center">
                    📞 Coordonnées de contact
                </h2>

                @foreach ($errors->all() as $error)
                    <p class="text-red-500 text-sm mt-2">{{ $error }}</p>
                @endforeach

                <div class="space-y-6">
                    <!-- 📞 Téléphone -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">📞 Numéro de téléphone :</label>
                        <input type="text" wire:model="phone" placeholder="Entrez votre téléphone"
                               class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <!-- 📧 E-mail -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">📧 Adresse mail :</label>
                        <input type="email" wire:model="email" placeholder="Entrez votre email"
                               class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <!-- 🔑 Mot de passe -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">🔑 Mot de passe :</label>
                        <input type="password" wire:model="password" placeholder="Mot de passe"
                               class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <!-- 🔑 Confirmation du mot de passe -->
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">🔑 Confirmation du mot de passe :</label>
                        <input type="password" wire:model="password_confirmation" placeholder="Confirmez votre mot de passe"
                               class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                    </div>

                    <!-- 🏠 Adresse complète -->
                    <div class="bg-gray-50 p-4 rounded-lg shadow-md mt-6">
                        <h3 class="text-lg font-semibold text-green-700 mb-4 flex items-center">🏠 Adresse complète</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">🏠 Numéro de rue :</label>
                                <input type="text" wire:model="address_number" placeholder="Ex: 12"
                                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">📍 Nom de la rue :</label>
                                <input type="text" wire:model="address_street" placeholder="Ex: Avenue des Champs-Élysées"
                                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">🏙️ Ville :</label>
                                <input type="text" wire:model="address_city" placeholder="Ex: Paris"
                                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-semibold mb-2">📮 Code postal :</label>
                                <input type="text" wire:model="address_postal_code" placeholder="Ex: 75001"
                                       class="w-full px-4 py-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500 focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- ✅ Acceptation des CGU et Mentions Légales -->
                    <div class="mt-4 flex items-start">
                        <input type="checkbox" wire:model.live="acceptTerms" id="acceptTerms" class="h-5 w-5 text-green-600">
                        <label for="acceptTerms" class="ml-2 text-gray-700 text-sm leading-5">
                            J'accepte les
                            <a href="{{ route('legal.cgu') }}" target="_blank" class="text-green-600 font-semibold hover:underline">Conditions Générales d'Utilisation</a>
                            et les
                            <a href="{{ route('legal.mentions-legales') }}" target="_blank" class="text-green-600 font-semibold hover:underline">Mentions Légales</a>.
                        </label>
                    </div>

                    @error('acceptTerms')
                    <p class="text-red-500 text-sm">{{ $message }}</p>
                    @enderror

                    <!-- 🚀 Bouton Continuer -->
                    <div class="flex justify-center mt-6">
                        <button wire:click="nextStep"
                                class="bg-green-700 text-white font-bold px-6 py-3 rounded-lg shadow-md hover:bg-green-800 transition-all disabled:bg-gray-400 disabled:cursor-not-allowed"
                                @if(!$acceptTerms) disabled @endif>
                            Continuer ➡️
                        </button>
                    </div>
                </div>
            </div>



            <!-- Step 4 -->
                <div x-show="currentStep === 3 && userType === 'professional'" x-transition>
                    <h2 class="text-2xl font-bold text-green-700 mb-4">Informations professionnelles</h2>
                    <div class="space-y-4">
                        <!-- Specialities -->
                        <div class="grid grid-cols-2 gap-4">
                            @foreach($specialitiesList as $speciality)
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="specialities" value="{{ $speciality->id }}" class="form-checkbox">
                                    <span class="ml-2">{{ $speciality->nom }}</span>
                                </label>
                            @endforeach
                        </div>
                        @if ($errors->has('specialities'))
                            <p class="text-red-500 text-sm mt-2">{{ $errors->first('specialities') }}</p>
                        @endif

                        <textarea wire:model="office_address" placeholder="Adresse du cabinet"
                                  class="w-full px-4 py-2 border rounded-lg"></textarea>
                        @if ($errors->has('office_address'))
                            <p class="text-red-500 text-sm mt-2">{{ $errors->first('office_address') }}</p>
                        @endif
                    </div>
                    <button wire:click="nextStep"
                            class="bg-green-700 text-white px-4 py-2 rounded-md font-bold hover:bg-green-800 mt-6">
                        Continuer
                    </button>
                </div>

            <!-- Step 5 -->
            <div x-show="currentStep === 4" x-transition>
                <h2 class="text-2xl font-bold text-green-700 mb-4">Acceptation des termes</h2>
                @if ($errors->has('acceptTerms'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('acceptTerms') }}</p>
                @endif
                <div class="space-y-4">
                    <label class="flex items-center">
                        <input type="checkbox" wire:model="acceptTerms" class="form-checkbox">
                        <span class="ml-2">J'accepte les <a href="#" class="text-blue-600 underline">termes et conditions</a></span>
                    </label>
                </div>
                <button wire:click="nextStep"
                        class="bg-green-700 text-white px-4 py-2 rounded-md font-bold hover:bg-green-800 mt-6">
                    Continuer
                </button>
            </div>

            <!-- Step 6 -->
            <div x-show="currentStep === 5" x-transition>
                <h2 class="text-2xl font-bold text-green-700 mb-4">Vérification OTP</h2>
                <p>Un code OTP a été envoyé à votre adresse e-mail. Veuillez le saisir ci-dessous :</p>
                @if ($errors->has('otp'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->first('otp') }}</p>
                @endif
                <input type="text" wire:model="otp" placeholder="Code OTP"
                       class="w-full px-4 py-2 border rounded-lg">
                <button wire:click="verifyOtp"
                        class="bg-green-700 text-white px-4 py-2 rounded-md font-bold hover:bg-green-800 mt-6">
                    Vérifier
                </button>
            </div>
        </div>

        <!-- Navigation -->
        <div class="flex justify-between mt-6">
            <button wire:click="previousStep"
                    x-show="currentStep > 0"
                    class="bg-gray-300 text-gray-800 px-4 py-2 rounded-md font-bold hover:bg-gray-400">
                Retour
            </button>
        </div>
    </div>


    <style>
        /* Corrige l'affichage du texte après sélection */
        input[type="date"] {
            -webkit-appearance: none;
            appearance: none;
            font-size: 16px;
            padding-top: 8px;
            padding-bottom: 8px;
            background-color: white;
            color: black; /* S'assurer que le texte est visible */
            text-transform: uppercase; /* Aide Safari à forcer le rendu */
        }

        /* Safari cache parfois la date après sélection → On force l'affichage */
        input[type="date"]:not(:placeholder-shown) {
            color: black !important; /* Corrige le bug d'affichage */
        }

        /* Correction spécifique pour Safari */
        input[type="date"]::-webkit-date-and-time-value {
            text-align: left;
            display: block; /* Force Safari à rendre la valeur visible */
        }

        /* Garde l'icône du sélecteur visible */
        input[type="date"]::-webkit-calendar-picker-indicator {
            filter: invert(1);
            opacity: 1;
            cursor: pointer;
        }

    </style>

</div>

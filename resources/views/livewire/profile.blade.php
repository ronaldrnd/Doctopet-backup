<div class="w-fill-available  bg-gray-100 p-10 relative">
    <!-- Fond animé -->
    <div class="absolute top-0 left-0 w-full h-full bg-gradient-to-br opacity-70"></div>

    <!-- Conteneur principal -->
    <div class="relative bg-white shadow-xl rounded-lg p-6 md:p-8 w-full max-w-4xl mx-auto ">
        <!-- Notifications -->
        @if (session()->has('success'))
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Vue profil -->
        <div x-data="{ editing: false }"x-on:closeEditMode.window="editing = false" >
            <!-- Header du profil -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-green-700 text-center md:text-left">
                    @if($user->estSpecialiste() )
                        Profil du practicien
                    @else
                        Profil utilisateur
                    @endif
                </h1>
                @if ($isOwnProfile)
                    <button
                        x-on:click="editing = !editing"
                        class="bg-yellow-500 text-white px-4 py-2 rounded-md font-bold hover:bg-yellow-600 transition mt-4 md:mt-0">
                        <span x-show="!editing">Modifier</span>
                        <span x-show="editing">Annuler</span>
                    </button>
                @endif
            </div>

            <!-- Affichage du profil -->
            <div x-show="!editing" class="space-y-6">
                <div class="flex flex-col md:flex-row items-center space-x-0 md:space-x-6 text-center md:text-left">
                    <!-- Image de profil -->
                    <div>
                        @if ($profile_picture)
                            <img src="{{ asset('storage/' . $profile_picture) }}"
                                 alt="Photo de profil"
                                 class="w-40 h-32 rounded-full object-cover border-2 border-green-500 mx-auto md:mx-0">
                        @else
                            <div class="w-40 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-500 mx-auto md:mx-0">
                                <i class="fas fa-user text-4xl"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Informations utilisateur -->
                    <div class="w-full">

                        <div class="flex justify-center md:justify-start items-center">
                            <svg fill="#000000" height="30px" width="30px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 31.192 31.192" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M25.874,19.225c-0.645-1.431-4.575-2.669-4.575-2.669c-2.096-0.739-2.11-1.477-2.11-1.477 c-4.124,8.125-7.252,0.022-7.252,0.022c-0.287,1.096-4.528,2.384-4.528,2.384c-1.238,0.477-1.763,1.191-1.763,1.191 c-1.834,2.717-2.048,8.769-2.048,8.769c0.024,1.38,0.618,1.524,0.618,1.524c4.218,1.882,10.829,2.216,10.829,2.216 c6.792,0.143,11.735-1.929,11.735-1.929c0.717-0.452,0.738-0.811,0.738-0.811C28.019,24.11,25.874,19.225,25.874,19.225z"></path> <path d="M10.898,10.786c0.315,2.612,2.563,5.32,4.603,5.32c2.344,0,4.572-2.846,4.919-5.32c0.132-0.094,0.349-0.321,0.428-0.837 c0,0,0.501-1.791-0.162-1.599c0.232-0.691,0.997-3.381-0.488-5.053c0,0-0.694-0.949-2.385-1.452 c-0.059-0.049-0.119-0.099-0.188-0.147c0,0,0.037,0.043,0.092,0.118c-0.096-0.027-0.198-0.051-0.299-0.075 c-0.091-0.096-0.195-0.195-0.311-0.3c0,0,0.102,0.105,0.225,0.28c-0.047-0.01-0.088-0.022-0.134-0.03 c-0.077-0.117-0.17-0.237-0.289-0.359c0,0,0.05,0.094,0.115,0.242c-0.312-0.229-0.938-0.758-0.938-1.35c0,0-0.391,0.183-0.62,0.517 c0.09-0.275,0.241-0.53,0.487-0.741c0,0-0.258,0.132-0.495,0.418c-0.185,0.104-0.606,0.392-0.748,0.904l-0.134-0.068 c0.066-0.145,0.158-0.298,0.284-0.452c0,0-0.183,0.163-0.343,0.423l-0.271-0.136c0.081-0.151,0.187-0.307,0.331-0.459 c0,0-0.146,0.112-0.3,0.301c0.043-0.176,0.036-0.378-0.512,0.222c0,0-2.469,1.071-3.183,3.288c0,0-0.42,1.001,0.137,3.946 c-0.791-0.374-0.252,1.561-0.252,1.561C10.548,10.465,10.765,10.691,10.898,10.786z M10.85,9.739L10.85,9.739L10.85,9.739z M15.384,0.516c-0.12,0.167-0.224,0.375-0.274,0.63l-0.086-0.033C15.091,0.899,15.204,0.693,15.384,0.516z"></path> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </g> </g></svg>
                            <span class="text-2xl font-bold text-green-700 pl-2"> - {{ $user->name }}</span>
                            @if($user->isVerified())
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 116.87" class="w-6 h-6 mt-1 ml-3">
                                    <polygon fill="#10a64a" fill-rule="evenodd" points="61.37 8.24 80.43 0 90.88 17.79 111.15 22.32 109.15 42.85 122.88 58.43 109.2 73.87 111.15 94.55 91 99 80.43 116.87 61.51 108.62 42.45 116.87 32 99.08 11.73 94.55 13.73 74.01 0 58.43 13.68 42.99 11.73 22.32 31.88 17.87 42.45 0 61.37 8.24"/>
                                    <path fill="#fff" d="M37.92,65c-6.07-6.53,3.25-16.26,10-10.1,2.38,2.17,5.84,5.34,8.24,7.49L74.66,39.66C81.1,33,91.27,42.78,84.91,49.48L61.67,77.2a7.13,7.13,0,0,1-9.9.44C47.83,73.89,42.05,68.5,37.92,65Z"/>
                                </svg>
                            @endif

                            @if($user->isAmbassador())
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300" class="w-10 h-10 ml-3 ">
                                    <g transform="translate(0,300) scale(0.1,-0.1)" fill="#000" stroke="none">
                                        <path d="M1096 2919 c-273 -44 -466 -266 -466 -536 0 -161 49 -282 160 -393 216 -216 564 -212 774 10 72 77 116 154 140 247 72 276 -99 573 -374 653 -79 23 -168 30 -234 19z m209 -54 c219 -57 375 -262 375 -493 0 -391 -451 -632 -782 -419 -149 96 -228 246 -228 431 1 140 44 247 142 347 121 125 319 179 493 134z"/>
                                        <path d="M635 1792 c-134 -71 -252 -212 -306 -369 -27 -78 -81 -542 -68 -587 10 -37 42 -70 82 -85 19 -7 246 -11 692 -11 l663 0 4 32 c5 28 -1 38 -39 75 -89 87 -87 176 8 256 40 35 41 36 29 73 -16 47 -8 119 17 153 27 36 99 71 149 71 37 0 42 3 47 28 3 15 17 44 31 65 l26 38 -37 57 c-51 78 -121 144 -201 191 -98 57 -103 58 -160 17 -142 -103 -356 -149 -531 -116 -75 14 -176 57 -254 106 -37 24 -71 44 -75 44 -4 0 -38 -17 -77 -38z m141 -47 c61 -41 179 -90 254 -106 31 -7 101 -9 169 -7 140 6 237 34 355 104 l79 46 55 -26 c102 -50 222 -170 222 -221 0 -44 -32 -85 -75 -96 -70 -18 -94 -30 -129 -69 -43 -48 -60 -99 -53 -163 6 -46 4 -52 -28 -89 -85 -100 -87 -188 -5 -281 17 -20 29 -41 25 -47 -4 -7 -213 -10 -631 -10 -666 0 -678 1 -703 48 -6 12 -11 41 -11 66 0 73 39 405 55 474 23 96 77 193 149 269 60 64 173 143 205 143 8 0 38 -16 67 -35z"/>
                                        <path d="M2040 1418 c-11 -18 -22 -44 -25 -59 -11 -49 -40 -69 -100 -69 -107 0 -119 -16 -90 -126 17 -67 14 -75 -54 -132 -28 -24 -51 -52 -51 -62 0 -10 25 -40 55 -66 30 -26 57 -55 60 -64 3 -9 -2 -38 -10 -66 -22 -74 -20 -103 11 -114 14 -6 49 -10 78 -10 57 0 87 -20 101 -70 29 -100 55 -111 138 -55 28 19 59 35 67 35 9 0 40 -16 70 -35 58 -36 91 -43 107 -23 5 7 18 36 27 63 25 70 46 85 116 85 41 0 64 5 81 19 l23 18 -18 67 c-10 36 -16 76 -12 89 3 13 26 38 51 56 80 58 80 84 0 142 -25 18 -48 43 -51 56 -4 13 2 53 12 89 l18 67 -23 18 c-17 14 -40 19 -80 19 -33 0 -65 6 -76 14 -11 8 -31 43 -45 77 -16 41 -32 65 -43 67 -10 2 -45 -12 -77 -32 -32 -20 -66 -36 -77 -36 -10 0 -43 16 -73 35 -30 19 -62 35 -72 35 -10 0 -27 -14 -38 -32z m105 -48 c63 -37 85 -37 153 1 29 16 58 29 63 27 4 -2 21 -28 36 -57 34 -67 64 -89 123 -92 78 -4 81 -9 58 -94 -11 -40 -10 -50 7 -81 11 -20 34 -48 52 -61 41 -31 42 -55 4 -82 -16 -12 -40 -38 -52 -57 -21 -35 -22 -40 -9 -101 15 -76 10 -83 -55 -83 -60 0 -102 -31 -131 -95 -13 -30 -28 -55 -34 -55 -6 0 -36 13 -67 30 -31 16 -61 30 -68 30 -7 0 -39 -14 -70 -30 -31 -17 -63 -30 -70 -30 -7 0 -20 20 -29 45 -25 64 -75 105 -129 105 -62 0 -80 16 -67 60 22 76 14 107 -41 166 l-52 54 52 54 c43 47 51 61 51 94 0 21 -5 54 -12 72 -9 29 -9 35 7 47 11 7 36 13 57 13 58 0 93 23 119 77 24 52 38 73 48 73 3 0 29 -14 56 -30z"/>
                                        <path d="M2183 1238 c-12 -13 -33 -47 -47 -75 -27 -55 -32 -57 -114 -67 -48 -5 -92 -38 -92 -68 0 -11 25 -46 56 -79 l57 -59 -13 -59 c-15 -71 -8 -105 25 -127 27 -17 34 -15 132 42 l32 19 74 -39 c65 -33 77 -36 95 -25 44 27 47 67 16 171 -3 11 14 35 51 72 55 55 64 80 45 116 -11 21 -60 40 -106 40 -51 0 -63 9 -91 64 -30 61 -61 96 -83 96 -9 0 -26 -10 -37 -22z m87 -98 l32 -80 63 0 c70 0 115 -13 115 -32 0 -7 -29 -37 -64 -66 l-63 -52 18 -67 c23 -82 24 -113 4 -113 -8 0 -46 20 -83 44 l-69 44 -69 -44 c-105 -67 -111 -62 -82 54 l20 81 -33 28 c-97 80 -103 88 -85 106 13 13 35 17 91 17 l73 0 32 80 c23 58 37 80 50 80 13 0 27 -22 50 -80z"/>
                                        <path d="M1835 507 c-7 -18 -40 -90 -74 -160 -34 -73 -57 -135 -54 -144 6 -16 16 -16 130 3 l41 6 25 -48 c38 -74 63 -102 78 -86 8 7 45 78 84 157 l70 145 -41 -6 c-75 -11 -161 55 -179 137 -6 24 -12 29 -36 29 -24 0 -33 -6 -44 -33z m103 -107 c19 -22 53 -46 78 -56 24 -9 44 -18 44 -19 0 -10 -81 -175 -89 -179 -5 -4 -20 12 -32 34 -34 59 -59 73 -125 64 -30 -3 -54 -3 -54 1 0 10 92 207 104 224 8 11 13 9 26 -9 8 -12 30 -39 48 -60z"/>
                                        <path d="M2526 501 c-35 -88 -110 -140 -182 -127 -19 4 -34 6 -34 4 0 -2 34 -72 75 -156 57 -118 79 -153 92 -150 9 2 33 34 52 71 l36 68 50 -7 c90 -13 119 -11 123 10 2 10 -29 87 -69 172 -68 142 -75 154 -100 154 -22 0 -30 -7 -43 -39z m104 -127 c27 -59 50 -114 50 -122 0 -12 -10 -13 -55 -7 -54 6 -56 6 -88 -28 -17 -19 -39 -45 -48 -58 l-17 -24 -42 86 c-43 87 -47 119 -13 119 29 0 87 47 117 95 16 25 33 45 37 45 5 0 31 -48 59 -106z"/>
                                    </g>
                                </svg>
                            @endif

                        </div>



                        <div class="text-gray-600 mt-2 flex items-center justify-center md:justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                            <p class="text-gray-600 ml-2">{{$user->email }}</p>

                        </div>

                        @if( (\Illuminate\Support\Facades\Auth::id() != $user->id && $user->type == "S") || $user->type == "S" || \Illuminate\Support\Facades\Auth::id() == $user->id )

                            <div class="text-gray-500 mt-2 flex items-center justify-center md:justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mt-2 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                            <p class="text-gray-500 mt-2 ml-2">

                                @if($user->type == "S")
                                    {{ $user->professional_phone ?? 'Non renseigné' }}
                                @else
                                    {{ $user->phone_number ?? 'Non renseigné' }}
                                @endif

                            </p>

                        </div>


                        <div class="flex pt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mt-2 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                            </svg>
                            <p class="text-gray-500 mt-2">

                                @if($user->type == "S")
                                    <a class="underline text-blue-500 ml-2" target="_blank" href="https://www.google.fr/maps/search/{{$user->professional_address}}">
                                        {{ $user->professional_address ?? 'Non renseignée' }}
                                    </a>
                                @else
                                    <a class="underline text-blue-500 ml-2" target="_blank" href="https://www.google.fr/maps/search/{{$user->address}}">
                                        {{ $user->address ?? 'Non renseignée' }}
                                    </a>
                                @endif


                            </p>
                        </div>


                        @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id)




                        <div class="flex mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mt-2 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8.25v-1.5m0 1.5c-1.355 0-2.697.056-4.024.166C6.845 8.51 6 9.473 6 10.608v2.513m6-4.871c1.355 0 2.697.056 4.024.166C17.155 8.51 18 9.473 18 10.608v2.513M15 8.25v-1.5m-6 1.5v-1.5m12 9.75-1.5.75a3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0 3.354 3.354 0 0 0-3 0 3.354 3.354 0 0 1-3 0L3 16.5m15-3.379a48.474 48.474 0 0 0-6-.371c-2.032 0-4.034.126-6 .371m12 0c.39.049.777.102 1.163.16 1.07.16 1.837 1.094 1.837 2.175v5.169c0 .621-.504 1.125-1.125 1.125H4.125A1.125 1.125 0 0 1 3 20.625v-5.17c0-1.08.768-2.014 1.837-2.174A47.78 47.78 0 0 1 6 13.12M12.265 3.11a.375.375 0 1 1-.53 0L12 2.845l.265.265Zm-3 0a.375.375 0 1 1-.53 0L9 2.845l.265.265Zm6 0a.375.375 0 1 1-.53 0L15 2.845l.265.265Z" />
                            </svg>


                            <p class="text-gray-500 mt-2 ml-2"> {{  $this->formatDate($user->birthdate) ?? 'Non renseignée' }}</p>

                        </div>
                            @endif
                        @endif

                        @if($user->type === 'S')
                        <p class="text-lg font-medium mt-4">
                            Statut :
                            <span class="{{ $user->type === 'S' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ $user->type === 'S' ? 'Spécialiste de santé' : 'Utilisateur simple' }}
                            </span>

                        </p>
                        @endif

                    </div>
                </div>


                @if($user->type === 'S')
                    <div class="bg-white shadow-lg rounded-lg p-6 mt-6">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">⭐ Avis des Patients</h3>

                        @if($reviews->isEmpty())
                            <p class="text-gray-500">Aucun avis pour le moment.</p>
                        @else
                            <ul class="space-y-4">
                                @foreach($reviews as $review)
                                    <li class="bg-gray-100 p-4 rounded-md">
                                        <div class="flex items-center">
                                            <p class="font-semibold text-gray-700">{{ $review->user->name }}</p>
                                            <span class="ml-2 text-yellow-500">
                                {{ str_repeat('⭐', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </span>
                                        </div>
                                        <p class="text-gray-600 mt-2">{{ $review->comment }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <div class="mt-4">
                            {{ $reviews->links() }}
                        </div>
                    </div>
                @endif



                <!-- Spécialités -->
                @if($user->type === 'S' && $user->specialites->count() > 0)
                    <div>
                        <h2 class="text-xl font-bold text-gray-700">Spécialités</h2>
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach($user->specialites as $speciality)
                                <a href="{{ route('specialities.index', $speciality->id) }}"
                                   class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full hover:bg-green-200 transition">
                                    {{ $speciality->nom }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Prestations disponibles -->
                @if($user->type === 'S' && count($services) > 0)
                    <div class="mt-8">
                        <h2 class="text-xl font-bold text-gray-700 text-center md:text-left">Prestations disponibles</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($services as $service)
                                @if ($service['is_enabled'])
                                    <div class="bg-gray-100 shadow rounded-lg p-4">
                                        <h3 class="text-lg font-bold text-green-700">{{ $service['name'] }}</h3>
                                        <p class="text-gray-600">{{ $service['description'] }}</p>
                                        <p class="text-gray-600 mt-2"><strong>Prix :</strong> {{ $service['price'] }} €</p>
                                        <p class="text-gray-600"><strong>Durée :</strong> {{ $service['duration'] }} minutes</p>

                                        @if($user->accept_online_rdv)

                                        <a href="{{ route('service.appointment',$service['id'])}}"
                                           class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                            Prendre rendez-vous
                                        </a>
                                        @else
                                            <p class="text-gray-600 mt-8">Ce professsionnel(le) n'accepte pas la prise de rendez vous en ligne. Vous pouvez prendre rendez-vous au <a class="text-blue-500 underline"  href="tel:{{$user->professional_phone}}">{{$user->professional_phone}}</a></p>
                                        @endif



                                    </div>
                                @else
                                    <div class="bg-gray-200 shadow rounded-lg p-4 opacity-50">
                                        <h3 class="text-lg font-bold text-red-500">{{ $service['name'] }}</h3>
                                        <p class="text-gray-500">Cette prestation est actuellement désactivée.</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @elseif($user->type === 'S' && count($services) == 0)
                    <p class="text-gray-500 mt-4">Ce praticien n'a pas encore de prestations disponibles.</p>
                @endif
            </div>

            <!-- Mode édition -->
            <div x-show="editing" x-cloak class="space-y-6">
                <form wire:submit.prevent="updateProfile">
                    <!-- Image de profil -->
                    <div class="flex items-center space-x-6">
                        @if ($profile_picture)
                            <img src="{{ asset('storage/' . $profile_picture) }}"
                                 alt="Photo de profil"
                                 class="w-32 h-32 rounded-full object-cover border-2 border-green-500">
                        @else
                            <div class="w-32 h-32 rounded-full bg-gray-300 flex items-center justify-center text-gray-500">
                                <i class="fas fa-user text-4xl"></i>
                            </div>
                        @endif
                        <div>
                            <label for="newProfilePicture" class="block text-sm font-medium text-gray-700">Changer la photo de profil</label>
                            <input type="file" wire:model="newProfilePicture" id="newProfilePicture" class="mt-2 block w-full border">
                            @error('newProfilePicture') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Informations utilisateur -->
                    <div class="mt-2 mb-2">
                        <label for="name" class="block text-sm font-medium text-gray-700">Nom complet</label>
                        <input type="text" wire:model="name" id="name" class="mt-1 block w-full border-2 p-1 border-black rounded-md ">
                        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Adresse e-mail</label>
                        <input type="email" wire:model="email" id="email" class="mt-1 block w-full border-2 p-1 border-black rounded-md">
                        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
                        <input type="text" wire:model="phone_number" id="phone_number" class="mt-1 block w-full border-2 p-1 border-black rounded-md">
                        @error('phone_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="mt-2 mb-2">
                        <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" wire:model="address" id="address" class="mt-1 block w-full border-2 p-1 border-black rounded-md">
                        @error('address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    @if($user->type == "S")
                        <div class="mt-2 mb-2">
                            <label for="professional_phone" class="block text-sm font-medium text-gray-700">Téléphone professionnel</label>
                            <input type="text" wire:model="professional_phone" id="professional_phone" class="mt-1 block w-full border-2 p-1 border-black rounded-md">
                            @error('professional_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="mt-2 mb-2">
                            <label for="professional_address" class="block text-sm font-medium text-gray-700">Adresse professionnelle</label>
                            <input type="text" wire:model="professional_address" id="professional_address" class="mt-1 block w-full border-2 p-1 border-black rounded-md">
                            @error('professional_address') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    @endif




                    <div class="mt-2 mb-2">
                        <label for="birthdate" class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" wire:model="birthdate" id="birthdate" class="mt-1 block w-full border-2 p-1 border-black rounded-md">
                        @error('birthdate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Spécialités -->
                    @if($user->type === 'S')
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Spécialités</label>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                @foreach($allSpecialities as $speciality)
                                    <label class="flex items-center">
                                        <input type="checkbox" wire:model="specialities" value="{{ $speciality->id }}" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <span class="ml-2">{{ $speciality->nom }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Bouton de sauvegarde -->
                    <button type="submit" class="bg-green-700 text-white px-6 py-2 rounded-md hover:bg-green-800 transition mt-4">
                        Sauvegarder les modifications
                    </button>
                </form>
            </div><!-- Section Animaux de Compagnie -->


            @if(\Illuminate\Support\Facades\Auth::user()->type === 'S' || Auth::id() === $user->id)
                <div class="bg-gray-100 border border-gray-300 rounded-lg p-6 mt-10">
                    <!-- 🛑 Confidentialité -->
                    <div class="mb-4 flex items-center text-gray-700">
                        <span class="text-lg">🔒</span>
                        <p class="ml-2 italic text-sm">
                            Ces informations sont <span class="font-bold">confidentielles</span> et accessibles uniquement par vous et les spécialistes vétérinaires.
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-green-700 flex items-center">
                        🐾 Animaux de Compagnie
                    </h2>

                    <!-- Bouton Ajouter un Animal -->
                    @if(Auth::id() === $user->id)
                        <div class="mt-4">
                            <a href="{{ route('animals.index') }}"
                               class="bg-green-600 text-white px-4 py-2 rounded-md font-semibold hover:bg-green-700 transition flex items-center w-fit">
                                ➕ Ajouter un animal
                            </a>
                        </div>
                    @endif

                    <!-- Liste des animaux -->
                    @if($animaux->isNotEmpty())
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
                            @foreach($animaux as $animal)
                                <div class="bg-white shadow-md rounded-lg p-6 flex flex-col items-center transition-transform duration-300 hover:scale-105">
                                    <!-- Photo de profil de l'animal -->
                                    <a  @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id) href="{{ route('animal.view', $animal->id) }}" @endif  >
                                        <div class="mb-4">
                                            @if($animal->photo)
                                                <img src="{{ asset($animal->photo) }}"
                                                     alt="Photo de {{ $animal->nom }}"
                                                     class="w-32 h-32 rounded-full object-cover border-2 border-green-500">
                                            @else
                                                <div class="w-32 h-32 bg-gray-300 rounded-full flex items-center justify-center shadow-lg">
                                                    @php
                                                        if(isset($animal->race))
                                                                            $isFind = file_exists(public_path('img/races/' . $animal->race->nom . '.png'));
                                                        else
                                                            $isFind = null;
                                                        @endphp

                                                    <img src=" {{asset( $isFind ?  'img/races/' . $animal->race->nom . '.png' : 'img/races/default.png')}}"
                                                         alt="Photo par défaut"
                                                         class="w-28 h-28 object-cover rounded-full">
                                                </div>
                                            @endif
                                        </div>
                                    </a>

                                    <!-- Informations sur l'animal -->
                                    <h3 class="text-lg font-bold text-green-700">
                                        <a @if(\Illuminate\Support\Facades\Auth::user()->id == $user->id) href="{{ route('animal.view', $animal->id) }}">{{ $animal->nom }} @endif</a>
                                    </h3>
                                    <p class="text-gray-600 mt-2"><strong>Espèce:</strong> {{ $animal->espece->nom ?? 'Non renseignée' }}</p>
                                    <p class="text-gray-600"><strong>Race:</strong> {{ $animal->race->nom ?? 'Non renseignée' }}</p>
                                    <p class="text-gray-500 text-sm mt-2"><strong>🗓️ Date de naissance:</strong> {{ $animal->date_naissance }}</p>
                                    <p class="text-gray-500 text-sm"><strong>🏥 Historique médical:</strong> {{ $animal->historique_medical ?? 'RAS' }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 mt-6">Aucun animal enregistré pour le moment.</p>
                    @endif
                </div>
            @endif




            <div id="map"></div>

            <!--
            <style>
                #map { height: 500px; }
            </style>
            <script>
                var map = L.map('map').setView([{{$user->latitude}}, {{$user->longitude}}], 13);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                var marker = L.marker([{{$user->latitude}}, {{$user->longitude}}]).addTo(map);
                marker.bindPopup("<b>{{$user->name}}</b>").openPopup();
            </script>

-->




        </div>
    </div>
</div>

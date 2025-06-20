<header class="bg-green-600 py-6 relative z-50">
    @php
        $agent = new \Jenssegers\Agent\Agent();
        $isMobile = $agent->isMobile();
    @endphp


    <div class="@if(!$isMobile) mx-auto items-center @endif   flex  px-4">

        <!-- Section Gauche (Espace réservé) -->


        <div class="@if(\Illuminate\Support\Facades\Auth::check() && $isMobile)  @else flex items-center flex-1 @endif ">

            @if(Auth::check() && Auth::user()->estSpecialiste() && !$isMobile)
                <button wire:click="switchMode" class="text-white font-bold text-sm sm:text-base hover:underline">
                    Passer en mode {{ $userMode === 'pro' ? 'Patient' : 'Pro' }}
                </button>
            @endif

            @if(Auth::check() && Auth::user()->hasRole('Administrateur'))
                <a href="{{ route('admin.panel') }}"
                   class="bg-red-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-md font-bold hover:bg-red-600 transition">
                    Panel Admin
                </a>
            @endif
        </div>


        <!-- ✅ Section Logo (Collé complètement à gauche) -->
        <div class="flex items-center justify-start w-auto pl-4">
            <a href="{{ route('/') }}">
                <img src="{{ asset('img/logo/doctopet_logo_green.png') }}"
                     alt="Logo Doctopet"
                     class="h-[70px] md:h-[70px] lg:h-28 max-w-[400px] object-contain">
            </a>
        </div>



        <!-- Section Droite (Se connecter / Menu utilisateur) -->
        <div class="flex justify-end flex-1 ">
            @if(Auth::check())
                @if(\Route::current()->uri != "dashboard" && Auth::user()->estSpecialiste() && !$isMobile)
                    <a href="{{ route('dashboard') }}"
                       class="bg-yellow-500 text-white px-3 py-1 sm:px-4 sm:py-2 rounded-md font-bold hover:bg-yellow-600 transition">
                        Mon Dashboard
                    </a>
                @endif

                <!-- Dropdown Menu -->
                    <!-- ✅ Bouton menu utilisateur -->
                    <div class="relative flex items-center">
                        <button onclick="toggleDropdown()" class="ml-2 relative">
                            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : asset('img/default_profile.png') }}"
                                 alt="Profil"
                                 class="w-12 h-12 md:w-14 md:h-14 min-w-[40px] md:min-w-[50px] object-cover rounded-full border-2 border-white flex-shrink-0">
                        </button>


                    <div id="dropdownMenu" class="absolute right-0 top-16 mt-2 w-48 bg-white shadow-lg rounded-lg z-50 hidden">
                        <a href="{{ route('profil', Auth::id()) }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">👤 Mon Profil</a>

                        @if($isMobile)
                            <a href="{{ route('dashboard') }}"
                               class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                🏠 Mon Dashboard
                            </a>
                        @endif

                        @if(Auth::user()->type == "S")
                            <a href="{{ route('subscription.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">⚙️ Gérer mon compte</a>
                        @endif

                        <a class="block px-4 py-2 text-red-500 hover:bg-gray-100"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            🚪 Déconnexion
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}"
                   class="bg-yellow-500 text-white px-3 py-1 mt-8 mb-8 @if($isMobile) ml-8 @endif  sm:px-4 sm:py-2 rounded-md font-bold hover:bg-yellow-600 transition">

                    @if($isMobile)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                        </svg>
                    @else
                    Se connecter
                    @endif
                </a>
            @endif
        </div>
    </div>

    <!-- Notifications -->
    @include("components.notifications")

    <!-- Script pour basculer entre les modes Pro et Client -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            Livewire.on('modeSwitched', () => {
                window.location.reload();
            });

            document.getElementById("switchModeBtn")?.addEventListener("click", function () {
            });
        });
    </script>

    <!-- Script Dropdown -->
    <script>
        function toggleDropdown() {
            document.getElementById("dropdownMenu").classList.toggle("hidden");
        }

        document.addEventListener("click", function(event) {
            let dropdown = document.getElementById("dropdownMenu");
            let button = document.querySelector("button[onclick='toggleDropdown()']");

            if (!button.contains(event.target) && !dropdown.contains(event.target)) {
                dropdown.classList.add("hidden");
            }
        });
    </script>


    <!-- Start of HubSpot Embed Code -->
    <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/49530922.js"></script>
    <!-- End of HubSpot Embed Code -->


</header>

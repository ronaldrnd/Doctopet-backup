@php
    use Jenssegers\Agent\Agent;
    $agent = new Agent();
    $isMobile = $agent->isMobile();
@endphp

<div

    x-data="{ sidebarOpen: {{ $isMobile ? 'false' : 'true' }} }" class="flex h-screen bg-gray-50 relative"
    x-init="window.addEventListener('resize', () => screenWidth = window.innerWidth)"
    class="flex h-screen bg-gray-50 relative"
>
    <!-- Sidebar -->
    <aside
        x-show="sidebarOpen || window.innerWidth >= 768"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        @click.away="sidebarOpen = false"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="absolute overflow-y-auto pl-8 pt-10 left-0 z-40 w-64 bg-white border-r shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:shadow-none h-screen"
    >






    @if(!$isMobile)
        <!-- User Info -->
        <div class="mb-6">


            <div class="flex mb-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>

                <h1 class="text-lg font-bold text-green-600">{{\Illuminate\Support\Facades\Auth::user()->name}}</h1>
            </div>

            <a href="{{route("presentation")}}" class=" text-sm text-blue-500 hover:underline">Contacter le support</a>
        </div>
        @endif

        <!-- Menu -->
        <nav class="space-y-4 mt-10">

            @php
                $agent = new \Jenssegers\Agent\Agent();
                $isMobile = $agent->isMobile();
            @endphp


            @if($isMobile)
                <button wire:click="switchMode" class="text-black font-bold text-sm sm:text-base hover:underline">
                    Passer en mode {{ $userMode === 'pro' ? 'Patient' : 'Pro' }}
                </button>

            @endif


            <!-- Mes Animaux -->
            <a href="{{ route('animals.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">




                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 mr-3" viewBox="0 0 495.779 495.779" fill="currentColor">
                    <path d="M104.546,244.476l-53.277,11.951c-26.723,6.002-46.915,27.989-50.65,55.131c-3.742,27.13,9.752,53.74,33.859,66.752c27.677,14.944,48.759,26.829,51.939,30.009c3.177,3.181,15.074,24.269,30.01,51.947c13.02,24.108,39.629,37.627,66.777,33.885c27.149-3.742,49.112-23.954,55.109-50.687l11.943-53.259c9.149-40.77-3.228-83.393-32.779-112.947C187.931,247.715,145.309,235.338,104.546,244.476z"></path>
                    <path d="M271.636,114.101c-21.915-12.777-53.989,1.418-71.655,31.714c-17.666,30.271-14.242,65.188,7.654,77.961c21.894,12.777,53.963-1.418,71.641-31.696C296.941,161.784,293.525,126.875,271.636,114.101z"></path>
                    <path d="M281.343,97.438c8.895,5.193,20.333,2.192,25.511-6.71c5.201-8.888,20.244-51.264,11.342-56.443c-8.903-5.193-38.377,28.747-43.57,37.642C269.444,80.83,272.433,92.245,281.343,97.438z"></path>
                    <path d="M90.2,209.794c24.097,7.852,52.428-12.8,63.296-46.152c10.867-33.326,0.128-66.744-23.961-74.57c-24.1-7.861-52.469,12.807-63.322,46.144C55.353,168.542,66.092,201.96,90.2,209.794z"></path>
                    <path d="M135.495,70.73c9.799,3.195,20.34-2.171,23.513-11.97c3.195-9.776,8.943-54.371-0.866-57.565c-9.792-3.195-31.42,36.231-34.598,46.016C120.356,57.016,125.696,67.542,135.495,70.73z"></path>
                    <path d="M350.974,296.815c30.304-17.673,44.499-49.747,31.732-71.651c-12.785-21.89-47.693-25.316-77.979-7.631c-30.289,17.666-44.48,49.747-31.699,71.636C285.806,311.065,320.715,314.481,350.974,296.815z"></path>
                    <path d="M462.518,178.594c-5.193-8.892-47.562,6.148-56.445,11.341c-8.903,5.186-11.904,16.615-6.711,25.518c5.194,8.91,16.605,11.896,25.507,6.717C433.765,216.978,467.712,187.497,462.518,178.594z"></path>
                    <path d="M333.146,343.294c-33.352,10.868-54.003,39.208-46.144,63.315c7.841,24.097,41.245,34.828,74.571,23.976c33.345-10.86,54.011-39.214,46.151-63.322C399.899,343.173,366.491,332.426,333.146,343.294z"></path>
                    <path d="M495.595,338.655c-3.187-9.817-47.774-4.069-57.565-0.862c-9.792,3.169-15.154,13.702-11.952,23.52c3.181,9.799,13.703,15.132,23.501,11.951C459.382,370.068,498.798,348.454,495.595,338.655z"></path>
                </svg>


                <span class="text-gray-700 font-medium">Mes animaux</span>
            </a>



            <!-- Gestion des patients -->
            <a href="{{ route('appointments.index') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">


                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>


                <span class="text-gray-700 font-medium">Prise de rendez vous</span>
            </a>

            <!-- Messagerie des patients -->
            <a href="{{route("conversations.overview")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">


                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>

                <span class="text-gray-700 font-medium">Messagerie</span>


                @if($proUnreadCount > 0)
                    <span class="ml-3 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $proUnreadCount }}
                        </span>
                @endif
            </a>


            <!-- Comptabilité -->
            <a href="{{route("client.documents")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>


                <span class="text-gray-700 font-medium">Mes documents</span>
            </a>




            <!--
                <a href="{{route("urgences")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>

                    <span class="text-gray-700 font-medium">Urgence</span>
                </a>

                <a href="{{route("assistant")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 mr-3" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14 2C14 2.74028 13.5978 3.38663 13 3.73244V4H20C21.6569 4 23 5.34315 23 7V19C23 20.6569 21.6569 22 20 22H4C2.34315 22 1 20.6569 1 19V7C1 5.34315 2.34315 4 4 4H11V3.73244C10.4022 3.38663 10 2.74028 10 2C10 0.895431 10.8954 0 12 0C13.1046 0 14 0.895431 14 2ZM4 6H11H13H20C20.5523 6 21 6.44772 21 7V19C21 19.5523 20.5523 20 20 20H4C3.44772 20 3 19.5523 3 19V7C3 6.44772 3.44772 6 4 6ZM15 11.5C15 10.6716 15.6716 10 16.5 10C17.3284 10 18 10.6716 18 11.5C18 12.3284 17.3284 13 16.5 13C15.6716 13 15 12.3284 15 11.5ZM16.5 8C14.567 8 13 9.567 13 11.5C13 13.433 14.567 15 16.5 15C18.433 15 20 13.433 20 11.5C20 9.567 18.433 8 16.5 8ZM7.5 10C6.67157 10 6 10.6716 6 11.5C6 12.3284 6.67157 13 7.5 13C8.32843 13 9 12.3284 9 11.5C9 10.6716 8.32843 10 7.5 10ZM4 11.5C4 9.567 5.567 8 7.5 8C9.433 8 11 9.567 11 11.5C11 13.433 9.433 15 7.5 15C5.567 15 4 13.433 4 11.5ZM10.8944 16.5528C10.6474 16.0588 10.0468 15.8586 9.55279 16.1056C9.05881 16.3526 8.85858 16.9532 9.10557 17.4472C9.68052 18.5971 10.9822 19 12 19C13.0178 19 14.3195 18.5971 14.8944 17.4472C15.1414 16.9532 14.9412 16.3526 14.4472 16.1056C13.9532 15.8586 13.3526 16.0588 13.1056 16.5528C13.0139 16.7362 12.6488 17 12 17C11.3512 17 10.9861 16.7362 10.8944 16.5528Z"></path>
                    </svg>


                    <span class="text-gray-700 font-medium">Assistant IA Doute</span>
                </a>
                -->




            <!-- Import -->
            <a href="{{ route('professional.list') }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

                <span class="text-gray-700 font-medium">Recherche par spécialité</span>
            </a>



            <!-- Mon profil -->
            <a href="{{ route('profil', Auth::id()) }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100 mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-1 mb-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span class="text-gray-700 font-medium">Mon profil</span>
            </a>

            <!-- If logged in -->
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-gray-700 font-medium hover:underline mt-2">

                <div class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" stroke="currentColor" class="w-6 h-6 text-green-600 mr-1">
                        <path d="M497 273L329 441c-15 15-41 4.5-41-17v-96H152c-13.3 0-24-10.7-24-24v-96c0-13.3 10.7-24 24-24h136V88c0-21.4 25.9-32 41-17l168 168c9.3 9.4 9.3 24.6 0 34zM192 436v-40c0-6.6-5.4-12-12-12H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h84c6.6 0 12-5.4 12-12V76c0-6.6-5.4-12-12-12H96c-53 0-96 43-96 96v192c0 53 43 96 96 96h84c6.6 0 12-5.4 12-12z"/>
                    </svg>

                    Se déconnecter

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            </a>



        </nav>

    </aside>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function updateSidebarTop() {
                let header = document.querySelector("header");
                let sidebar = document.querySelector("aside");
                if (header && sidebar) {
                    let headerHeight = header.offsetHeight;
                    let scrollY = window.scrollY;
                    // Laisser un espace minimum sous le header même en scrollant
                    let newTop = Math.max(headerHeight - scrollY, 0);
                    sidebar.style.setProperty("top", newTop + "px", "important");
                }
            }

            // Exécuter immédiatement après le chargement
            updateSidebarTop();

            // Mettre à jour en cas de redimensionnement et de scroll
            window.addEventListener("resize", updateSidebarTop);
            window.addEventListener("scroll", updateSidebarTop);
        });
    </script>


    <style>
        aside {
            top: 0px !important;
        }

    </style>



    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <!-- Top Bar (with Hamburger Menu on Mobile) -->
        <header class="w-full bg-white shadow-md p-4 flex items-center justify-between md:hidden">
            <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>
        </header>
    </div>
</div>

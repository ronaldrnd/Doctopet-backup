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
        class="fixed bottom-0 top-[var(--top-offset)] overflow-y-auto left-0 z-40 w-80 bg-white border-r shadow-lg transform transition-transform duration-300 ease-in-out md:translate-x-0 md:static md:shadow-none h-screen"
        >


        <div class="p-6 flex flex-col h-full">


            @if(!$isMobile)
            <!-- Nom et prénom de l'utilisateur -->
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


                <!-- Agenda -->
                <a href="{{route("appointments.calendar")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>


                    <span class="text-gray-700 font-medium mr-4">Agenda</span>


                    @if($pendingAppointmentsCount > 0)
                        <span class="top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $pendingAppointmentsCount }}
                        </span>
                    @endif

                </a>

                <!-- Messagerie des patients -->
                <a href="{{route("conversations.pro.to.client")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">


                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                    </svg>

                    <span class="text-gray-700 font-medium">Messagerie des patients</span>


                    @if($clientUnreadCount > 0)
                        <span class="bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $clientUnreadCount }}
                        </span>
                    @endif
                </a>

                <!-- Gestion des services -->
                <a href="{{route("professional.services")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">


                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>



                    <span class="text-gray-700 font-medium">Gestion des services</span>
                </a>




                @if(Auth::user()->specialites->contains('nom', 'Éleveurs'))
                    <!-- Gestion des services -->
                    <a href="{{route("dashboard.eleveur")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">


                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1084 980" class="w-6 h-6 text-green-600 mr-3">
                            <path fill="#fefefe" d="M0 0h1084v980H0V0z"/>
                            <path fill="#16a34a" d="M369 0c38 9 69 31 91 66 12 18 21 37 27 58 2 2 2 4 2 6 17 70 6 135-33 195-12 15-26 29-42 40-49 28-96 25-140-10-16-12-30-25-42-41-39-60-50-126-33-196 1-3 1-5 0-7 6-21 15-40 27-58 22-35 53-57 91-66h28z"/>
                            <path fill="#16a34a" d="M715 10c-9 0-18 0-27 1-6 0-12 1-18 2 6-1 12-1 18-1 4 0 8 1 12 1h15z"/>
                            <path fill="#16a34a" d="M715 10c26 3 49 13 68 30 34 34 53 75 58 123 2 27 1 54-5 80-2 8-4 16-7 24-10 33-28 61-54 84-22 17-47 27-75 28-28 0-52-10-74-28-24-22-41-50-51-83-2-11-5-21-7-32-7-48 0-94 20-138 6-12 13-23 20-34 7-9 13-17 20-25 18-16 38-26 61-31 9-1 18-1 27-1z"/>
                            <path fill="#16a34a" d="M94 258c16-1 31 0 47 5 24 9 46 21 66 39 44 42 70 93 77 154 3 29 0 58-10 85-12 33-35 55-68 65-10 3-21 3-31 3-10 0-20-1-30-3-20-6-38-16-54-30-44-39-72-87-84-144-1-9-2-18-3-27V367c3-23 10-45 22-65 17-25 41-39 72-43z"/>
                            <path fill="#16a34a" d="M1084 382v38c0 14-1 28-3 42-1 3-1 5-2 8-2 13-5 26-9 38-2 6-4 12-6 18-7 16-14 31-23 46-11 16-21 32-34 46-23 31-52 53-88 67-44 14-83 6-117-24-21-23-34-49-39-80-1-5-2-10-2-15v-5c-3-49 8-95 32-138 23-38 55-66 96-85 51-18 95-7 132 33 18 25 29 52 32 83z"/>
                            <path fill="#16a34a" d="M650 967c-8 1-15 3-22 5-7 0-13 1-19 3-6 0-12 1-18 2-5 2-10 2-15 2-6 1-11 1-17 2-14 1-28 2-42 4-17 0-34 0-51 0-43-2-85-8-127-20-54-16-101-43-142-81-23-34-32-71-27-111 8-40 27-73 58-100 15-12 30-25 45-38 18-16 35-33 50-52 19-27 39-52 60-78 100-110 196-107 289 8 23 34 47 67 72 100 25 31 51 62 77 92 10 14 19 29 26 44 17 36 17 72 0 108-15 23-33 42-56 56-49 30-102 49-159 57z"/>
                        </svg>



                        <span class="text-gray-700 font-medium">Gérer mon élevage</span>
                    </a>
                @endif


                <!-- Gestion des patients -->
                <a href="{{route("gestion.patients")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">


                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>



                    <span class="text-gray-700 font-medium">Gestion des patients</span>
                </a>


                <!-- Comptabilité -->
                <a href="{{route("compta.index")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75V18m-7.5-6.75h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V13.5Zm0 2.25h.008v.008H8.25v-.008Zm0 2.25h.008v.008H8.25V18Zm2.498-6.75h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V13.5Zm0 2.25h.007v.008h-.007v-.008Zm0 2.25h.007v.008h-.007V18Zm2.504-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5Zm0 2.25h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V18Zm2.498-6.75h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V13.5ZM8.25 6h7.5v2.25h-7.5V6ZM12 2.25c-1.892 0-3.758.11-5.593.322C5.307 2.7 4.5 3.65 4.5 4.757V19.5a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25V4.757c0-1.108-.806-2.057-1.907-2.185A48.507 48.507 0 0 0 12 2.25Z" />
                    </svg>

                    <span class="text-gray-700 font-medium">Comptabilité</span>
                </a>




                <!-- Tâches -->
                <a href="{{route("task.overview")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-green-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span class="text-gray-700 font-medium">Tâches</span>
                </a>

                <!-- Coopération -->
                <a href="{{route("cooperation")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 mr-3" viewBox="0 0 490.01 490.01" fill="currentColor">
                        <g>
                            <!-- Première partie -->
                            <rect x="-14.319" y="147.421" transform="matrix(0.3244 -0.9459 0.9459 0.3244 -125.6895 185.1588)" width="162.194" height="66.298"></rect>
                            <path d="M169.994,106.097l-6.1,3c-7.6,3.7-16.5,4.2-24.4,1.4l-10.2-3.6c-0.6-0.4-1.2-0.7-1.8-0.9l-62.8-21.5c-4.7-1.6-9.9,0.9-11.5,5.6l-52.7,153.5c-0.8,2.3-0.6,4.8,0.4,6.9s2.9,3.8,5.2,4.6l62.7,21.5c1,0.3,2,0.5,2.9,0.5c3.8,0,7.3-2.4,8.6-6.1l49.7-144.6l3.4,1.2c12.5,4.4,26.5,3.6,38.5-2.2l6.1-3c7.5-3.7,16.3-4.2,24.2-1.5l115.3,39.7c-1.2,4.8-3.6,10.5-8,13.6c-4.9,3.4-12.2,3.4-21.8,0.1l-51.4-17.6c-2.4-0.8-5-0.6-7.2,0.6c-2.2,1.2-3.8,3.3-4.5,5.7c-0.1,0.3-7.2,26.9-29.9,39.1c-14.3,7.7-32.1,8-53,0.9c-4.7-1.6-9.9,0.9-11.5,5.6c-1.6,4.7,0.9,9.9,5.6,11.5c12,4.1,23.3,6.2,33.8,6.2c12.2,0,23.4-2.7,33.6-8.2c20.3-10.9,30.8-30,35.6-41.4l42.9,14.7c15.3,5.3,28.1,4.5,38-2.4c15.9-11,16.7-33.3,16.8-34.3c0.1-4-2.4-7.5-6.1-8.8l-122.4-42.2C195.694,99.497,181.794,100.397,169.994,106.097z M66.194,256.497l-45.6-15.6l46.7-136.3l45.6,15.6L66.194,256.497z"></path>

                            <!-- Deuxième partie -->
                            <rect x="334.311" y="148.377" transform="matrix(-0.4395 -0.8982 0.8982 -0.4395 434.9314 634.4379)" width="162.188" height="66.294"></rect>
                            <path d="M410.194,266.797l-21.5,19.8c-19.5,17.9-41.5,33-65.3,44.6l-114.1,55.8c-5,2.5-11.1,0.4-13.6-4.7c-2.5-5-0.4-11.1,4.7-13.6l1.4-0.7l0,0l62.4-30.5c4.5-2.2,6.4-7.6,4.2-12.1c-2.2-4.5-7.6-6.4-12.1-4.2l-62.4,30.5l0,0l-31.4,15.4c-5,2.5-11.1,0.4-13.6-4.7c-1.2-2.4-1.4-5.2-0.5-7.7c0.9-2.6,2.7-4.6,5.1-5.8l23.7-11.6l0,0l67.8-33.2c4.5-2.2,6.4-7.6,4.2-12.1s-7.6-6.4-12.1-4.2l-67.9,33.3l0,0l-2.6,1.3l-32.4,15.9c-2.4,1.2-5.2,1.4-7.7,0.5c-2.6-0.9-4.6-2.7-5.8-5.1c-2.5-5-0.4-11.1,4.7-13.6l11.2-5.5l0,0l22.9-11.2l6.4-3.1l0,0l52.6-25.8c4.5-2.2,6.4-7.6,4.2-12.1s-7.6-6.4-12.1-4.2l-57,27.9l-24.9,12.2c-5,2.4-11.1,0.4-13.6-4.7c-1.2-2.4-1.4-5.2-0.5-7.7c0.9-2.6,2.7-4.6,5.1-5.8l43.5-21.3c4.5-2.2,6.4-7.6,4.2-12.1s-7.6-6.4-12.1-4.2l-43.5,21.3c-6.8,3.3-11.9,9.1-14.3,16.2s-2,14.8,1.3,21.6c2.1,4.2,5.1,7.7,8.7,10.3c-6.3,8.3-7.9,19.7-3,29.7c3.3,6.8,9.1,11.9,16.2,14.3c3,1,6,1.5,9,1.5c-0.1,4.5,0.8,9,2.9,13.1c4.9,10,15,15.8,25.4,15.8c4.2,0,8.4-0.9,12.4-2.9l6.4-3.1c0.3,3.4,1.2,6.7,2.7,9.9c4.9,10,15,15.8,25.4,15.8c4.2,0,8.4-0.9,12.4-2.9l114.1-55.8c25.4-12.4,48.8-28.4,69.6-47.5l25.5-23.5l58.4-28.6c4.5-2.2,6.4-7.6,4.2-12.1l-71.4-145.5c-1.1-2.2-2.9-3.8-5.2-4.6c-2.3-0.8-4.8-0.6-6.9,0.4l-59.6,29.1c-4.5,2.2-6.4,7.6-4.2,12.1L410.194,266.797z M405.394,106.197l63.3,129.5l-43.3,21.2l-63.3-129.5L405.394,106.197z"></path>
                        </g>
                    </svg>

                    <span class="text-gray-700 font-medium">Coopération</span>

                    @if($proUnreadCount > 0)
                        <span class="top-2 right-2 bg-red-600 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                            {{ $proUnreadCount }}
                        </span>
                    @endif
                </a>


                <a href="{{route("manage_files_pro")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-6 w-6 text-green-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>

                    <span class="text-gray-700 font-medium">Mes documents</span>
                </a>

                <!--
                <a href="#import" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                    <svg class="w-6 h-6 text-green-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    <span class="text-gray-700 font-medium">Import de documents</span>
                </a>
                -->

                <!-- Gestion des stocks -->
                <a href="{{route("stock.index")}}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600 mr-3" viewBox="0 0 256 230" fill="currentColor">
                        <path d="M61.2,106h37.4v31.2H61.2V106z M61.2,178.7h37.4v-31.2H61.2V178.7z M61.2,220.1h37.4v-31.2H61.2V220.1z M109.7,178.7H147v-31.2h-37.4V178.7z M109.7,220.1H147v-31.2h-37.4V220.1z M158.2,188.9v31.2h37.4v-31.2H158.2z M255,67.2L128.3,7.6L1.7,67.4l7.9,16.5l16.1-7.7v144h18.2V75.6h169v144.8h18.2v-144l16.1,7.5L255,67.2z"></path>
                    </svg>
                    <span class="text-gray-700 font-medium">Gestion des stocks</span>
                </a>

                <!-- Mon profil -->
                <a href="{{ route('profil', Auth::id()) }}" class="flex items-center p-3 rounded-lg hover:bg-gray-100">
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
        </div>
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
                    sidebar.style.setProperty("--top-offset", `${newTop}px`);
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

    <div class="flex-1 flex flex-col">
        <!-- Top Bar (with Hamburger Menu on Mobile) -->
        <header class="w-full bg-white shadow-md p-4 flex items-center justify-between md:hidden">
            <button @click="console.log('issou'); sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>
        </header>
    </div>

</div>

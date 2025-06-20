


@auth
    <footer class="bg-gray-100 py-4 px-6 shadow-inner fixed bottom-0 left-1/2 transform -translate-x-1/2 z-50 rounded-lg w-auto w-full sm:w-auto">
        <div class="flex space-x-6 items-center justify-center">
            <!-- Mes documents -->
            <a href="{{ route('client.documents') }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m.75 12 3 3m0 0 3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                </svg>
                <span class="hidden sm:inline text-xs underline mt-1">Mes documents</span>
            </a>

            <!-- Espace compte -->
            <a href="{{ route('profil', Auth::id()) }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span class="hidden sm:inline text-xs underline mt-1">Espace compte</span>
            </a>

            <!-- Vos messages -->
            <a href="{{ route('conversations.overview') }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                </svg>
                <span class="hidden sm:inline text-xs underline mt-1">Vos messages</span>
            </a>

            <!-- Mes Rendez-vous -->
            <a href="{{ route('appointments.overview') }}" class="flex flex-col items-center text-gray-600 hover:text-green-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                </svg>
                <span class="hidden sm:inline text-xs underline mt-1">Mes RDV</span>
            </a>
        </div>
    </footer>
@endauth

<footer class="bg-gray-100 py-6 w-full shadow-inner mt-10">
    <div class="container mx-auto px-6 lg:px-16 flex flex-col md:flex-row items-center justify-center md:justify-between">
        <!-- Logo et Copyright -->
        <div class="text-center md:text-left mb-4 md:mb-0 flex items-center">
            <h2 class="text-lg font-semibold text-green-700 flex items-center">
                <img src="{{ asset('img/logo/doctopet_logo_white_on_green.png') }}" alt="DoctoPet" class="h-8 mr-2">
                Doctopet
            </h2>
            <p class="text-gray-500 text-sm ml-2">&copy; {{ date('Y') }} Tous droits réservés.</p>

        </div>



        <!-- Liens légaux -->
        <div class="flex flex-col items-center md:items-center space-y-2 mb-[5rem]">
            <a href="{{ route('legal.cgu') }}" class="text-gray-600 hover:text-green-600 transition">
                📜 Conditions Générales d'Utilisation
            </a>
            <a href="{{ route('legal.mentions-legales') }}" class="text-gray-600 hover:text-green-600 transition">
                📄 Mentions Légales
            </a>

        </div>

        <!-- Contact -->
        <div class="text-center md:text-right mt-4 mb-8 md:mt-0 flex items-center">
            <a href="{{ route('presentation') }}" class="text-gray-600 hover:text-green-600 underline transition text-lg flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-green-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75v10.5A2.25 2.25 0 0 0 4.5 19.5h15a2.25 2.25 0 0 0 2.25-2.25V6.75M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25m-19.5 0v.243a2.25 2.25 0 0 0 1.07 1.916l7.5 4.615a2.25 2.25 0 0 0 2.36 0l7.5-4.615a2.25 2.25 0 0 0 1.07-1.916V6.75" />
                </svg>
                <span class="ml-2">Contact</span>
            </a>
        </div>
    </div>
</footer>

@php
session()->forget("success");
session()->forget("error","");
session()->forget("warning","");
session()->forget("info","");
@endphp

@livewireScripts

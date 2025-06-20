<div class="min-h-screen bg-gray-50">
    <div class="container mx-auto py-10 px-4">
        <!-- Welcome Section -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h1 class="text-3xl font-bold text-green-700">Bienvenue
                <span class="relative text-green-800 font-extrabold">
                    {{ \Illuminate\Support\Facades\Auth::user()->name }}
                    <span
                        class="absolute inset-x-0 bottom-0 h-1 bg-green-300 rounded-full scale-x-0 origin-left transition-transform duration-300 ease-out group-hover:scale-x-100"
                    ></span>
                </span>
                sur votre tableau de bord
                <br>
                @if(\Illuminate\Support\Facades\Auth::user()->type == "S")Spécialiste de santé Animaux @endif
            </h1>
            <p class="text-gray-600 mt-2">Gérez vos animaux, prenez des rendez-vous et accédez à vos informations en toute simplicité.</p>
        </div>

        <!-- Section Client -->
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-green-700 relative inline-block pt-5">
                Partie Cliente
                <span class="absolute -bottom-1 left-0 w-full h-1 bg-green-300 rounded-full"></span>
            </h1>
        </div>

        <div class="w-full h-1 bg-gray-300 rounded-full mb-6"></div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Manage Animals -->
            <a href="{{ route('animals.index') }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                <img src="{{ asset('img/pictures/manage_animals.png') }}" alt="Gérer mes animaux" class="h-32 mx-auto mb-4">
                <h2 class="text-xl font-bold text-green-700">Gérer mes animaux</h2>
                <p class="text-gray-600 mt-2">Ajoutez, modifiez ou supprimez les informations de vos compagnons.</p>
            </a>

            <!-- Schedule Appointments -->
            <a href="{{ route('appointments.index') }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                <img src="{{ asset('img/pictures/schedule_appointment.png') }}" alt="Prendre un rendez-vous" class="h-32 mx-auto mb-4">
                <h2 class="text-xl font-bold text-yellow-600">Prendre un rendez-vous</h2>
                <p class="text-gray-600 mt-2">Choisissez un créneau avec un professionnel de santé animale.</p>
            </a>

            <!-- Medical Records -->
            <a href="{{ route('medical_records.index') }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                <img src="{{ asset('img/pictures/medical_records.png') }}" alt="Dossiers médicaux" class="h-32 mx-auto mb-4">
                <h2 class="text-xl font-bold text-brown-600">Dossiers médicaux</h2>
                <p class="text-gray-600 mt-2">Consultez et téléchargez les dossiers médicaux de vos animaux.</p>
            </a>

            <!-- Emergency Services -->
            <a href="{{ route('emergency.index') }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                <img src="{{ asset('img/pictures/emergency_services.png') }}" alt="Services d'urgence" class="h-32 mx-auto mb-4">
                <h2 class="text-xl font-bold text-red-600">Services d'urgence</h2>
                <p class="text-gray-600 mt-2">Obtenez une assistance immédiate en cas d'urgence pour votre animal.</p>
            </a>

            <a href="{{ route('profil',\Illuminate\Support\Facades\Auth::user()->id) }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                <img src="{{ asset('img/pictures/profile.png') }}" alt="Mon profil" class="h-32 mx-auto mb-4">
                <h2 class="text-xl font-bold text-blue-600">Mon profil</h2>
                <p class="text-gray-600 mt-2">Accédez à toutes vos données en un clic.</p>
            </a>

            <a href="{{ route('professional.list') }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                <img src="{{ asset('img/pictures/search_profesionnal.png') }}" alt="Liste des professionnels par spécialités" class="h-32 mx-auto mb-4">
                <h2 class="text-xl font-bold text-blue-600">Liste des professionnels par spécialités</h2>
                <p class="text-gray-600 mt-2">Prenez rendez-vous en fonction de vos besoins.</p>
            </a>
        </div>

        <!-- Section Professionnels -->
        @if(auth()->user()->type === 'S')
            <div class="text-center mb-10 mt-16">
                <h1 class="text-3xl font-bold text-green-700 relative inline-block pt-5">
                    Partie Professionnels
                    <span class="absolute -bottom-1 left-0 w-full h-1 bg-green-300 rounded-full"></span>
                </h1>
            </div>

            <div class="w-full h-1 bg-gray-300 rounded-full mb-6"></div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Professional Services -->
                <a href="{{ route('professional.services') }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                    <img src="{{ asset('img/pictures/professional_services.png') }}" alt="Services professionnels" class="h-32 mx-auto mb-4">
                    <h2 class="text-xl font-bold text-blue-600">Services professionnels</h2>
                    <p class="text-gray-600 mt-2">Accédez à vos services professionnels.</p>
                </a>

                <a href="{{ route('apointment.manager_specialist') }}" class="block bg-white shadow-lg rounded-lg p-6 text-center hover:shadow-xl transition">
                    <img src="{{ asset('img/pictures/apointment.manager_specialist.png') }}" alt="Gestion des rendez-vous client" class="h-32 mx-auto mb-4">
                    <h2 class="text-xl font-bold text-blue-600">Gestion des rendez-vous client</h2>
                    <p class="text-gray-600 mt-2">Gérez vos rendez-vous clients facilement.</p>
                </a>
            </div>
        @endif
    </div>
</div>

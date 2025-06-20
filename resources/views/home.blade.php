@php
// CA MARCHE AVEC API BIRD : WORKSPACE
    /*
    use Illuminate\Support\Facades\Http;

    $response = Http::withToken(config('bird.access_key'))
    ->get("https://api.bird.com/workspaces/".config('bird.workspace_id')."/channels");

dd($response->json());

*/

//Forbidden mais plus d'erreur de formatage


// 100% working//
/*
use Illuminate\Support\Facades\Http;

// Properly access the nested SMS channel ID
$smsChannelId = config('bird.channels.sms');

$response = Http::withToken(config('bird.access_key'))
    ->post("https://api.bird.com/workspaces/" . config('bird.workspace_id') . "/channels/" . $smsChannelId . "/messages", [
        "receiver" => [
            "contacts" => [
                [
                    "identifierKey" => "phonenumber",
                    "identifierValue" => "+33781223171"
                ]
            ]
        ],
        "body" => [
            "type" => "text",
            "text" => [
                "text" => "Hello ! Ceci est un test d'envoi de SMS avec Bird API 🚀 pour Doctopet"
            ]
        ]
    ]);

dd($response->json());
*/
@endphp


    <!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | Doctopet</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-white font-sans relative">
<!-- Header -->
@include('includes.header')

<main>
    <div class="bg-green-600 w-full">
    <!-- Hero Section -->
    <section class="relative py-5 text-center h-[40vh] md:h-[50vh] lg:h-[40vh] " x-data="{ showModal: false }">
        <!-- Background Overlay -->
        <div class="absolute inset-x-0 top-0 bottom-[10%] z-0 bg-green-600"></div>

        <!-- Content -->
        <div class="relative z-10 px-4">
            <!-- Macarons graphiques -->
            <img src="{{ asset('img/graphic/green_graphic.png') }}"
                 alt="Macaron vert"
                 class="absolute bottom-[-50px] top-24       -left-20 w-96 sm:w-96 md:w-96 opacity-100 z-0">

            <img src="{{ asset('img/graphic/macaron_marron.png') }}"
                 alt="Macaron marron"
                 class="absolute top-0 -right-5 w-40 sm:w-40 md:w-60 opacity-100 z-10">

            <!-- Texte principal -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-white drop-shadow-lg animate-fade-in pt-7 leading-tight relative z-20">
                PRENEZ SOIN DE VOTRE COMPAGNON EN 1 CLIC
            </h1>

            <!-- Bouton de réservation -->
            <div class="mt-8 flex justify-center">
                @auth
                    <a href="{{ route('appointments.index') }}"
                       class="bg-white mb-10 sm:mb-14 text-green-700 font-bold py-3 px-6 w-[70%] sm:w-[60%] md:w-[40%] rounded-full shadow-md hover:bg-green-100 transition flex items-center justify-center gap-2 text-2xl sm:text-3xl z-20">
                        Prendre un rendez-vous
                        <img src="{{ asset('img/graphic/cursor_rdv.png') }}" alt="Icône flèche" class="w-6 sm:w-8">
                    </a>
                @else
                    <button
                            class="bg-white mb-10 sm:mb-14 text-green-700 font-bold py-3 px-6 w-[70%] sm:w-[60%] md:w-[40%] rounded-full shadow-md hover:bg-green-100 transition flex items-center justify-center gap-2 text-2xl sm:text-3xl z-20">
                        <a href="{{route("login")}}">
                            Prendre un rendez-vous</a>
                        <img src="{{ asset('img/graphic/cursor_rdv.png') }}" alt="Icône flèche" class="w-8">


                    </button>
                @endauth
            </div>

        </div>

        <!-- Modal pour les utilisateurs non connectés -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md relative">
                <button @click="showModal = false" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                    ✕
                </button>
                <h3 class="text-lg font-bold text-gray-800 mb-4">Connexion Requise</h3>
                <p class="text-gray-600 mb-4">Nous vous invitons à créer un compte ou à vous connecter pour réserver un rendez-vous.</p>
                <div class="flex space-x-4">
                    <a href="{{ route('register') }}"
                       class="w-full bg-green-600 text-white py-2 rounded-lg text-center hover:bg-green-700 transition">Créer un compte</a>
                    <a href="{{ route('login') }}"
                       class="w-full bg-gray-300 text-gray-700 py-2 rounded-lg text-center hover:bg-gray-400 transition">Se connecter</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Urgence & Doute Section -->
    <section class="my-8 mt-10 bg-gradient-to-b from-green-600 via-green-100 to-white relative z-5">
        <div class="container mx-auto px-4 relative">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 relative">
                <!-- Urgence -->
                <div class="bg-gray-100 rounded-lg p-6 text-center shadow-md hover:scale-105 transition-transform relative z-10 border-2 border-black">
                    <h3 class="text-2xl font-bold text-green-700">URGENCE</h3>
                    <p class="text-gray-700 mt-4">
                        En cas d'urgence pour votre animal, chaque minute compte. Nos partenaires vétérinaires
                        qualifiés sont là pour assurer la santé de vos compagnons.
                    </p>
                    <a href="{{route('urgences')}}"
                       class="block mt-6 bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-800 transition">
                        Contacter
                    </a>
                </div>

                <!-- Macaron jaune (placé entre les deux blocs) -->
                <img src="{{ asset('img/graphic/macaron_jaune.png') }}"
                     alt="Macaron jaune"
                     class="absolute left-1/2 transform -translate-x-1/2 top-1/2 -translate-y-1/2 w-40 sm:w-40 md:w-60 opacity-100 z-0">

                <!-- Doute -->
                <div class="bg-gray-100 rounded-lg p-6 text-center shadow-md hover:scale-105 transition-transform relative z-10 border-2 border-black">
                    <h3 class="text-2xl font-bold text-green-700">DOUTE</h3>
                    <p class="text-gray-700 mt-4">
                        Vous avez un doute concernant votre animal et vous ne savez pas quoi faire ?
                        Notre conseiller virtuel est là pour vous 7j/7 et 24h/24.
                    </p>
                    <a href="{{route('assistant')}}"
                       class="block mt-6 bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-800 transition">
                        Contacter
                    </a>
                </div>
            </div>
        </div>
    </section>


    </div>

    <!-- Annuaire des Professionnels -->
    <section class="my-16 bg-green-50 flex justify-center items-center mx-auto w-[88%]">
        <div class="bg-green-200 rounded-lg shadow-md px-6 py-8 text-center w-full relative">
            <h2 class="text-2xl md:text-3xl font-bold text-green-700">ANNUAIRE DES PROFESSIONNELS</h2>
            <p class="text-gray-700 italic text-sm mt-2">
                Découvrez l’ensemble des professionnels du secteur animalier référencés sur DoctoPet.
            </p>

            <!-- Bouton redirection annuaire -->
            <div class="relative mt-6 max-w-lg mx-auto">
                <a href="{{ route('search.pro.name') }}"
                   class="w-full px-4 py-3 pr-12 text-gray-800 rounded-full shadow-md border border-gray-300 bg-white focus:ring-2 focus:ring-green-500 focus:outline-none flex justify-between items-center hover:bg-green-100 transition">
                    <span class="text-gray-800 font-bold">Rechercher mon professionnel</span>

                    <!-- Icône Loupe -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6 text-gray-600 hover:text-green-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>


    <!-- Section Professionnels -->
    <section id="professionnels" class="relative bg-green-700 py-16 w-[88%] mx-auto rounded-lg">
        <div class="container mx-auto px-6 md:px-12 flex flex-col md:flex-row items-center relative z-10">

            <!-- Image avec décoration -->
            <div class="relative w-full md:w-1/2 flex justify-center md:justify-start items-center">


                <!-- Image vétérinaire (centrée sur mobile) -->
                <div class="relative z-10 w-full flex justify-center">
                    <img src="{{ asset('img/homepage/veto1_homepage.png') }}"
                         alt="Vétérinaire"
                         class="w-[300px] h-[300px] max-w-[350px] max-h-[350px] md:w-[450px] md:h-[450px] rounded-3xl object-contain mx-auto">
                </div>
            </div>

            <!-- Contenu texte -->
            <div class="w-full md:w-1/2 text-white text-left mt-10 md:mt-0">
                <h2 class="text-3xl md:text-4xl font-bold text-center md:text-left">
                    VOUS ÊTES PROFESSIONNELS ?
                </h2>

                <div class="mt-6 space-y-4">
                    <div class="flex items-start space-x-3">
                        <img src="{{ asset('img/graphic/arrow_yellow.png') }}" alt="Flèche" class="w-20 h-10">
                        <p class="text-lg">Dispensez les meilleurs soins possibles à vos patients</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <img src="{{ asset('img/graphic/arrow_yellow.png') }}" alt="Flèche" class="w-20 h-10">
                        <p class="text-lg">Profitez d’une meilleure qualité de vie au travail</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <img src="{{ asset('img/graphic/arrow_yellow.png') }}" alt="Flèche" class="w-20 h-10">
                        <p class="text-lg">Augmentez les revenus de votre activité</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <img src="{{ asset('img/graphic/arrow_yellow.png') }}" alt="Flèche" class="w-20 h-10">
                        <p class="text-lg">Optimisez votre temps grâce à notre interface professionnelle</p>
                    </div>
                </div>

                <div class="mt-6 w-full flex justify-center">
                    <a href="{{route('presentation.doctopet-pro')}}"
                       class="bg-green-100 text-green-800 px-6 py-3 rounded-md text-lg font-bold hover:bg-green-200 shadow-md transition block text-center w-full md:w-auto whitespace-nowrap">
                        En savoir plus sur nos solutions
                    </a>
                </div>
            </div>
        </div>
    </section>





    <section class="py-16 bg-white relative">
        <div class="container mx-auto px-4 text-center">
            <div class="relative inline-block">
                <h2 class="text-3xl font-bold text-green-900 relative inline-block z-10">
                    LE PARTENAIRE DE VOTRE COMPAGNON
                </h2>
                <img src="{{ asset('img/graphic/yellow_subtile.png') }}"
                     alt="Soulignement"
                     class="absolute -bottom-7 left-1/2 transform -translate-x-1/2 w-48 sm:w-56 md:w-64">
            </div>

            <!-- Conteneur des pictogrammes -->
            <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-12 items-start">
                <!-- Facilité d'accès aux soins -->
                <div class="flex flex-col items-center text-center space-y-4">
                    <img src="{{ asset('img/homepage/soins_acces.png') }}" alt="Accès aux soins" class="h-20">
                    <h3 class="text-xl font-bold text-green-900 relative inline-block">
                        FACILITE L’ACCÈS AUX SOINS
                        <img src="{{ asset('img/graphic/green_subtile.png') }}" alt="Soulignement" class="absolute left-[20px] -bottom-12 w-64">
                    </h3>
                    <p class="text-gray-700 italic text-sm max-w-xs pt-4">
                        Trouvez rapidement un professionnel animaliers près de chez vous et prenez rendez-vous en quelques clics.
                    </p>
                </div>



                <!-- Professionnels certifiés -->
                <div class="flex flex-col items-center text-center space-y-4">
                    <img src="{{ asset('img/homepage/suivis sur mesure.png') }}" alt="Professionnels certifiés" class="h-20">
                    <h3 class="text-xl font-bold text-green-900 relative inline-block w-64 text-center">
                        UN SUIVI SUR-MESURE
                        <img src="{{ asset('img/graphic/green_subtile.png') }}"
                             alt="Soulignement"
                             class="absolute left-1/2 transform -translate-x-1/2 -bottom-12 w-64">
                    </h3>

                    <p class="text-gray-700 italic text-sm max-w-xs pt-4">
                        Tous nos partenaires sont soigneusement sélectionnés et certifiés afin de garantir un service fiable et sécurisé.
                    </p>
                </div>

                <!-- Professionnels certifiés -->
                <div class="flex flex-col items-center text-center space-y-4">
                    <img src="{{ asset('img/homepage/pro_certif.png') }}" alt="Professionnels certifiés" class="h-20">
                    <h3 class="text-xl font-bold text-green-900 relative inline-block">
                        DES PROFESSIONNELS CERTIFIÉS
                        <img src="{{ asset('img/graphic/green_subtile.png') }}" alt="Soulignement" class="absolute left-[20px] -bottom-12 w-64">
                    </h3>
                    <p class="text-gray-700 italic text-sm max-w-xs pt-4">
                        Tous nos partenaires sont soigneusement sélectionnés et certifiés afin de garantir un service fiable et sécurisé.
                    </p>
                </div>
            </div>


        </div>
    </section>

    <!-- Assistance Section -->
    <section class="relative bg-green-600 rounded-lg w-[88%] sm:w-[88%] md:w-[60%] mx-auto py-12 grid grid-cols-1 sm:grid-cols-2 items-center z-5 gap-8 px-4 sm:px-12">

        <!-- Bloc principal (Texte + Bouton) -->
        <div class="flex flex-col items-center sm:items-start justify-center text-center sm:text-left">
            <!-- Titre -->
            <h2 class="text-5xl sm:text-5xl font-bold text-white w-full max-w-xs sm:max-w-md flex flex-col items-center relative">
                DES QUESTIONS ?
                <img src="{{ asset('img/graphic/yellow_subtile.png') }}"
                     alt="Flèche jaune"
                     class="w-[70%] max-w-[180px] sm:max-w-[220px] md:max-w-[260px] mx-auto">
            </h2>


            <p class="text-white mt-2 text-2xl sm:text-2xl italic w-full max-w-xs sm:max-w-md">
                Contactez-nous via notre assistant virtuel
            </p>

            <!-- Bouton -->
            <a href="{{ route('assistant') }}"
               class="mt-6 inline-block bg-green-700 font-bold text-white px-6 sm:px-12 py-3 rounded-full text-2xl sm:text-1xl hover:bg-green-800 shadow-lg transition w-full sm:w-auto text-center">
                DÉMARRER LA DISCUSSION
            </a>
        </div>

        <!-- Image Assistant -->
        <div class="relative flex justify-center">
            <img src="{{ asset('img/homepage/assistant.png') }}"
                 alt="Assistant Virtuel"
                 class="h-auto max-h-[200px] sm:max-h-[300px] object-cover rounded-full">
        </div>

    </section>





</main>





<!-- Footer -->
@include('includes.footer')
</body>

<style>
    h3 {
        min-width: 250px; /* Fixe une largeur minimum pour tous les titres */
        text-align: center;
    }

    img.h-20 {
        max-width: 100px; /* Assure une taille constante pour les images */
    }


    html, body {
        overflow-x: hidden;
    }


    h1 {
        font-size: 2rem; /* 32px sur mobile */
    }

    @media (min-width: 640px) { /* sm: */
        h1 {
            font-size: 3rem; /* 48px sur écran moyen */
        }
    }

    @media (min-width: 1024px) { /* lg: */
        h1 {
            font-size: 4rem; /* 64px sur desktop */
        }
    }


</style>

</html>

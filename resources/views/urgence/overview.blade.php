<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urgence - Doctopet</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">
<!-- Header -->
@include("includes.header")

<div class="main w-full">

    <!-- ✅ Hero Urgence -->
    <section class="text-green-700 bg-gray-100 py-10 mt-14 text-center relative">
        <h1 class="text-5xl font-bold relative z-30">BIENVENUE DANS L’ONGLET URGENCE 🏥</h1>



        <p class="w-[90%] mx-auto italic text-xl text-black mt-2">Veuillez sélectionner une catégorie en fonction de l’heure :</p>
        <!-- Décoration -->
    </section>

    <!-- ✅ Section Urgences Journée & Soirée -->
    <section class="py-8 bg-gray-100">
        <div class="container mx-auto px-4 text-center">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Urgence Journée -->
                <div class="bg-gray-100 border-2 border-green-700 p-6 rounded-lg shadow-md relative z-20">
                    <h3 class="text-3xl font-bold text-black relative inline-block">
                        URGENCE
                        <span class="text-black">JOURNÉE ☀️</span>
                    </h3>
                    <p class="mt-4 text-gray-700">
                        Pour toutes les urgences durant les horaires d’ouverture des cabinets vétérinaires, à partir de <strong>8h</strong> jusqu’à <strong>19h</strong>.
                        Accéder à notre annuaire de recherche pour trouver le <strong>vétérinaire le plus proche de chez vous</strong> rapidement afin qu'il vous conseille.
                    </p>
                    <a href="/urgence-journee"
                       class="block mt-[50px] bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-800 transition">
                        RECHERCHER 🔎
                    </a>
                </div>

                <!-- Urgence Soirée -->
                <div class="bg-gray-100 border-2 border-green-700 p-6 rounded-lg shadow-md relative z-20">
                    <h3 class="text-3xl font-bold text-black relative inline-block">
                        URGENCE

                        <span class="text-black">SOIRÉE 🌙</span>
                    </h3>
                    <p class="mt-4 text-gray-700">
                        Pour toutes les urgences durant les horaires de fermeture des cabinets vétérinaires, à partir de <strong>19h</strong> jusqu’à <strong>8h</strong>.
                        Le <strong>3115</strong> est un numéro de téléphone national <strong>gratuit en France</strong>, dédié aux urgences vétérinaires. Il s'agit d'une <strong>structure privée</strong>.
                        Doctopet ne fait pas de <strong>concurrence déloyale</strong>, il s'agit de <strong>l'unique numéro de téléphone dédié aux urgences vétérinaires</strong>.
                    </p>
                    <a href="tel:3115"
                       class="block mt-6 bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-800 transition">
                        CONTACTER 3115 📞
                    </a>
                </div>
            </div>
        </div>

    </section>


    <!-- ✅ Symptômes d'Urgence -->
    <section class="py-10 bg-gray-100 text-white text-center relative w-[90%] mx-auto ">

        <h2 class="text-5xl text-green-700 font-bold mt-10">QUELS SONT LES SYMPTÔMES D’URGENCES ?</h2>
        <img src="{{ asset('img/graphic/yellow_subtile.png') }}" class="mx-auto  w-72 max-w-96">

        <!-- Décoration -->
    </section>
    <img src="{{ asset('img/graphic/green_graphic.png') }}" class="absolute bottom-0 left-0 w-20 sm:w-24 md:w-32">

    <!-- ✅ Bloc Chien & Chat -->
    <section class="py-6 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 ">
                <!-- Mon chien -->
                <div class="bg-gray-100 border-2 border-black p-6 rounded-lg shadow-md relative max-h-[150vh] md:max-h-[150vh] lg:max-h-[150vh] ">
                    <img src="{{ asset('img/urgence/chien.png') }}" class="h-1/3  mx-auto">
                    <h3 class="text-4xl font-bold text-green-900 flex justify-center items-center mt-5">MON CHIEN</h3>
                    <img src="{{ asset('img/graphic/green_subtile.png') }}" class="mx-auto w-48 -mt-5">

                    <ul class="mt-4 text-gray-700 space-y-3 ">

                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl"> Mon chien est blessé.</span>
                        </li>
                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl">Mon chien a les muqueuses pâles. </span>
                        </li>
                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl">Mon chien a mal à l'oeil et/ou à l'oeil fermé.</span>
                        </li>

                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl"> Mon chien urine du sang.</span>
                        </li>
                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl">Mon chien tousse ou a du mal à respirer. </span>
                        </li>
                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl">Mon chien vomit ou a la diarrhée.</span>
                        </li>
                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl">Mon chien a de la fièvre.</span>
                        </li>


                    </ul>
                </div>

                <!-- Mon chat -->
                <div class="bg-gray-100 border-2 border-black p-6 rounded-lg shadow-md relative max-h-[150vh] md:max-h-[150vh] lg:max-h-[150vh]">
                    <img src="{{ asset('img/urgence/chat.png') }}" class="h-1/3 mx-auto">
                    <h3 class="text-4xl font-bold text-green-900 flex justify-center items-center mt-5">MON CHAT</h3>
                    <img src="{{ asset('img/graphic/green_subtile.png') }}" class="mx-auto w-48 -mt-5">

                    <ul class="mt-4 text-gray-700 space-y-3">
                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl"> Mon chat bave.</span>
                        </li>

                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl"> Mon chat urine du sang.</span>
                        </li>

                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl"> Mon chat tousse ou a du mal à respirer.</span>
                        </li>

                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl"> Mon chat vomit ou a la diarrhée.</span>
                        </li>

                        <li class="flex items-center">
                            <img src="{{ asset('img/graphic/arrow_yellow.png') }}" class="w-20 mt-3 mr-2"> <span class="text-xl"> Mon chat a de la fièvre.</span>
                        </li>

                    </ul>
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



</div>

<style>

</style>
<!-- Footer -->
@include("includes.footer")
</body>
</html>

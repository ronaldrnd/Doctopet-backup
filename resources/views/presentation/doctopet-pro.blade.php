<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DoctoPet Pro</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white font-sans">

<!-- Header -->
@include('includes.header')


<!-- Hero Section -->


<!-- Benefits Section -->
<section class="bg-white py-16 transition duration-500 w-[90%] mx-auto" id="benefits">
    <div class="container mx-auto">
        <h2 class="text-5xl font-bold text-center text-green-700 mb-10">3 BÉNÉFICES POUR VOTRE QUOTIDIEN</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card 1 -->
            <div class="bg-gray-100 p-6  rounded-md text-center">
                <img src="{{ asset('img/doctopet-pro/money_income.png') }}" alt="Revenus" class="h-24 mx-auto mb-4">
                <h3 class="text-xl font-bold text-green-700">Augmentez les revenus</h3>
                <p class="text-gray-600 mt-2">Optimisez votre activité pour améliorer vos revenus.</p>
            </div>
            <!-- Card 2 -->
            <div class="bg-gray-100 p-6  rounded-md text-center">
                <img src="{{ asset('img/doctopet-pro/reduction_charge.png') }}" alt="Administration" class="h-24 mx-auto mb-4">
                <h3 class="text-xl font-bold text-green-700">Réduction de la charge administrative</h3>
                <p class="text-gray-600 mt-2">Simplifiez vos processus grâce à nos outils numériques.</p>
            </div>
            <!-- Card 3 -->
            <div class="bg-gray-100 p-6  rounded-md text-center">
                <img src="{{ asset('img/doctopet-pro/relationnel.png') }}" alt="Relation" class="h-24 mx-auto mb-4">
                <h3 class="text-xl font-bold text-green-700">Améliorez la relation avec vos patients</h3>
                <p class="text-gray-600 mt-2">Renforcez la satisfaction de vos patients.</p>
            </div>
        </div>

    </div>
</section>


<section class="bg-white text-white pt-4 pb-12">
    <div class="container mx-auto text-center">
        <a href="mailto:contact@doctopet.fr"
           class="bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-yellow-500 transition mt-10">
            Contacter notre service client
        </a>
    </div>
</section>


<!-<!-- Solutions Section -->
<!-- Solutions Section -->
<section class="bg-white py-16  mx-auto w-[92%]" id="solutions">
    <div class="container mx-auto">
        <h2 class="text-5xl font-bold text-center  text-green-700 mb-14">À L'AIDE DE NOS SOLUTIONS</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6">
            <!-- Card 1 -->
            <div class="flex justify-center">
                <img src="{{ asset('img/doctopet-pro/dev_client.png') }}"
                     alt="Clientèle"
                     class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-auto object-cover">
            </div>
            <!-- Card 2 -->
            <div class="flex justify-center">
                <img src="{{ asset('img/doctopet-pro/secret_num.png') }}"
                     alt="Secrétariat"
                     class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-auto object-cover">
            </div>
            <!-- Card 3 -->
            <div class="flex justify-center">
                <img src="{{ asset('img/doctopet-pro/suivis_patient.png') }}"
                     alt="Coopération"
                     class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-auto object-cover">
            </div>
            <!-- Card 4 -->
            <div class="flex justify-center">
                <img src="{{ asset('img/doctopet-pro/gestion_finance.png') }}"
                     alt="Continuité"
                     class="w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg h-auto object-cover">
            </div>
        </div>



        <div class="text-center mt-14">
            <a href="{{ route('tester.doctopet-pro') }}"
               class="bg-yellow-500 text-white px-20 py-3 rounded-full shadow-lg hover:bg-yellow-600 transition">
                Tester DoctoPet PRO
            </a>
        </div>
    </div>
</section>



<!-- Serenity Section -->
<section class="bg-green-600 mx-auto border rounded-lg w-[85%] text-white py-16" id="serenity">
    <div class="container mx-auto text-center max-w-5xl">
        <h2 class="text-5xl font-bold mb-10">TESTEZ EN TOUTE SÉRÉNITÉ !</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Card 1 -->
            <div class="bg-white text-gray-700 p-6 rounded-lg text-center w-[90%] max-w-[90%] mx-auto">
                <h3 class="text-xl font-bold mb-4">Installation</h3>
                <p class="text-gray-600 mt-2">
                    Profitez de formations simples et vidéos explicatives pour démarrer facilement.
                </p>
            </div>
            <!-- Card 2 -->
            <div class="bg-white text-gray-700 p-6 rounded-lg text-center w-[90%] max-w-[90%] mx-auto">
                <h3 class="text-xl font-bold mb-4">Service Client</h3>
                <p class="text-gray-600 mt-2">
                    Nos experts sont disponibles pour répondre à toutes vos questions et vous accompagner.
                </p>
            </div>
            <!-- Card 3 -->
            <div class="bg-white text-gray-700 p-6 rounded-lg text-center w-[90%] max-w-[90%] mx-auto">
                <h3 class="text-xl font-bold mb-4">Tarifs</h3>
                <p class="text-gray-600 mt-2">
                    Des prix transparents sans frais cachés pour une utilisation optimale.
                </p>
            </div>
            <!-- Card 4 -->
            <div class="bg-white text-gray-700 p-6 rounded-lg text-center w-[90%] max-w-[90%] mx-auto">
                <h3 class="text-xl font-bold mb-4">Sécurité</h3>
                <p class="text-gray-600 mt-2">
                    Données hébergées dans des serveurs conformes RGPD pour une sécurité maximale.
                </p>
            </div>
        </div>
        <div class="text-center mt-10">
            <a href="{{ route('tester.doctopet-pro') }}"
               class="bg-yellow-500 text-white px-20 py-3 rounded-full shadow-lg hover:bg-yellow-600 transition">
                Tester DoctoPet PRO
            </a>
        </div>
    </div>
</section>



<section class="bg-white text-white py-16" id="serenity">
    <div class="text-center mt-10">

        <h2 class="text-5xl  mx-auto w-[90%] text-green-600 font-bold mb-10">DÉCOUVREZ NOTRE SIMULATEUR DE RENTABILITÉ</h2>


        <livewire:simulator />

    </div>
</section>

<!-- Footer -->
@include('includes.footer')

</body>
</html>

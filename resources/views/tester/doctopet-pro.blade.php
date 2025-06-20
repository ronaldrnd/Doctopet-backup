<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tester Doctopet PRO</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 font-sans">

<!-- Header -->
@include('includes.header')

<!-- Hero Section -->
<section class="bg-green-600 text-white py-16">
    <div class="container mx-auto text-center">
        <h1 class="text-4xl font-bold mb-6">Tester Doctopet PRO</h1>
        <p class="text-xl">Commencez dès maintenant et découvrez nos fonctionnalités exclusives</p>
    </div>
</section>

<!-- Comparison Section -->
<section class="bg-white py-16">
    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-center text-green-700 mb-10">Découvrez nos offres</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
            <!-- Free Version -->
            <div class="bg-gray-100 p-8 rounded-lg shadow-md flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-gray-700 mb-4">Version d'essai gratuite</h3>
                    <p class="text-gray-600 mb-6">
                        Familiarisez-vous avec notre solution avant de vous lancer.
                        <br>
                        <br>
                        Vous bénéficiez d'un <span class="font-bold">mois gratuit sans engagement</span> pour tester notre logiciel et vous faire votre propre avis en ayant accès à l'ensemble de nos fonctionnalités.
                    <p>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Gestion et secrétariat numérique
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Développement de la clientèle
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-green-600 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Continuité des soins pour vos patients
                        </li>
                    </ul>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('register.pro') }}"
                       class="bg-blue-500 text-white px-6 py-3 rounded-lg shadow-lg hover:bg-blue-600 transition">
                        Créer mon compte gratuit
                    </a>
                </div>
            </div>

            <!-- Pro Version -->
            <div class="bg-green-600 text-white p-8 rounded-lg shadow-md flex flex-col justify-between">
                <div>
                    <h3 class="text-2xl font-bold mb-4">Version Pro</h3>
                    <p class="text-white mb-6">
                        Accédez à toutes les fonctionnalités avancées pour maximiser votre productivité.
                    </p>
                    <ul class="space-y-4">
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Gestion complète et secrétariat numérique avancé
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Développement de clientèle avec analyse avancée
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Outils de coopération en équipe et gestion multi-utilisateurs
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Statistiques détaillées pour optimiser votre activité
                        </li>
                        <li class="flex items-center">
                            <svg class="w-6 h-6 text-white mr-3" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                            </svg>
                            Support prioritaire avec experts dédiés
                        </li>
                    </ul>
                </div>
                <div class="mt-6 text-center">
                    <a href="{{ route('register.pro') }}"
                       class="bg-white text-green-600 px-6 py-3 rounded-lg shadow-lg hover:bg-gray-100 transition">
                        Créer mon compte DoctoPet PRO
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
@include('includes.footer')

</body>
</html>


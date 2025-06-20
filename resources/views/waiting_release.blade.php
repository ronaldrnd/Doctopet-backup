<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctopet - Bientôt Disponible !</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-green-100 via-blue-50 to-white min-h-screen flex items-center justify-center">
<div class="text-center p-8 bg-white shadow-xl rounded-lg max-w-xl w-full">

    <!-- Logo -->
    <div class="mb-6">
        <img src="{{ asset('img/logo/doctopet_logo_white_on_green.png') }}" alt="Doctopet Logo" class="mx-auto w-24 h-24 rounded-full border-4 border-green-400 shadow-md">
    </div>

    <!-- Titre principal -->
    <h1 class="text-4xl font-extrabold text-green-600 mb-4 tracking-tight">Doctopet arrive bientôt !</h1>
    <p class="text-gray-600 text-lg mb-6">La plateforme qui connecte les propriétaires d’animaux aux meilleurs professionnels en quelques clics !</p>


    <!-- Compte à rebours -->
    <div class="flex justify-center space-x-6 text-center text-gray-800 text-2xl font-bold mb-8" id="countdown">
        <div>
            <span id="days" class="block text-5xl text-green-600 animate-pulse">00</span>
            <span class="text-sm">Jours</span>
        </div>
        <div>
            <span id="hours" class="block text-5xl text-green-600 animate-pulse">00</span>
            <span class="text-sm">Heures</span>
        </div>
        <div>
            <span id="minutes" class="block text-5xl text-green-600 animate-pulse">00</span>
            <span class="text-sm">Minutes</span>
        </div>
        <div>
            <span id="seconds" class="block text-5xl text-green-600 animate-pulse">00</span>
            <span class="text-sm">Secondes</span>
        </div>
    </div>




    <!-- Formulaire d'accès pour les ambassadeurs -->
    <div class="mt-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-2">Accès Ambassadeur</h2>
        <form method="POST" action="{{ route('ambassador.verify') }}" class="flex flex-col items-center">
            @csrf
            <input type="text" name="access_code" placeholder="Entrez votre code d'accès" class="p-2 border border-gray-300 rounded-lg w-64 text-center">
            <button type="submit" class="mt-3 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                Valider
            </button>
        </form>

        @if(session('error'))
            <p class="text-red-500 mt-2 text-sm">{{ session('error') }}</p>
        @endif
    </div>



    <!-- Footer -->
    <footer class="mt-6 text-sm text-gray-500">
        © 2025 Doctopet. Tous droits réservés.
    </footer>
</div>

<!-- Script JavaScript pour le compte à rebours -->
<script>
    const countdownDate = new Date("Feb 20, 2025 20:00:00").getTime();

    const updateCountdown = setInterval(() => {
        const now = new Date().getTime();
        const distance = countdownDate - now;

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").textContent = days.toString().padStart(2, '0');
        document.getElementById("hours").textContent = hours.toString().padStart(2, '0');
        document.getElementById("minutes").textContent = minutes.toString().padStart(2, '0');
        document.getElementById("seconds").textContent = seconds.toString().padStart(2, '0');

        if (distance < 0) {
            clearInterval(updateCountdown);
            document.getElementById("countdown").innerHTML = "<p class='text-3xl text-green-600 font-bold'>Nous sommes en ligne !</p>";
        }
    }, 1000);
</script>
</body>
</html>

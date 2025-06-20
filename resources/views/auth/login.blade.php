<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion | Doctopet</title>
    @vite('resources/css/app.css')
</head>
<body>
@include("includes.header")

<div class="bg-gray-50 min-h-screen flex flex-col justify-center items-center py-6">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <h2 class="text-2xl font-bold text-green-700 text-center">Connexion</h2>
            <form method="POST" action="{{ route('login') }}" class="mt-6">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-medium">Adresse Email</label>
                    <input id="email" type="email" name="email" required autocomplete="email" autofocus
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-medium">Mot de Passe</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <div class="mb-4 flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="mr-2">
                    <label for="remember" class="text-gray-700">Se souvenir de moi</label>
                </div>
                <button type="submit"
                        class="w-full bg-green-700 text-white font-bold py-2 px-4 rounded-md hover:bg-green-800 transition">
                    Se Connecter
                </button>
            </form>
            <p class="mt-4 text-gray-600 text-center">
                Pas encore de compte ? <a href="{{ route('register') }}" class="text-green-700 font-bold">Inscrivez-vous</a>.
            </p>
        </div>
    </div>
@include("includes.footer")
</body>
</html>

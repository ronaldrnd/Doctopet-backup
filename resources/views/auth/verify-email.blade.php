<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation d'envoi de mail | Doctopet</title>
    @vite('resources/css/app.css')
</head>
@include("includes.header")
<body class="bg-gray-50 font-sans">
<div class="min-h-screen flex flex-col justify-center items-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md text-center">
        <img src="{{ asset('img/pictures/mail_confirmation.png') }}" alt="Confirmation Email" class="mx-auto w-64 mb-6">
        <h1 class="text-2xl font-bold text-green-700">Merci de votre inscription !</h1>
        <p class="text-gray-600 mt-4">
            Un email de confirmation a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception et cliquer sur le lien pour activer votre compte.
        </p>
        <p class="text-gray-500 mt-2">Si vous ne voyez pas l'email, vérifiez vos spams.</p>
        <div class="mt-6">
            <a href="{{ route('login') }}" class="bg-green-700 text-white px-6 py-2 rounded-md shadow-md hover:bg-green-800">
                Retour à la page de connexion
            </a>
        </div>
    </div>
</div>
</body>
</html>
@include("includes.footer")

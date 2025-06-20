<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📜 Conditions Générales d'Utilisation | {{ env("APP_NAME") }}</title>
    @vite('resources/css/app.css')
</head>
<body>


@include("includes.header")

<div class="max-w-4xl mx-auto p-6 bg-white shadow-lg rounded-lg">
    <h1 class="text-2xl font-bold text-green-700 text-center mb-6">📜 Conditions Générales d'Utilisation</h1>
    <iframe src="{{ asset('document/legal/CGU_doctopet.pdf') }}" width="100%" height="600px"></iframe>
</div>
</body>
@include("includes.footer")

</html>

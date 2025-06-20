<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annuaire des professionnels | {{ env("APP_NAME") }}</title>
    @vite('resources/css/app.css')
</head>
@include("includes.header")

<body class="bg-gray-100">
        <livewire:search-professionals  />
</body>
@include("includes.footer")

</html>


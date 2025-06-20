@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>

<body>

<livewire:register-form />
@include("includes.footer")

</body>
</html>

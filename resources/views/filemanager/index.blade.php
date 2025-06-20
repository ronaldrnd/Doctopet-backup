@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des documents | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>

<div class="flex">
    <livewire:dashboard-component />
    <livewire:stock-documents/>
</div>
@include("includes.footer")



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vue de la prestation | {{env("APP_NAME")}}</title>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" type="module" defer></script>
    -->
    @vite('resources/css/app.css')
</head>
@include("includes.header")

<div class="flex">

    <livewire:dashboard-component />
<livewire:service-view  :id="$id"/>

</div>
@include("includes.footer")
</html>


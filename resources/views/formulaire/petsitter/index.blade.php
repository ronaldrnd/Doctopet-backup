@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Petsitter | {{env("APP_NAME")}}</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3.4.4/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1.3.1/dist/chartjs-adapter-luxon.umd.min.js"></script>
    @vite('resources/css/app.css')
</head>

<div class="flex">

    <livewire:dashboard-component />

    <livewire:pet-sitter-appointment
        :animalId="$animalId"
        :specialiteId="$specialiteId"
        :serviceTypeId="$serviceTypeId"
        :serviceTemplateId="$serviceTemplateId" />


</div>
@include("includes.footer")



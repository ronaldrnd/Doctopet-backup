@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètre de la clinique {{$clinic->name}} | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>

<div class="flex">
    <livewire:dashboard-component />
    <livewire:manage-clinic :clinicId="$clinic->id"/>
</div>
@include("includes.footer")



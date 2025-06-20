@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu global des tâches | {{env("APP_NAME")}}</title>
</head>

<div class="flex">
    <livewire:dashboard-component />

    <livewire:tasks-overview />
</div>
@include("includes.footer")

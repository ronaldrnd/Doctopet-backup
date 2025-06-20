<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des prestation | {{env("APP_NAME")}}</title>

</head>
@include("includes.header")

<div class="flex">

    <livewire:dashboard-component />


<livewire:services-overview />

</div>


@include("includes.footer")
</html>

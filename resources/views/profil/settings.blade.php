<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètre du compte | {{env("APP_NAME")}}</title>
</head>

@include("includes.header")

<div class="flex">

    <livewire:dashboard-component />
    <div class="ml-auto mr-auto">
        <livewire:settings/>

    </div>
</div>
@include("includes.footer")



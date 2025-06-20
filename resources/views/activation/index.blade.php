@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation du compte | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>

<div class="flex">


    <livewire:activate-account :token="$token" />

</div>
@include("includes.footer")

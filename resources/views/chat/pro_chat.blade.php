@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversation | {{env("APP_NAME")}}</title>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" type="module" defer></script>
    -->
    @vite('resources/css/app.css')
</head>

<div class="flex">

    <livewire:dashboard-component />


    <livewire:chat-with-clients-component />


</div>
@include("includes.footer")



@include("includes.header")

    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation de RDV | {{ env("APP_NAME") }}</title>
    <!--
    <script src="https://cdn.jsdelivr.net/npm/alpinejs" type="module" defer></script>
    -->
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100">
<div class="container mx-auto mt-8 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold text-center text-green-700 mb-4">Confirmation du rendez-vous</h2>





<livewire:confirm-appointment
    :animalId="$request['animalId']"
    :serviceId="$request['serviceId']"
    :selectedSlotStart="$request['selectedSlot']['start_time']"
    :selectedSlotEnd="$request['selectedSlot']['end_time']"
    :date="$request['selectedSlot']['date']"
/>
</div>



</body>
@include("includes.footer")

</html>

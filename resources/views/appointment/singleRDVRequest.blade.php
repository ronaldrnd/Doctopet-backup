@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prise de rendez vous {{\App\Models\Service::find($serviceId)->name}} | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>

<div>



    <livewire:service-appointment-single :service="$serviceId" />

</div>
@include("includes.footer")
</html>


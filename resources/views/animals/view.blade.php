@include("includes.header")

    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Information sur  {{\App\Models\Animal::find($animal->id)->nom}} | {{env("APP_NAME")}}</title>
    @vite('resources/css/app.css')
</head>
<body>


<div class="flex">
    <livewire:dashboard-component />

<livewire:animal-view :id="$animal->id"/>

</div>
</body>
@include("includes.footer")
</html>

@include("includes.header")
    <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu tâche | {{env("APP_NAME")}}</title>
</head>

<div class="flex">
    <livewire:dashboard-component />

    <livewire:task-item :taskId="$id" />
</div>
@include("includes.footer")

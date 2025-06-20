<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Commande de Stock</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #2c7d59;
            color: white;
            text-align: center;
            padding: 15px;
            border-radius: 10px 10px 0 0;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: gray;
            margin-top: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #2c7d59;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>📦 Commande Automatique</h1>
    </div>
    <div class="content">
        <p>Bonjour,</p>
        <p>
            Vous recevez cette email automatisé grâce à la plateforme <a class="underline text-blue-500" href="https://doctopet.fr">Doctopet</a>.
            @if($trigger->user->gender == "M")
            Monsieur
            @else
            Madame
            @endif
            {{$trigger->user->name}} souhaite commander <strong>{{ $trigger->ask_montant }} unités</strong> de <strong>{{ $trigger->actif->nom }}</strong>.</p>
        <p>📍 Adresse du cabinet : <strong>{{ $trigger->user->address }}</strong></p>
        <p>📧 Vous pouvez répondre directement à la personne via son adresse mail : <a href="mailto:{{ $trigger->user->email }}">{{ $trigger->user->email }}</a></p>
    </div>
    <div class="footer">
        <p>⚠️ Ne répondez pas à cet email automatisé.</p>
    </div>
</div>
</body>
</html>

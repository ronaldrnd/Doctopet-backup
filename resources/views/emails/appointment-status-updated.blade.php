<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statut de votre rendez-vous</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 2px solid #e4e4e4;
        }
        .header img {
            max-width: 120px;
            margin-bottom: 10px;
        }
        .header h1 {
            font-size: 24px;
            color: #2c7d59;
            margin: 0;
        }
        .content {
            margin: 20px 0;
        }
        .content p {
            margin: 10px 0;
        }
        .content .info {
            background: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .status {
            font-size: 18px;
            font-weight: bold;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
        }
        .confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        .canceled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 20px;
        }
        .footer a {
            color: #2c7d59;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('img/logo/doctopet_logo_green.png') }}" alt="Logo DoctoPet">
        <h1>📅 Mise à jour de votre rendez-vous</h1>
    </div>

    <!-- Contenu du mail -->
    <div class="content">
        <p>Bonjour <strong>{{ $appointment->user->name }}</strong>,</p>
        <p>Nous souhaitons vous informer que votre rendez-vous pour le service <strong>{{ $appointment->service->name }}</strong> a été <strong>{{ $appointment->status === 'confirmed' ? 'Accepté' : 'Refusé' }}</strong>.</p>

        <!-- Statut visuel -->
        <div class="status {{ $appointment->status === 'confirmed' ? 'confirmed' : 'canceled' }}">
            {{ $appointment->status === 'confirmed' ? '✅ Accepté' : '❌ Refusé' }}
        </div>

        <!-- Informations du RDV -->
        <div class="info">
            <p><strong>🗓️ Date :</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
            <p><strong>⏰ Heure :</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</p>
            <p><strong>🐾 Animal :</strong> {{ $appointment->animal->nom }}</p>
            <p><strong>👤 Vétérinaire :</strong> {{ $appointment->service->user->name }}</p>
        </div>

        <!-- Message personnalisé -->
        @if($appointment->status === 'confirmed')
            <p>✅ Votre rendez-vous est confirmé. Merci de vous présenter à l'heure prévue.</p>
        @else
            <p>❌ Malheureusement, votre rendez-vous a été refusé. Vous pouvez essayer de choisir un autre créneau.</p>
        @endif

        <p>Merci d'utiliser <strong>Doctopet</strong> pour la santé de votre compagnon.</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>📍 Connectez-vous à votre compte pour gérer vos rendez-vous :</p>
        <p><a href="{{ url('/') }}">Accéder à mon compte</a></p>
        <p>&copy; {{ date('Y') }} Doctopet. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📅 Nouvelle Demande de Rendez-vous</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 3px solid #2c7d59;
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
            font-size: 16px;
        }
        .info {
            background: #f9f9f9;
            padding: 15px;
            border-left: 5px solid #2c7d59;
            border-radius: 8px;
            margin: 20px 0;
        }
        .info p {
            font-size: 14px;
            margin: 6px 0;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }
        .btn-accept {
            background-color: #28a745;
            color: white;
        }
        .btn-accept:hover {
            background-color: #218838;
        }
        .btn-decline {
            background-color: #dc3545;
            color: white;
        }
        .btn-decline:hover {
            background-color: #c82333;
        }
        .footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
        .footer a {
            color: #2c7d59;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header -->
    <div class="header">
        <img src="{{ asset('img/logo/doctopet_logo_green.png') }}" alt="Logo DoctoPet">
        <h1>📅 Nouvelle Demande de Rendez-vous</h1>
    </div>

    <!-- Contenu -->
    <div class="content">
        <p>👋 Bonjour <strong>{{ $appointment->service->user->name }}</strong>,</p>
        <p>Vous avez reçu une <strong>nouvelle demande de rendez-vous</strong> sur Doctopet. Voici les détails :</p>

        <!-- Informations du RDV -->
        <div class="info">
            <p>👤 <strong>Patient :</strong> {{ $appointment->user->name }}</p>
            <p>📧 <strong>Email :</strong> {{ $appointment->user->email }}</p>
            <p>🐾 <strong>Animal :</strong> {{ $appointment->animal->nom }}</p>
            <p>🦴 <strong>Espèce :</strong> {{ $appointment->animal->espece->nom }}</p>
            <p>📏 <strong>Race :</strong> {{ $appointment->animal->race->nom }}</p>
            <p>⚖️ <strong>Poids :</strong> {{ $appointment->animal->poids }} kg</p>
            <p>📐 <strong>Taille :</strong> {{ $appointment->animal->taille }} cm</p>
            <p>📅 <strong>Date :</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
            <p>⏰ <strong>Heure :</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</p>
            <p>🩺 <strong>Service :</strong> {{ $appointment->specializedService ? $appointment->specializedService->name : $appointment->service->name }}</p>

            <p>✉️ <strong>Message du patient :</strong> {{ $appointment->message ?? 'Aucun message' }}</p>
        </div>


        @if($appointment->assignedSpecialist->acceptsAutoRDV())
            <p>🔔 Cette demande a était accepté par défaut avec le paramètre que vous avez enregistré sur le compte</p>
        @else
        <!-- Boutons d'actions -->
        <p>🔔 Pour répondre à cette demande, cliquez sur l'une des options ci-dessous :</p>
        <div style="text-align: center;">
            <a href="{{ url("/appointment/{$appointment->id}/accept?token={$appointment->confirmation_token}") }}">✅ Accepter le rendez-vous</a>
            <a href="{{ url("/appointment/{$appointment->id}/decline?token={$appointment->confirmation_token}") }}">❌ Refuser le rendez-vous</a>

        </div>

        @endif



        <p>Merci d'utiliser <strong>Doctopet</strong> pour la gestion de vos rendez-vous. 🐶🐱</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>📍 Connectez-vous à votre compte pour voir tous vos rendez-vous :</p>
        <p><a href="{{ url('/') }}">Accéder à mon compte</a></p>
        <p>&copy; {{ date('Y') }} Doctopet. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>

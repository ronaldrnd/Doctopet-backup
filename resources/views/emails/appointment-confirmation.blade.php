<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📅 Confirmation de Rendez-vous</title>
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
        <h1>📅 Votre Rendez-vous est bien envoyé !</h1>
    </div>

    <!-- Contenu -->
    <div class="content">
        <p>👋 Bonjour <strong>{{ $appointment->user->name }}</strong>,</p>
        <p>Merci d'avoir pris rendez-vous via Doctopet. Voici les détails de votre consultation :</p>

        <!-- Informations du RDV -->
        <div class="info">
            <p>🩺 <strong>Spécialiste :</strong> {{ $appointment->service->user->name }}</p>
            <p>🔧 <strong>Service :</strong> {{ $appointment->specializedService ? $appointment->specializedService->name : $appointment->service->name }}</p>
            <p>📅 <strong>Date :</strong> {{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</p>
            <p>⏰ <strong>Heure :</strong> {{ \Carbon\Carbon::parse($appointment->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($appointment->end_time)->format('H:i') }}</p>
            <p>💶 <strong>Prix :</strong> {{ $appointment->specializedService ? $appointment->specializedService->price : $appointment->service->price }} €</p>
        </div>

        <!-- Informations sur l'animal -->
        <h3 style="color: #2c7d59;">🐾 Détails de l'animal :</h3>
        <div class="info">
            <p>🐶 <strong>Nom :</strong> {{ $appointment->animal->nom }}</p>
            <p>🦴 <strong>Espèce :</strong> {{ $appointment->animal->espece->nom }}</p>
            <p>📏 <strong>Race :</strong> {{ $appointment->animal->race->nom }}</p>
            <p>⚖️ <strong>Poids :</strong> {{ $appointment->animal->poids }} kg</p>
            <p>📐 <strong>Taille :</strong> {{ $appointment->animal->taille }} cm</p>
        </div>

        <p>
            ✅ <strong>Votre professionel a reçu un mail pour confirmez votre rendez-vous</strong>, vous serez informez par <strong>mail retour de la confirmation de votre rendez-vous</strong>
        </p>

        <!-- Instructions importantes -->
        <p>⚠️ <strong>Important :</strong> En cas de désistement, merci de prévenir le spécialiste au moins <strong>72h à l'avance</strong> par téléphone pour éviter toute pénalité.</p>

        <p>Merci d'utiliser <strong>Doctopet</strong> pour la santé de vos compagnons. 🐶🐱</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>📍 Connectez-vous à votre compte pour suivre vos rendez-vous :</p>
        <p><a href="{{ url('/') }}">Accéder à mon compte</a></p>
        <p>&copy; {{ date('Y') }} Doctopet. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📩 Demande d'Adoption - Doctopet</title>
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
        <h1>📩 Nouvelle demande d’adoption</h1>
    </div>

    <!-- Contenu -->
    <div class="content">
        <p>👋 Bonjour <strong>{{ $breeder->name }}</strong>,</p>
        <p>Un utilisateur de <strong>Doctopet</strong> souhaite adopter un animal de votre élevage. Voici son message :</p>

        <!-- Message de l'utilisateur -->
        <div class="info">
            <p>✉️ <strong>De :</strong> {{ $user->name }}</p>
            <p>📧 <strong>Email :</strong> {{ $user->email }}</p>
            <p>📞 <strong>Téléphone :</strong> {{ $user->phone_number }}</p>
            <p>📝 <strong>Message :</strong></p>
            <p>"{{ $messageContent }}"</p>
        </div>

        <p>Merci d'utiliser <strong>Doctopet</strong> pour aider les animaux à trouver leur famille ! 🐶🐱</p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>📍 Connectez-vous à votre compte pour voir vos messages :</p>
        <p><a href="{{ url('/') }}">Accéder à Doctopet</a></p>
        <p>&copy; {{ date('Y') }} Doctopet. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>

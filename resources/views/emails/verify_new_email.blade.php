<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📧 Vérification de votre nouvelle adresse email</title>
    <style>
        body { font-family: 'Arial', sans-serif; background-color: #f4f4f4; color: #333; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .header { text-align: center; border-bottom: 3px solid #2c7d59; padding-bottom: 20px; }
        .header img { max-width: 120px; margin-bottom: 10px; }
        .header h1 { font-size: 24px; color: #2c7d59; margin: 0; }
        .content { margin: 20px 0; }
        .content p { font-size: 16px; }
        .btn { display: inline-block; background-color: #2c7d59; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .footer { text-align: center; font-size: 14px; color: #777; margin-top: 20px; }
        .footer a { color: #2c7d59; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <img src="{{ asset('img/logo/doctopet_logo_green.png') }}" alt="Logo DoctoPet">
        <h1>📧 Vérification de votre nouvelle adresse email</h1>
    </div>

    <div class="content">
        <p>👋 Bonjour <strong>{{ $user->name }}</strong>,</p>
        <p>Vous avez demandé à changer votre adresse email pour : <strong>{{ $user->temporary_email }}</strong>.</p>
        <p>Veuillez cliquer sur le bouton ci-dessous pour confirmer ce changement :</p>

        <p style="text-align: center;">
            <a href="{{ $verificationUrl }}" class="btn">✅ Vérifier mon adresse email</a>
        </p>

        <p>Si vous n'avez pas initié cette demande, veuillez ignorer ce message.</p>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} DoctoPet. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>

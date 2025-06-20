<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérifiez votre Email | DoctoPet</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f9; margin: 0; padding: 0;">
<div style="max-width: 600px; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
    <div style="text-align: center;">
        <img src="{{ asset('img/logo/doctopet_logo_green.png') }}" alt="DoctoPet Logo" style="width: 150px; margin-bottom: 20px;">
    </div>
    <h1 style="text-align: center; color: #2f855a;">Confirmez votre Email</h1>
    <p style="text-align: center; color: #4a5568;">Merci de vous être inscrit à <strong>DoctoPet</strong> ! Veuillez cliquer sur le bouton ci-dessous pour activer votre compte.</p>
    <div style="text-align: center; margin-top: 20px;">
        <a href="{{ $verificationUrl }}" style="background-color: #38a169; color: #fff; text-decoration: none; padding: 10px 20px; border-radius: 5px; font-size: 16px;">
            Activer mon compte
        </a>
    </div>
    <p style="text-align: center; color: #4a5568; margin-top: 20px;">Si vous n'avez pas fait cette demande, vous pouvez ignorer cet email.</p>
</div>
</body>
</html>

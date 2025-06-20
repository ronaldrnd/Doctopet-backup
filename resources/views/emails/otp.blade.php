<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code OTP</title>
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
            max-width: 360px;
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
        .otp-code {
            display: block;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #2c7d59;
            background: #f4f4f4;
            padding: 10px;
            border-radius: 4px;
            margin: 20px 0;
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
    <div class="header">
        <img src="{{ asset('img/logo/doctopet_logo_green.png') }}" alt="Logo DoctoPet">
        <h1>Votre code OTP</h1>
    </div>
    <div class="content">
        <p>Bonjour,</p>
        <p>Nous avons reçu une demande pour vérifier votre adresse e-mail. Veuillez utiliser le code OTP ci-dessous pour continuer :</p>
        <span class="otp-code">{{ $otp }}</span>
        <p>Ce code est valide pour les 10 prochaines minutes. Si vous n'avez pas fait cette demande, veuillez ignorer cet e-mail.</p>
    </div>
    <div class="footer">
        <p>Merci d'utiliser <a href="{{ url('/') }}">Doctopet</a>.</p>
        <p>&copy; {{ date('Y') }} Doctopet. Tous droits réservés.</p>
    </div>
</div>
</body>
</html>

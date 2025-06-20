<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
<h2>👋 Bonjour {{ $clientName }},</h2>

<p>Le professionnel chez qui vous venez de prendre rendez-vous utilise Doctopet pour gérer ses consultations.</p>

<p>En activant votre compte, vous pourrez profiter de nombreux avantages :</p>
<ul>
    <li>
        Suivi de vos animaux en ligne
    </li>
    <li>
        Accès à vos ordonnances et documents
    </li>
    <li>
        Historique de vos rendez-vous
    </li>
    <li>
        Notifications et rappels automatiques
    </li>
</ul>


<p>C’est simple, rapide et gratuit :</p>

<p style="margin-top: 20px;">
    <a href="{{ url('/activation/' . $token) }}"
       style="padding: 12px 24px; background-color: #22c55e; color: white; border-radius: 5px; text-decoration: none;">
        🔐 Activer mon compte
    </a>
</p>

<p style="margin-top: 20px;">À bientôt sur Doctopet 🐶🐱</p>
<p style="margin-top: 20px;">L’équipe Doctopet 🐶🐱</p>

</body>
</html>

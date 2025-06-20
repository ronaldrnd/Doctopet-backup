<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour de l'historique médical</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px 0;
        }
        .header img {
            width: 120px;
            margin-bottom: 10px;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .content h2 {
            color: #4CAF50;
            margin-bottom: 15px;
        }
        .content p {
            margin: 10px 0;
        }
        .modification {
            background-color: #f9f9f9;
            padding: 15px;
            border-left: 5px solid #4CAF50;
            font-style: italic;
            color: #555;
            margin: 20px 0;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f0f0f0;
            font-size: 14px;
            color: #777;
        }
        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- En-tête avec le logo -->
    <div class="header">
        <img src="{{ asset('img/logo/doctopet_logo_green.png') }}" alt="DoctoPet Logo">
    </div>

    <!-- Contenu principal -->
    <div class="content">
        <h2>🩺 Mise à jour de l'historique médical de {{ $animal->nom }}</h2>

        <p>Bonjour <strong>{{ $animal->proprietaire->name }}</strong>,</p>

        <p>Nous vous informons qu'une mise à jour a été effectuée dans l'historique médical de votre animal suite à votre rendez-vous :</p>

        <div class="modification">
            {{ $modification }}
        </div>

        <p>Pour plus de détails, vous pouvez consulter votre espace personnel sur DoctoPet.</p>

        <p>Merci pour votre confiance,<br>
            L'équipe <strong>Doctopet</strong> 🐶🐱</p>
    </div>

    <!-- Pied de page -->
    <div class="footer">
        Vous avez des questions ? <a href="mailto:support@doctopet.com">Contactez-nous</a><br>
        © {{ date('Y') }} Doctopet. Tous droits réservés.
    </div>
</div>

</body>
</html>

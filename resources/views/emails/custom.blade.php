<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .email-container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #4f46e5;
            margin: 0;
            font-size: 24px;
        }

        .content {
            margin-bottom: 30px;
        }

        .footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        .message-content {
            background-color: #f8fafc;
            padding: 20px;
            border-left: 4px solid #4f46e5;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <div class="header">
            <h1>{{ $emailSubject }}</h1>
        </div>

        <div class="content">
            <p><strong>Destinataire :</strong> {{ $recipientEmail }}</p>

            <div class="message-content">
                {!! $emailMessage !!}
            </div>
        </div>

        <div class="footer">
            <p>Cet email a été envoyé via l'<strong style="color: #4f46e5;">API Mail UZASHOP</strong> -
                <a href="https://github.com/FimboIsso/email_api_laravel"
                    style="color: #4f46e5; text-decoration: none;">Solution Open Source</a>
                développée avec ❤️ par <strong style="color: #4f46e5;">UZASHOP Sarlu</strong>
            </p>
            <p style="font-size: 10px; color: #9ca3af; margin-top: 8px;">
                Gratuit • Open Source • Licence MIT •
                <a href="https://github.com/FimboIsso/email_api_laravel" style="color: #9ca3af;">Voir sur GitHub</a>
            </p>
        </div>
    </div>
</body>

</html>

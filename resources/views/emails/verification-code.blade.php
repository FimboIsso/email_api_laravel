<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code de Vérification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 300;
        }

        .header .subtitle {
            margin: 5px 0 0 0;
            font-size: 16px;
            opacity: 0.9;
        }

        .content {
            padding: 40px 30px;
            text-align: center;
        }

        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }

        .message {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .verification-code {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 32px;
            font-weight: bold;
            padding: 20px 40px;
            border-radius: 8px;
            letter-spacing: 5px;
            margin: 30px 0;
            display: inline-block;
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

        .expiry-notice {
            font-size: 14px;
            color: #e74c3c;
            margin: 20px 0;
            font-weight: 500;
        }

        .security-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 30px 0;
            font-size: 14px;
            color: #856404;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }

        .footer p {
            margin: 5px 0;
            font-size: 14px;
            color: #6c757d;
        }

        .footer .company {
            font-weight: bold;
            color: #495057;
        }

        .footer a {
            color: #667eea;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 5px;
            }

            .header,
            .content,
            .footer {
                padding: 20px 15px;
            }

            .verification-code {
                font-size: 24px;
                padding: 15px 25px;
                letter-spacing: 3px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>UZASHOP</h1>
            <p class="subtitle">Email API Platform</p>
        </div>

        <div class="content">
            <div class="greeting">
                Bonjour {{ $userName ? $userName : 'Utilisateur' }} ! 👋
            </div>

            <div class="message">
                Nous avons reçu une demande d'accès à votre compte UZASHOP Email API.
                Pour des raisons de sécurité, veuillez utiliser le code de vérification ci-dessous :
            </div>

            <div class="verification-code">
                {{ $verificationCode }}
            </div>

            <div class="expiry-notice">
                ⏰ Ce code expire dans 15 minutes
            </div>

            <div class="security-notice">
                <strong>🔒 Note de sécurité :</strong><br>
                Si vous n'avez pas demandé ce code, ignorez cet email.
                Ne partagez jamais votre code de vérification avec qui que ce soit.
            </div>
        </div>

        <div class="footer">
            <p class="company">UZASHOP Sarlu</p>
            <p>Plateforme d'API d'envoi d'emails professionnelle</p>
            <p>
                <a href="https://uzashop.co" target="_blank">uzashop.co</a> |
                <a href="mailto:support@uzashop.co">Support technique</a>
            </p>
            <p style="margin-top: 15px; font-size: 12px;">
                © {{ date('Y') }} UZASHOP Sarlu. Tous droits réservés.
            </p>
        </div>
    </div>
</body>

</html>

# 📡 Documentation API - UZASHOP Mail API

Documentation technique complète pour l'intégration de l'API Mail UZASHOP.

## 🔗 Base URL

```
Production: https://yourdomain.com
Développement: http://localhost:8000
```

## 🔐 Authentification

### Obtenir un Token API

1. **Créer un compte** sur `/register`
2. **Se connecter** sur `/login`
3. **Générer un token** depuis le tableau de bord `/dashboard`
4. **Utiliser le token** dans toutes vos requêtes API

### Headers d'Authentification

Toutes les requêtes API doivent inclure l'un de ces headers :

```http
# Méthode recommandée
Authorization: Bearer YOUR_API_TOKEN

# Méthode alternative
X-API-Token: YOUR_API_TOKEN
```

---

## 📤 Endpoints

### 1. Envoyer un Email

Envoie un email via l'API avec support des CC, BCC et pièces jointes.

```http
POST /api/send-email
```

#### Headers Requis

```http
Content-Type: application/json
Authorization: Bearer YOUR_API_TOKEN
```

#### Paramètres

| Paramètre | Type | Requis | Description |
|-----------|------|--------|-------------|
| `to` | string | ✅ | Email du destinataire principal |
| `subject` | string | ✅ | Sujet de l'email (supporte les variables Blade) |
| `message` | string | ✅ | Contenu de l'email (HTML ou texte) - utilisé comme fallback si template_content échoue |
| `cc` | array | ❌ | Liste des emails en copie |
| `bcc` | array | ❌ | Liste des emails en copie cachée |
| `attachments` | array | ❌ | Fichiers joints (max 10MB par fichier) |
| `application_name` | string | ❌ | Nom de l'application pour le logging |
| `template_content` | string | ❌ | **Template Blade personnalisé** - Contenu HTML avec syntaxe Blade |
| `template_data` | object | ❌ | **Variables du template** - Données à injecter dans le template Blade |

#### Exemple de Requête

```json
{
  "to": "client@example.com",
  "subject": "Confirmation de commande #12345",
  "message": "<h1>Merci pour votre commande!</h1><p>Votre commande #12345 a bien été reçue.</p><p>Cordialement,<br>L'équipe UZASHOP</p>",
  "cc": ["manager@example.com", "support@example.com"],
  "bcc": ["archive@example.com"],
}
```

---

## 🎨 Templates Personnalisables

### Vue d'ensemble

L'API supporte l'envoi de **templates Blade personnalisés** directement depuis votre application cliente. Vous pouvez envoyer du contenu HTML avec la syntaxe Blade Laravel et y injecter des variables dynamiques.

### Fonctionnalités des Templates

- ✅ **Syntaxe Blade complète** : Variables, conditions, boucles
- ✅ **Variables dynamiques** : Injection de données depuis template_data
- ✅ **HTML/CSS complet** : Support des styles inline et CSS
- ✅ **Fallback automatique** : Utilise le message par défaut si le template échoue
- ✅ **Validation sécurisée** : Protection contre les injections malveillantes
- ✅ **Gestion d'erreurs** : Logs détaillés en cas de problème

### Syntaxe Blade Supportée

#### Variables
```blade
{{ $nom_variable }}
{!! $html_variable !!}  <!-- Pour HTML non échappé -->
```

#### Conditions
```blade
@if($condition)
    <p>Condition vraie</p>
@else
    <p>Condition fausse</p>
@endif

@unless($condition)
    <p>Condition fausse</p>
@endunless
```

#### Boucles
```blade
@foreach($items as $item)
    <li>{{ $item['name'] }}</li>
@endforeach

@for($i = 0; $i < count($items); $i++)
    <p>Item {{ $i }}: {{ $items[$i] }}</p>
@endfor
```

#### Fonctions utiles
```blade
{{ date('d/m/Y', strtotime($date)) }}
{{ number_format($price, 2) }}
{{ ucfirst($name) }}
{{ strtoupper($text) }}
```

### Exemple Simple

```json
{
  "to": "client@example.com",
  "subject": "Bienvenue {{ $name }} !",
  "message": "Message de fallback si le template échoue.",
  "template_content": "<h1 style='color: blue;'>Bonjour {{ $name }}</h1><p>Votre email: {{ $email }}</p>",
  "template_data": {
    "name": "Jean Dupont",
    "email": "jean@example.com"
  }
}
```

### Exemple Avancé : Email de Bienvenue

```json
{
  "to": "user@example.com",
  "subject": "Bienvenue {{ $name }} chez {{ $company_name }} !",
  "message": "Bienvenue ! Votre compte a été créé avec succès.",
  "template_content": "<!DOCTYPE html><html><head><meta charset='utf-8'><style>body{font-family:Arial,sans-serif;background:#f5f5f5;margin:0;padding:20px}.container{max-width:600px;margin:0 auto;background:white;padding:40px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}.header{text-align:center;border-bottom:2px solid #007bff;padding-bottom:20px;margin-bottom:30px}.header h1{color:#007bff;margin:0}.welcome{font-size:24px;color:#333;margin:20px 0}.info-card{background:#f8f9fa;border-left:4px solid #007bff;padding:20px;margin:20px 0}.btn{display:inline-block;background:#007bff;color:white;padding:15px 30px;text-decoration:none;border-radius:5px;margin:20px 0}</style></head><body><div class='container'><div class='header'><h1>{{ $company_name }}</h1></div><div class='welcome'>Bonjour {{ $name }} ! 🎉</div><p>Nous sommes ravis de vous accueillir dans notre plateforme.</p><div class='info-card'><h3>Informations de votre compte :</h3><ul><li><strong>Nom :</strong> {{ $name }}</li><li><strong>Email :</strong> {{ $email }}</li><li><strong>Date d'inscription :</strong> {{ $registration_date }}</li><li><strong>Statut :</strong> {{ $status }}</li></ul></div><p>Voici ce que vous pouvez faire maintenant :</p><ul><li>✅ Compléter votre profil</li><li>✅ Explorer nos fonctionnalités</li><li>✅ Contacter notre support</li></ul><div style='text-align:center'><a href='{{ $dashboard_url }}' class='btn'>Accéder à mon tableau de bord</a></div><p>Cordialement,<br><strong>L'équipe {{ $company_name }}</strong></p></div></body></html>",
  "template_data": {
    "name": "Jean Dupont",
    "email": "jean@example.com",
    "company_name": "UZASHOP",
    "registration_date": "28/08/2025 à 14:30",
    "status": "Actif",
    "dashboard_url": "https://uzashop.co/dashboard"
  }
}
```

### Exemple Expert : Facture Professionnelle

```json
{
  "to": "client@example.com",
  "subject": "Facture {{ $invoice_number }} - {{ $company_name }}",
  "message": "Votre facture est disponible.",
  "template_content": "<!DOCTYPE html><html><head><meta charset='utf-8'><style>body{font-family:Arial,sans-serif;margin:0;padding:20px;background:#f5f5f5}.invoice-container{background:white;max-width:800px;margin:0 auto;box-shadow:0 0 20px rgba(0,0,0,0.1)}.invoice-header{background:linear-gradient(135deg,#2c3e50,#34495e);color:white;padding:40px}.company-info{float:left}.invoice-info{float:right;text-align:right}.clearfix::after{content:'';display:table;clear:both}.invoice-body{padding:40px}.client-section{background:#ecf0f1;padding:30px;margin:20px 0;border-radius:8px}.invoice-table{width:100%;border-collapse:collapse;margin:30px 0}.invoice-table th{background:#3498db;color:white;padding:15px;text-align:left}.invoice-table td{padding:15px;border-bottom:1px solid #ecf0f1}.total-section{margin-top:30px}.total-row{display:flex;justify-content:space-between;padding:10px 0}.total-final{background:#2c3e50;color:white;padding:20px;border-radius:8px;font-size:20px;font-weight:bold}</style></head><body><div class='invoice-container'><div class='invoice-header clearfix'><div class='company-info'><h1>{{ $company_name }}</h1><p>{{ $company_address }}</p><p>Tél: {{ $company_phone }}</p><p>Email: {{ $company_email }}</p></div><div class='invoice-info'><h2>FACTURE</h2><div style='font-size:24px;color:#f39c12'>{{ $invoice_number }}</div><p><strong>Date:</strong> {{ $invoice_date }}</p><p><strong>Échéance:</strong> {{ $due_date }}</p></div></div><div class='invoice-body'><div class='client-section'><h3>📍 Facturé à :</h3><p><strong>{{ $client_name }}</strong></p><p>{{ $client_address }}</p><p>Email: {{ $client_email }}</p></div><table class='invoice-table'><thead><tr><th>Description</th><th>Qté</th><th>Prix HT</th><th>Total HT</th></tr></thead><tbody>@foreach($items as $item)<tr><td><strong>{{ $item['description'] }}</strong>@if(!empty($item['details']))<br><small>{{ $item['details'] }}</small>@endif</td><td>{{ $item['quantity'] }}</td><td>{{ number_format($item['unit_price'], 2) }} €</td><td><strong>{{ number_format($item['total'], 2) }} €</strong></td></tr>@endforeach</tbody></table><div class='total-section'><div class='total-row'><span>Sous-total HT:</span><span><strong>{{ number_format($subtotal, 2) }} €</strong></span></div><div class='total-row'><span>TVA ({{ $tax_rate }}%):</span><span><strong>{{ number_format($tax_amount, 2) }} €</strong></span></div><div class='total-row total-final'><span>TOTAL TTC:</span><span>{{ number_format($total, 2) }} €</span></div></div><div style='background:#e8f5e8;border:1px solid #27ae60;padding:20px;margin:30px 0;border-radius:8px'><h3>💳 Informations de paiement</h3><p><strong>Conditions:</strong> {{ $payment_terms }}</p><p><strong>Mode:</strong> {{ $payment_method }}</p></div></div><div style='background:#34495e;color:white;padding:30px;text-align:center'><p>Merci pour votre confiance ! 🙏</p></div></div></body></html>",
  "template_data": {
    "company_name": "UZASHOP Business Solutions",
    "company_address": "123 Avenue des Affaires, 75001 Paris",
    "company_phone": "+33 1 23 45 67 89",
    "company_email": "contact@uzashop.co",
    "invoice_number": "UZA-2025-001",
    "invoice_date": "28/08/2025",
    "due_date": "27/09/2025",
    "client_name": "Jean Dupont",
    "client_address": "456 Rue du Client, 75002 Paris",
    "client_email": "jean@example.com",
    "items": [
      {
        "description": "Développement API Email",
        "details": "Système complet avec templates",
        "quantity": 1,
        "unit_price": 2500.00,
        "total": 2500.00
      },
      {
        "description": "Support technique",
        "details": "Support 3 mois inclus",
        "quantity": 1,
        "unit_price": 500.00,
        "total": 500.00
      }
    ],
    "subtotal": 3000.00,
    "tax_rate": 20,
    "tax_amount": 600.00,
    "total": 3600.00,
    "payment_terms": "Paiement à 30 jours",
    "payment_method": "Virement bancaire"
  }
}
```

### Bonnes Pratiques pour les Templates

#### 1. Sécurité
- ✅ **Échappez les variables** : Utilisez `{{ $variable }}` par défaut
- ✅ **HTML sûr uniquement** : Utilisez `{!! $html !!}` seulement pour du HTML de confiance
- ✅ **Validez les données** : Vérifiez les données avant injection

#### 2. Performance
- ✅ **Templates courts** : Évitez les templates trop volumineux
- ✅ **CSS inline** : Meilleure compatibilité email
- ✅ **Images externes** : Préférez les URLs aux images intégrées

#### 3. Compatibilité Email
- ✅ **Tables pour la mise en page** : Support des clients email anciens
- ✅ **CSS inline** : Évitez les feuilles de style externes
- ✅ **Formats alternatifs** : Toujours prévoir un fallback texte

#### 4. Debugging
- ✅ **Message de fallback** : Toujours définir un message par défaut
- ✅ **Tests réguliers** : Testez vos templates avant production
- ✅ **Logs d'erreurs** : Consultez les logs en cas de problème

### Gestion d'Erreurs des Templates

Si un template contient des erreurs, l'API :

1. **Log l'erreur** dans les fichiers de logs
2. **Utilise le fallback** : Envoie le contenu du champ `message`
3. **Retourne un succès** avec mention de l'erreur dans les logs
4. **Continue l'envoi** : L'email est tout de même envoyé

### Variables Système Disponibles

Certaines variables sont automatiquement disponibles dans tous les templates :

```blade
{{ $api_sent_at }}        <!-- Date/heure d'envoi -->
{{ $api_user_name }}      <!-- Nom de l'utilisateur API -->
{{ $api_application }}    <!-- Nom de l'application -->
{{ $api_server_name }}    <!-- Nom du serveur -->
```

---

#### Réponse de Succès (200)

```json
{
  "status": "success",
  "message": "Email sent successfully",
  "data": {
    "to": "client@example.com",
    "subject": "Confirmation de commande #12345",
    "sent_at": "2025-08-19T14:30:45.000000Z",
    "sent_by": "Nom Utilisateur"
  }
}
```

#### Réponses d'Erreur

**401 - Token manquant ou invalide**
```json
{
  "status": "error",
  "message": "Token API manquant. Veuillez fournir votre token dans l'en-tête Authorization: Bearer {token} ou X-API-Token"
}
```

**422 - Erreur de validation**
```json
{
  "status": "error",
  "message": "Erreur de validation",
  "errors": {
    "to": ["Le champ to est obligatoire."],
    "subject": ["Le champ subject est obligatoire."]
  }
}
```

**500 - Erreur serveur**
```json
{
  "status": "error",
  "message": "Failed to send email: Connection timeout"
}
```

---

### 2. Informations Utilisateur

Récupère les informations de l'utilisateur authentifié et sa configuration email.

```http
GET /api/user-info
```

#### Headers Requis

```http
Authorization: Bearer YOUR_API_TOKEN
```

#### Réponse de Succès (200)

```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "created_at": "2025-08-19T10:00:00.000000Z",
    "mail_config": {
      "mailer": "smtp",
      "host": "smtp.gmail.com",
      "port": 587,
      "encryption": "tls",
      "from_address": "noreply@example.com",
      "from_name": "Mon Application"
    }
  }
}
```

---

## 📎 Gestion des Pièces Jointes

### Upload de Fichiers

Pour envoyer des pièces jointes, utilisez `multipart/form-data` :

```bash
curl -X POST http://localhost:8000/api/send-email \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -F "to=client@example.com" \
  -F "subject=Facture avec pièce jointe" \
  -F "message=<p>Veuillez trouver ci-joint votre facture.</p>" \
  -F "attachments[]=@/path/to/invoice.pdf" \
  -F "attachments[]=@/path/to/terms.pdf"
```

### Limitations

- **Taille maximum** : 10MB par fichier
- **Formats supportés** : Tous formats
- **Nombre de fichiers** : Illimité (dans la limite de la taille totale)

---

## 🔧 Configuration SMTP Personnalisée

Chaque utilisateur peut configurer ses propres paramètres SMTP via le tableau de bord web ou l'API.

### Paramètres Supportés

- **Mailer** : `smtp`, `log`
- **Host** : Serveur SMTP (ex: `smtp.gmail.com`)
- **Port** : Port du serveur (ex: `587`, `465`, `25`)
- **Encryption** : `tls`, `ssl`, ou vide
- **Username** : Nom d'utilisateur SMTP
- **Password** : Mot de passe SMTP
- **From Address** : Adresse d'expédition
- **From Name** : Nom de l'expéditeur

### Exemples de Configuration

#### Gmail
```
Host: smtp.gmail.com
Port: 587
Encryption: tls
Username: votre.email@gmail.com
Password: mot_de_passe_application
```

#### Outlook/Hotmail
```
Host: smtp-mail.outlook.com
Port: 587
Encryption: tls
Username: votre.email@outlook.com
Password: votre_mot_de_passe
```

#### SendGrid
```
Host: smtp.sendgrid.net
Port: 587
Encryption: tls
Username: apikey
Password: votre_api_key_sendgrid
```

---

## 📊 Codes de Réponse HTTP

| Code | Status | Description |
|------|--------|-------------|
| `200` | Success | Requête traitée avec succès |
| `401` | Unauthorized | Token manquant ou invalide |
| `422` | Unprocessable Entity | Erreur de validation des données |
| `429` | Too Many Requests | Limite de taux dépassée |
| `500` | Internal Server Error | Erreur serveur interne |

---

## 🚦 Limites et Quotas

### Limites par Défaut

- **Requêtes par heure** : 1000 par token
- **Taille des messages** : 2MB maximum
- **Template content** : 1MB maximum par template
- **Pièces jointes** : 10MB par fichier, 50MB total
- **Destinataires** : 100 maximum (to + cc + bcc)
- **Variables template** : 500 variables maximum par template

### Rate Limiting

L'API implémente un système de limitation de taux pour éviter les abus :

```http
X-RateLimit-Limit: 1000
X-RateLimit-Remaining: 995
X-RateLimit-Reset: 1692456000
```

---

## 🧪 Exemples d'Intégration

### PHP (cURL)

```php
<?php
function sendEmail($token, $to, $subject, $message, $templateContent = null, $templateData = []) {
    $url = 'http://localhost:8000/api/send-email';
    $payload = [
        'to' => $to,
        'subject' => $subject,
        'message' => $message
    ];
    
    // Ajouter le template si fourni
    if ($templateContent) {
        $payload['template_content'] = $templateContent;
        $payload['template_data'] = $templateData;
    }
    
    $data = json_encode($payload);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);
    
    return json_decode($response, true);
}

// Utilisation simple
$result = sendEmail('your_token', 'test@example.com', 'Test', 'Hello World!');

// Utilisation avec template
$templateContent = '<h1>Bonjour {{ $name }}</h1><p>Votre commande {{ $order_id }} est prête!</p>';
$templateData = ['name' => 'Jean', 'order_id' => '#12345'];
$result = sendEmail('your_token', 'test@example.com', 'Commande {{ $order_id }}', 'Fallback message', $templateContent, $templateData);

echo json_encode($result);
?>
```

### JavaScript (Fetch)

```javascript
async function sendEmail(token, to, subject, message, templateContent = null, templateData = {}) {
    const payload = {
        to: to,
        subject: subject,
        message: message
    };
    
    // Ajouter le template si fourni
    if (templateContent) {
        payload.template_content = templateContent;
        payload.template_data = templateData;
    }
    
    const response = await fetch('http://localhost:8000/api/send-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify(payload)
    });
    
    return await response.json();
}

// Utilisation simple
sendEmail('your_token', 'test@example.com', 'Test', 'Hello World!')
    .then(result => console.log(result));

// Utilisation avec template
const template = '<h1>Bonjour {{ $name }}</h1><p>Bienvenue chez {{ $company }}!</p>';
const data = { name: 'Jean', company: 'UZASHOP' };
sendEmail('your_token', 'test@example.com', 'Bienvenue {{ $name }}!', 'Bienvenue!', template, data)
    .then(result => console.log(result))
    .catch(error => console.error(error));
```

### Python (requests)

```python
import requests
import json

def send_email(token, to, subject, message, template_content=None, template_data=None):
    url = 'http://localhost:8000/api/send-email'
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Bearer {token}'
    }
    payload = {
        'to': to,
        'subject': subject,
        'message': message
    }
    
    # Ajouter le template si fourni
    if template_content:
        payload['template_content'] = template_content
        payload['template_data'] = template_data or {}
    
    response = requests.post(url, headers=headers, json=payload)
    return response.json()

# Utilisation simple
result = send_email('your_token', 'test@example.com', 'Test', 'Hello World!')
print(json.dumps(result, indent=2))

# Utilisation avec template
template_html = '''
<div style="font-family: Arial, sans-serif; padding: 20px;">
    <h1 style="color: #007bff;">Bonjour {{ $name }} !</h1>
    <p>Votre facture {{ $invoice_number }} d'un montant de {{ $amount }}€ est disponible.</p>
    <ul>
        @foreach($items as $item)
        <li>{{ $item['name'] }} - {{ $item['price'] }}€</li>
        @endforeach
    </ul>
    <p>Cordialement,<br>L'équipe {{ $company }}</p>
</div>
'''

template_vars = {
    'name': 'Jean Dupont',
    'invoice_number': 'INV-2025-001',
    'amount': 150.00,
    'company': 'UZASHOP',
    'items': [
        {'name': 'Produit A', 'price': 75.00},
        {'name': 'Produit B', 'price': 75.00}
    ]
}

result = send_email('your_token', 'test@example.com', 'Facture {{ $invoice_number }}', 
                   'Votre facture est prête', template_html, template_vars)
print(json.dumps(result, indent=2))
```

### Node.js (axios)

```javascript
const axios = require('axios');

async function sendEmail(token, to, subject, message, templateContent = null, templateData = {}) {
    try {
        const payload = {
            to: to,
            subject: subject,
            message: message
        };
        
        // Ajouter le template si fourni
        if (templateContent) {
            payload.template_content = templateContent;
            payload.template_data = templateData;
        }
        
        const response = await axios.post('http://localhost:8000/api/send-email', payload, {
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        });
        
        return response.data;
    } catch (error) {
        return error.response.data;
    }
}

// Utilisation simple
sendEmail('your_token', 'test@example.com', 'Test', 'Hello World!')
    .then(result => console.log(result));

// Utilisation avec template de newsletter
const newsletterTemplate = `
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .newsletter { max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; }
        .header { background: #007bff; color: white; padding: 30px; text-align: center; }
        .content { padding: 30px; }
        .article { margin: 20px 0; padding: 20px; border-left: 4px solid #007bff; }
    </style>
</head>
<body>
    <div class="newsletter">
        <div class="header">
            <h1>{{ $newsletter_title }}</h1>
            <p>{{ $newsletter_date }}</p>
        </div>
        <div class="content">
            <p>Bonjour {{ $subscriber_name }},</p>
            @foreach($articles as $article)
            <div class="article">
                <h2>{{ $article['title'] }}</h2>
                <p>{{ $article['excerpt'] }}</p>
                <a href="{{ $article['url'] }}">Lire la suite →</a>
            </div>
            @endforeach
            <p>Merci de votre fidélité !<br>L'équipe {{ $company_name }}</p>
        </div>
    </div>
</body>
</html>
`;

const newsletterData = {
    newsletter_title: 'Newsletter Technique #42',
    newsletter_date: 'Août 2025',
    subscriber_name: 'Jean Dupont',
    company_name: 'UZASHOP',
    articles: [
        {
            title: 'Nouveautés de l\'API Email',
            excerpt: 'Découvrez les templates personnalisables et les nouvelles fonctionnalités.',
            url: 'https://uzashop.co/blog/api-email-templates'
        },
        {
            title: 'Guide de Performance',
            excerpt: 'Optimisez vos envois d\'emails avec nos conseils d\'experts.',
            url: 'https://uzashop.co/blog/email-performance'
        }
    ]
};

sendEmail('your_token', 'subscriber@example.com', '{{ $newsletter_title }} - {{ $newsletter_date }}', 
         'Notre newsletter est disponible', newsletterTemplate, newsletterData)
    .then(result => console.log('Newsletter envoyée:', result));
```

---

## 🔍 Debugging et Logs

### Logs des Requêtes

Les requêtes API sont loggées dans `storage/logs/laravel.log` avec les détails suivants :
- Token utilisé (partiellement masqué)
- Adresse IP de la requête
- Paramètres de la requête
- Réponse envoyée
- Temps de traitement

### Headers de Debug

En mode développement, l'API retourne des headers additionnels :

```http
X-Debug-User-Id: 1
X-Debug-Mail-Driver: smtp
X-Debug-Processing-Time: 150ms
```

---

## ⚡ Performance et Optimisation

### Bonnes Pratiques

1. **Réutilisez les tokens** : Un token par application, pas par requête
2. **Gérez les erreurs** : Implémentez une logique de retry avec backoff
3. **Optimisez les messages** : Minimisez la taille des emails HTML
4. **Surveillez les limites** : Respectez les quotas de taux

### Cache et Performance

- Les configurations SMTP sont mises en cache pour améliorer les performances
- Les templates d'emails sont compilés et mis en cache
- Utilisez Redis en production pour un cache optimal

---

## 🛡️ Sécurité

### Protection des Tokens

- **Stockage sécurisé** : Ne jamais exposer les tokens dans le code frontend
- **Rotation** : Régénérez périodiquement vos tokens
- **Scope limité** : Un token par application/service

### Validation des Données

- Toutes les entrées sont validées et sanitisées
- Protection contre les injections XSS dans les emails HTML
- Limitation de la taille des uploads

### Chiffrement

- Communication HTTPS obligatoire en production
- Mots de passe SMTP chiffrés en base de données
- Sessions sécurisées avec tokens CSRF

---

## 📞 Support Technique

### Ressources

- **Documentation web** : Interface interactive sur `/`
- **Code d'exemple** : Section testeur intégrée
- **GitHub Issues** : [Issues du projet](https://github.com/FimboIsso/email_api_laravel/issues)

### Contact

- **Email** : contact@uzashop.co
- **Site web** : [uzashop.co](https://uzashop.co)
- **Support** : Disponible 24/7
- **Guide Templates** : [TEMPLATE_GUIDE.md](./TEMPLATE_GUIDE.md) - Guide complet des templates Blade

---

**UZASHOP Mail API** - Documentation API v1.0

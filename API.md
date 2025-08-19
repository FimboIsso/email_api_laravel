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
| `subject` | string | ✅ | Sujet de l'email |
| `message` | string | ✅ | Contenu de l'email (HTML ou texte) |
| `cc` | array | ❌ | Liste des emails en copie |
| `bcc` | array | ❌ | Liste des emails en copie cachée |
| `attachments` | array | ❌ | Fichiers joints (max 10MB par fichier) |

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
- **Pièces jointes** : 10MB par fichier, 50MB total
- **Destinataires** : 100 maximum (to + cc + bcc)

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
function sendEmail($token, $to, $subject, $message) {
    $url = 'http://localhost:8000/api/send-email';
    $data = json_encode([
        'to' => $to,
        'subject' => $subject,
        'message' => $message
    ]);
    
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

// Utilisation
$result = sendEmail('your_token', 'test@example.com', 'Test', 'Hello World!');
echo json_encode($result);
?>
```

### JavaScript (Fetch)

```javascript
async function sendEmail(token, to, subject, message) {
    const response = await fetch('http://localhost:8000/api/send-email', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
        },
        body: JSON.stringify({
            to: to,
            subject: subject,
            message: message
        })
    });
    
    return await response.json();
}

// Utilisation
sendEmail('your_token', 'test@example.com', 'Test', 'Hello World!')
    .then(result => console.log(result))
    .catch(error => console.error(error));
```

### Python (requests)

```python
import requests
import json

def send_email(token, to, subject, message):
    url = 'http://localhost:8000/api/send-email'
    headers = {
        'Content-Type': 'application/json',
        'Authorization': f'Bearer {token}'
    }
    data = {
        'to': to,
        'subject': subject,
        'message': message
    }
    
    response = requests.post(url, headers=headers, json=data)
    return response.json()

# Utilisation
result = send_email('your_token', 'test@example.com', 'Test', 'Hello World!')
print(json.dumps(result, indent=2))
```

### Node.js (axios)

```javascript
const axios = require('axios');

async function sendEmail(token, to, subject, message) {
    try {
        const response = await axios.post('http://localhost:8000/api/send-email', {
            to: to,
            subject: subject,
            message: message
        }, {
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

// Utilisation
sendEmail('your_token', 'test@example.com', 'Test', 'Hello World!')
    .then(result => console.log(result));
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

---

**UZASHOP Mail API** - Documentation API v1.0

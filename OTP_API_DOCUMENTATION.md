# API OTP - Documentation

Cette API permet de gérer les codes de vérification à usage unique (OTP) pour l'authentification des emails dans les applications web et mobiles.

## Configuration requise

- Authentification par API Token (header `Authorization: Bearer your_api_token`)
- Headers requis :
  - `Content-Type: application/json`
  - `Accept: application/json`

## Endpoints disponibles

### 1. Générer un OTP

**POST** `/api/otp/generate`

Génère et envoie un code OTP à l'adresse email spécifiée.

#### Paramètres de la requête

```json
{
    "email": "user@example.com",
    "type": "email_verification",
    "identifier": "app_registration_flow",
    "validity_minutes": 15,
    "metadata": {
        "app_name": "MonApp",
        "user_action": "registration"
    }
}
```

#### Paramètres

- `email` (requis) : Adresse email du destinataire
- `type` (optionnel) : Type d'OTP 
  - `email_verification` (défaut)
  - `password_reset`
  - `login_verification`
  - `two_factor`
- `identifier` (optionnel) : Identifiant personnalisé pour le contexte
- `validity_minutes` (optionnel) : Durée de validité en minutes (1-60, défaut: 15)
- `metadata` (optionnel) : Données additionnelles à stocker

#### Réponse de succès (200)

```json
{
    "status": "success",
    "message": "Code OTP envoyé avec succès",
    "data": {
        "otp_id": 123,
        "expires_at": "2025-08-28T14:30:00.000000Z",
        "type": "email_verification",
        "identifier": "app_registration_flow"
    }
}
```

#### Rate Limiting

- Maximum 3 tentatives par 15 minutes par email/IP

---

### 2. Vérifier un OTP

**POST** `/api/otp/verify`

Vérifie la validité d'un code OTP.

#### Paramètres de la requête

```json
{
    "email": "user@example.com",
    "code": "123456",
    "type": "email_verification",
    "identifier": "app_registration_flow"
}
```

#### Paramètres

- `email` (requis) : Adresse email
- `code` (requis) : Code à 6 chiffres à vérifier
- `type` (optionnel) : Type d'OTP (défaut: `email_verification`)
- `identifier` (optionnel) : Identifiant personnalisé

#### Réponse de succès (200)

```json
{
    "status": "success",
    "message": "Code OTP vérifié avec succès",
    "data": {
        "otp_id": 123,
        "user_id": 456,
        "verified_at": "2025-08-28T14:25:30.000000Z",
        "metadata": {
            "app_name": "MonApp",
            "user_action": "registration"
        }
    }
}
```

#### Réponses d'erreur

```json
// Code invalide (400)
{
    "status": "error",
    "message": "Code OTP invalide ou non trouvé",
    "error_code": "INVALID_CODE"
}

// Code expiré (400)
{
    "status": "error",
    "message": "Code OTP expiré",
    "error_code": "EXPIRED_CODE"
}

// Trop de tentatives (400)
{
    "status": "error",
    "message": "Nombre maximum de tentatives atteint",
    "error_code": "MAX_ATTEMPTS_REACHED"
}
```

#### Rate Limiting

- Maximum 10 tentatives par 10 minutes par email/IP

---

### 3. Renvoyer un OTP

**POST** `/api/otp/resend`

Génère et envoie un nouveau code OTP (invalide l'ancien).

#### Paramètres de la requête

```json
{
    "email": "user@example.com",
    "type": "email_verification",
    "identifier": "app_registration_flow",
    "validity_minutes": 15
}
```

#### Réponse de succès (200)

```json
{
    "status": "success",
    "message": "Nouveau code OTP envoyé avec succès",
    "data": {
        "otp_id": 124,
        "expires_at": "2025-08-28T14:45:00.000000Z",
        "type": "email_verification",
        "identifier": "app_registration_flow"
    }
}
```

#### Cooldown (429)

```json
{
    "status": "error",
    "message": "Veuillez attendre avant de renvoyer un nouveau code",
    "cooldown_remaining": 45
}
```

#### Rate Limiting

- Maximum 2 renvois par 5 minutes par email/IP
- Cooldown de 1 minute entre chaque renvoi

---

### 4. Statut d'un OTP

**GET** `/api/otp/status`

Récupère le statut de l'OTP actif pour un utilisateur.

#### Paramètres de la requête

```json
{
    "email": "user@example.com",
    "type": "email_verification"
}
```

#### Réponse de succès (200)

```json
{
    "status": "success",
    "data": {
        "has_active_otp": true,
        "otp_id": 123,
        "expires_at": "2025-08-28T14:30:00.000000Z",
        "attempts": 2,
        "max_attempts": 5,
        "is_expired": false,
        "created_at": "2025-08-28T14:15:00.000000Z"
    }
}
```

---

### 5. Nettoyage des OTP expirés

**DELETE** `/api/otp/cleanup`

Supprime les OTP expirés de la base de données (endpoint d'administration).

#### Réponse de succès (200)

```json
{
    "status": "success",
    "message": "Nettoyage terminé: 15 OTP expirés supprimés",
    "deleted_count": 15
}
```

---

## Types d'OTP disponibles

### `email_verification`
- **Usage** : Vérification d'adresse email lors de l'inscription
- **Template** : Email de vérification avec code bleu
- **Durée** : 15 minutes par défaut

### `password_reset`
- **Usage** : Réinitialisation de mot de passe
- **Template** : Email de sécurité avec code rouge
- **Durée** : 15 minutes par défaut
- **Sécurité** : Avertissement de sécurité inclus

### `login_verification`
- **Usage** : Vérification de connexion suspecte
- **Template** : Email de sécurité avec code vert
- **Durée** : 10 minutes recommandé

### `two_factor`
- **Usage** : Authentification à deux facteurs
- **Template** : Email d'authentification avec code violet
- **Durée** : 5-10 minutes recommandé

---

## Exemples d'intégration

### JavaScript (Frontend)

```javascript
// Générer un OTP
async function generateOtp(email) {
    const response = await fetch('/api/otp/generate', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + apiToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            type: 'email_verification',
            identifier: 'user_registration'
        })
    });
    
    return await response.json();
}

// Vérifier un OTP
async function verifyOtp(email, code) {
    const response = await fetch('/api/otp/verify', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + apiToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: email,
            code: code,
            type: 'email_verification'
        })
    });
    
    return await response.json();
}
```

### PHP (Backend)

```php
// Générer un OTP
$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $apiToken,
    'Accept' => 'application/json'
])->post('https://votre-api.com/api/otp/generate', [
    'email' => 'user@example.com',
    'type' => 'password_reset',
    'validity_minutes' => 10
]);

$data = $response->json();

// Vérifier un OTP
$response = Http::withHeaders([
    'Authorization' => 'Bearer ' . $apiToken,
    'Accept' => 'application/json'
])->post('https://votre-api.com/api/otp/verify', [
    'email' => 'user@example.com',
    'code' => '123456',
    'type' => 'password_reset'
]);

$data = $response->json();
```

### cURL

```bash
# Générer un OTP
curl -X POST https://votre-api.com/api/otp/generate \
  -H "Authorization: Bearer your_api_token" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "user@example.com",
    "type": "email_verification",
    "validity_minutes": 15
  }'

# Vérifier un OTP
curl -X POST https://votre-api.com/api/otp/verify \
  -H "Authorization: Bearer your_api_token" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "user@example.com",
    "code": "123456",
    "type": "email_verification"
  }'
```

---

## Codes d'erreur

- `200` : Succès
- `400` : Erreur de validation ou code invalide/expiré
- `422` : Données de validation invalides
- `429` : Rate limiting dépassé
- `500` : Erreur serveur

---

## Sécurité et bonnes pratiques

1. **Rate Limiting** : Les endpoints sont protégés contre le spam
2. **Expiration** : Les codes expirent automatiquement
3. **Usage unique** : Chaque code ne peut être utilisé qu'une seule fois
4. **Tentatives limitées** : Maximum 5 tentatives par code
5. **Invalidation** : Les anciens codes sont automatiquement invalidés
6. **Nettoyage automatique** : Les codes expirés sont supprimés

### Commande de nettoyage

```bash
# Nettoyer les OTP expirés (à programmer en cron)
php artisan otp:cleanup --force --older-than=24
```

### Programmation automatique (crontab)

```bash
# Ajouter dans votre crontab pour nettoyer quotidiennement
0 2 * * * cd /path/to/your/app && php artisan otp:cleanup --force
```

# Documentation - Système de Statistiques d'Emails

## Vue d'ensemble

Le système de statistiques d'emails permet de suivre et d'analyser tous les emails envoyés via l'API. Chaque email envoyé est automatiquement enregistré dans la table `email_logs` avec toutes les informations nécessaires pour générer des statistiques détaillées.

## Table EmailLog

La table `email_logs` contient les champs suivants :

### Informations de base
- `id` : Identifiant unique du log
- `user_id` : ID de l'utilisateur qui a envoyé l'email
- `api_token_id` : ID du token API utilisé (nullable)
- `mail_configuration_id` : ID de la configuration mail utilisée (nullable)

### Données de l'email
- `to` : Destinataire principal
- `cc` : Destinataires en copie (JSON array)
- `bcc` : Destinataires en copie cachée (JSON array)
- `subject` : Sujet de l'email
- `message` : Contenu du message
- `from_address` : Adresse d'expédition
- `from_name` : Nom d'expédition

### Informations techniques
- `application_name` : Nom de l'application qui a envoyé l'email
- `mailer_used` : Type de mailer utilisé (smtp, sendmail, etc.)
- `smtp_host` : Serveur SMTP utilisé
- `smtp_port` : Port SMTP utilisé

### Status et suivi
- `status` : Statut de l'email (`pending`, `sent`, `failed`, `bounced`, `delivered`)
- `error_message` : Message d'erreur en cas d'échec
- `sent_at` : Date d'envoi réel
- `delivered_at` : Date de livraison
- `bounced_at` : Date de bounce

### Métadonnées
- `ip_address` : Adresse IP de l'expéditeur
- `user_agent` : User agent de la requête
- `headers` : Headers supplémentaires (JSON)
- `metadata` : Métadonnées personnalisées (JSON)

## API Endpoints pour les Statistiques

Tous les endpoints nécessitent une authentification par token API.

### 1. Statistiques Utilisateur
```
GET /api/statistics/user?period=month
```

Paramètres :
- `period` : `today`, `week`, `month`, `quarter`, `year` (optionnel, défaut: `month`)

Réponse :
```json
{
  "success": true,
  "data": {
    "period": "month",
    "date_range": {
      "start": "2025-08-01T00:00:00Z",
      "end": "2025-08-23T10:27:14Z"
    },
    "total_emails": 150,
    "sent_emails": 145,
    "failed_emails": 5,
    "pending_emails": 0,
    "delivered_emails": 140,
    "bounced_emails": 2,
    "success_rate": 96.67,
    "daily_breakdown": [...],
    "top_applications": [...],
    "top_recipients": [...]
  }
}
```

### 2. Statistiques par Token
```
GET /api/statistics/token/{tokenId}?period=month
```

Retourne les statistiques pour un token API spécifique appartenant à l'utilisateur authentifié.

### 3. Statistiques par Application
```
GET /api/statistics/application/{applicationName}?period=month
```

Retourne les statistiques pour une application spécifique.

### 4. Statistiques Globales
```
GET /api/statistics/global?period=month
```

Retourne les statistiques globales de la plateforme.

### 5. Historique des Emails
```
GET /api/statistics/emails?page=1&per_page=20&status=sent&application=MyApp&from_date=2025-08-01&to_date=2025-08-23
```

Paramètres :
- `page` : Numéro de page (optionnel, défaut: 1)
- `per_page` : Nombre d'éléments par page (optionnel, défaut: 20, max: 100)
- `status` : Filtrer par statut (optionnel)
- `application` : Filtrer par application (optionnel)
- `from_date` : Date de début (optionnel, format: Y-m-d)
- `to_date` : Date de fin (optionnel, format: Y-m-d)

### 6. Détails d'un Email
```
GET /api/statistics/emails/{emailId}
```

Retourne les détails complets d'un email spécifique.

## Service EmailStatisticsService

Le service `EmailStatisticsService` contient toute la logique pour calculer les statistiques :

### Méthodes principales :
- `getUserStatistics(int $userId, string $period)` : Statistiques utilisateur
- `getTokenStatistics(int $tokenId, string $period)` : Statistiques par token
- `getApplicationStatistics(string $applicationName, string $period)` : Statistiques par application
- `getGlobalStatistics(string $period)` : Statistiques globales

### Périodes supportées :
- `today` : Aujourd'hui
- `week` : Cette semaine
- `month` : Ce mois
- `quarter` : Ce trimestre
- `year` : Cette année

## Modèle EmailLog

Le modèle `EmailLog` inclut plusieurs scopes utiles :

```php
// Filtrer par utilisateur
EmailLog::byUser($userId)->get();

// Filtrer par token
EmailLog::byToken($tokenId)->get();

// Filtrer par application
EmailLog::byApplication($appName)->get();

// Filtrer par statut
EmailLog::byStatus('sent')->get();

// Filtrer par plage de dates
EmailLog::inDateRange($startDate, $endDate)->get();

// Emails envoyés uniquement
EmailLog::sentEmails()->get();

// Emails échoués uniquement
EmailLog::failedEmails()->get();
```

### Méthodes utiles :
```php
$emailLog = EmailLog::find(1);

// Marquer comme envoyé
$emailLog->markAsSent();

// Marquer comme échoué
$emailLog->markAsFailed('Erreur SMTP');

// Marquer comme livré
$emailLog->markAsDelivered();

// Marquer comme bounced
$emailLog->markAsBounced();
```

## Relations

### EmailLog
- `user()` : Appartient à un utilisateur
- `apiToken()` : Appartient à un token API
- `mailConfiguration()` : Appartient à une configuration mail

### User
- `emailLogs()` : A plusieurs logs d'emails
- `mailConfigurations()` : A plusieurs configurations mail

### ApiToken
- `emailLogs()` : A plusieurs logs d'emails
- `mailConfiguration()` : Appartient à une configuration mail

### MailConfiguration
- `emailLogs()` : A plusieurs logs d'emails

## Utilisation dans l'envoi d'emails

Le système de logging est automatiquement intégré dans l'envoi d'emails. Quand vous envoyez un email via l'API :

1. Un log est créé avec le statut `pending`
2. L'email est envoyé
3. Le statut est mis à jour selon le résultat (`sent` ou `failed`)
4. Le token est marqué comme utilisé

### Exemple d'envoi avec logging automatique :

```bash
curl -X POST http://localhost:8000/api/send-email \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "to": "user@example.com",
    "subject": "Test Email",
    "message": "Hello World!",
    "application_name": "MyApp"
  }'
```

L'email sera automatiquement loggé avec toutes les informations nécessaires pour les statistiques.

## Index de Performance

La table `email_logs` inclut plusieurs index pour optimiser les requêtes de statistiques :

- `user_id, status, created_at`
- `api_token_id, status, created_at`
- `application_name, status, created_at`
- `status, created_at`
- `sent_at`
- `to`

Ces index permettent des requêtes rapides même avec un grand volume d'emails.

## Exemples d'utilisation

### Obtenir les statistiques du mois en cours
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  http://localhost:8000/api/statistics/user?period=month
```

### Obtenir l'historique des emails avec filtres
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  "http://localhost:8000/api/statistics/emails?status=failed&application=MyApp&per_page=50"
```

### Obtenir les statistiques d'un token spécifique
```bash
curl -H "Authorization: Bearer YOUR_TOKEN" \
  http://localhost:8000/api/statistics/token/123?period=week
```

## Cas d'usage

1. **Monitoring d'application** : Suivre les emails envoyés par chaque application
2. **Analyse de performance** : Calculer les taux de succès par période
3. **Détection d'anomalies** : Identifier les pics d'erreurs ou de bounces
4. **Facturation** : Compter les emails envoyés par utilisateur/token
5. **Debugging** : Analyser les erreurs d'envoi par configuration SMTP
6. **Compliance** : Garder un historique complet des communications

Ce système offre une visibilité complète sur l'activité d'envoi d'emails et permet de générer des rapports détaillés pour l'analyse et le monitoring.

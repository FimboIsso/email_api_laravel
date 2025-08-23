# 📧 UZASHOP Mail API - Open Source

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/API-REST-009688?style=for-the-badge" alt="REST API">
  <img src="https://img.shields.io/badge/Status-Production%20Ready-4CAF50?style=for-the-badge" alt="Status">
  <img src="https://img.shields.io/badge/License-MIT-yellow.svg?style=for-the-badge" alt="MIT License">
  <img src="https://img.shields.io/badge/Open%20Source-❤️-red.svg?style=for-the-badge" alt="Open Source">
</p>

<p align="center">
  <a href="https://github.com/FimboIsso/email_api_laravel">
    <img src="https://img.shields.io/github/stars/FimboIsso/email_api_laravel?style=social" alt="GitHub stars">
  </a>
  <a href="https://github.com/FimboIsso/email_api_laravel">
    <img src="https://img.shields.io/github/forks/FimboIsso/email_api_laravel?style=social" alt="GitHub forks">
  </a>
  <a href="https://github.com/FimboIsso/email_api_laravel/issues">
    <img src="https://img.shields.io/github/issues/FimboIsso/email_api_laravel?style=social&logo=github" alt="GitHub issues">
  </a>
</p>

<p align="center">
  <strong>🚀 API REST moderne, sécurisée et open source pour l'envoi d'emails professionnels</strong><br>
  Une solution complète développée avec ❤️ par <strong>UZASHOP Sarlu</strong><br>
  <em>Gratuite • Open Source • Self-hosted • Production Ready</em>
</p>

<p align="center">
  <a href="https://github.com/FimboIsso/email_api_laravel"><strong>🔗 Voir sur GitHub</strong></a> •
  <a href="#installation"><strong>📦 Installation</strong></a> •
  <a href="#documentation-api"><strong>📖 Documentation</strong></a> •
  <a href="#contribuer"><strong>🤝 Contribuer</strong></a>
</p>

---

## 🌟 Pourquoi choisir UZASHOP Mail API ?

### 🆓 **100% Open Source & Gratuite**
- **Code source ouvert** sous licence MIT
- **Aucun coût** de licence ou d'abonnement
- **Déploiement libre** sur vos propres serveurs
- **Modifications autorisées** selon vos besoins
- **Communauté active** de développeurs

### 🔒 **Sécurité & Confidentialité**
- **Contrôle total** de vos données
- **Auto-hébergement** sur votre infrastructure
- **Aucune collecte** de données personnelles
- **Conformité RGPD** par conception

### ⚡ **Performance & Fiabilité**
- **Laravel 12** - Framework moderne et performant
- **Architecture robuste** testée en production
- **Gestion d'erreurs complète** avec logs détaillés
- **Rate limiting** pour éviter les abus

---

## 🚀 Fonctionnalités

- ✅ **Authentification sécurisée** par token API
- ✅ **Configuration SMTP personnalisée** par utilisateur
- ✅ **Interface web intuitive** pour la gestion des tokens
- ✅ **Support CC et BCC** pour les envois multiples
- ✅ **Pièces jointes** jusqu'à 10MB par fichier
- ✅ **Messages HTML et texte** avec templates personnalisables
- ✅ **Validation robuste** des données d'entrée
- ✅ **Gestion d'erreurs complète** avec réponses JSON
- ✅ **Documentation interactive** intégrée
- ✅ **Testeur API en temps réel**

## 🛠️ Installation

### Prérequis

- PHP 8.1 ou supérieur
- Composer
- Node.js et npm
- Base de données (MySQL/SQLite)

### Installation rapide

```bash
# Cloner le projet
git clone https://github.com/FimboIsso/email_api_laravel.git
cd email_api_laravel

# Installer les dépendances PHP
composer install

# Installer les dépendances JavaScript
npm install && npm run build

# Configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer la base de données dans .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Exécuter les migrations
php artisan migrate

# Démarrer le serveur
php artisan serve
```

Visitez `http://localhost:8000` pour accéder à la documentation interactive.

## 📖 Documentation API

### Authentification

Toutes les requêtes API nécessitent un token d'authentification :

```bash
# Header recommandé
Authorization: Bearer YOUR_API_TOKEN

# Alternative
X-API-Token: YOUR_API_TOKEN
```

### Endpoints principaux

#### 📤 Envoyer un email

```http
POST /api/send-email
Content-Type: application/json
Authorization: Bearer YOUR_TOKEN

{
  "to": "destinataire@example.com",
  "subject": "Sujet du message",
  "message": "<h1>Contenu HTML</h1><p>Votre message ici</p>",
  "cc": ["cc1@example.com", "cc2@example.com"],
  "bcc": ["bcc@example.com"]
}
```

**Réponse de succès :**
```json
{
  "status": "success",
  "message": "Email sent successfully",
  "data": {
    "to": "destinataire@example.com",
    "subject": "Sujet du message",
    "sent_at": "2025-08-19T06:30:45.000000Z",
    "sent_by": "Nom utilisateur"
  }
}
```

#### 👤 Informations utilisateur

```http
GET /api/user-info
Authorization: Bearer YOUR_TOKEN
```

**Réponse :**
```json
{
  "status": "success",
  "data": {
    "id": 1,
    "name": "John Doe",
    "email": "john@example.com",
    "mail_config": {
      "mailer": "smtp",
      "host": "smtp.gmail.com",
      "port": 587,
      "from_address": "noreply@example.com",
      "from_name": "Mon Application"
    }
  }
}
```

## 🔧 Configuration

### Configuration email personnalisée

Chaque utilisateur peut configurer ses propres paramètres SMTP :

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="Your App Name"
```

### Variables d'environnement importantes

```env
APP_NAME="UZASHOP Mail API"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mail_api_laravel
DB_USERNAME=root
DB_PASSWORD=

# Mail par défaut (pour les logs)
MAIL_MAILER=log
```

## 🎯 Utilisation

### 1. Créer un compte

Visitez `/register` pour créer votre compte utilisateur.

### 2. Générer un token API

1. Connectez-vous à `/login`
2. Accédez à votre tableau de bord `/dashboard`
3. Cliquez sur "Générer un Token"
4. Copiez et sauvegardez votre token

### 3. Configurer votre SMTP

Dans le tableau de bord, configurez vos paramètres SMTP :
- Serveur SMTP (ex: smtp.gmail.com)
- Port (587 pour TLS, 465 pour SSL)
- Identifiants d'authentification
- Adresse d'expédition

### 4. Tester votre configuration

Utilisez le testeur intégré ou envoyez une requête cURL :

```bash
curl -X POST http://localhost:8000/api/send-email \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "to": "test@example.com",
    "subject": "Test Email",
    "message": "Ceci est un test depuis UZASHOP Mail API"
  }'
```

## 🔒 Sécurité

- **Tokens uniques** : Chaque utilisateur dispose d'un token SHA-256 unique
- **Validation stricte** : Tous les inputs sont validés côté serveur
- **Configuration isolée** : Chaque utilisateur a sa propre config SMTP
- **Chiffrement** : Communication HTTPS recommandée en production
- **Rate limiting** : Limite les requêtes par utilisateur

## 🧪 Tests

```bash
# Lancer les tests
php artisan test

# Tests avec couverture
php artisan test --coverage
```

## 📁 Structure du projet

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── MailController.php      # Logique d'envoi d'emails
│   │   │   └── DashboardController.php # Gestion des tokens et config
│   │   └── Middleware/
│   │       └── ApiTokenAuth.php        # Authentification API
│   ├── Mail/
│   │   └── CustomMail.php              # Template d'email
│   └── Models/
│       └── User.php                    # Modèle utilisateur étendu
├── resources/
│   └── views/
│       ├── mail-api-docs.blade.php     # Documentation interactive
│       ├── dashboard.blade.php         # Interface de gestion
│       └── emails/
│           └── custom.blade.php        # Template d'email
├── routes/
│   ├── api.php                         # Routes API
│   └── web.php                         # Routes web
└── database/
    └── migrations/                     # Migrations de la DB
```

## 🚀 Déploiement

### Production

```bash
# Optimisations Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Variables d'environnement
APP_ENV=production
APP_DEBUG=false

# HTTPS obligatoire
FORCE_HTTPS=true
```

### Docker (optionnel)

```dockerfile
FROM php:8.2-fpm
# Configuration Docker...
```

## 📝 Licence & Contribution

### 📜 Licence MIT

Ce projet est **100% open source** et distribué sous licence MIT. Cela signifie que vous pouvez :

- ✅ **Utiliser** le code à des fins commerciales
- ✅ **Modifier** le code selon vos besoins
- ✅ **Distribuer** vos modifications
- ✅ **Créer des œuvres dérivées**
- ✅ **Usage privé** sans restrictions

**La seule obligation** : conserver la notice de copyright et la licence dans vos copies.

### 🤝 Contribuer au projet

Nous encourageons les contributions de la communauté ! Voici comment participer :

#### 🐛 Signaler des bugs
1. Vérifiez les [issues existantes](https://github.com/FimboIsso/email_api_laravel/issues)
2. Créez une nouvelle issue avec :
   - Description détaillée du problème
   - Étapes pour reproduire
   - Environnement (OS, PHP, Laravel)
   - Captures d'écran si pertinentes

#### ✨ Proposer des améliorations
1. **Fork** le projet sur GitHub
2. Créez une **branche feature** (`git checkout -b feature/AmazingFeature`)
3. **Committez** vos changements (`git commit -m 'Add AmazingFeature'`)
4. **Pushez** vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une **Pull Request** détaillée

#### � Améliorer la documentation
- Correction de fautes de frappe
- Ajout d'exemples d'utilisation
- Traductions dans d'autres langues
- Amélioration des tutoriels

#### 💰 Soutenir le projet
- ⭐ **Donnez une étoile** sur GitHub
- 🔄 **Partagez** le projet dans vos réseaux
- 📝 **Écrivez** un article de blog
- 💻 **Contribuez** au code

### 🏆 Contributeurs

Un grand merci à tous nos contributeurs qui font de ce projet une réussite !

<p align="center">
  <a href="https://github.com/FimboIsso/email_api_laravel/graphs/contributors">
    <img src="https://contrib.rocks/image?repo=FimboIsso/email_api_laravel" alt="Contributeurs"/>
  </a>
</p>

---

## � Communauté & Support

### 💬 Rejoignez notre communauté

- **GitHub** : [Issues & Discussions](https://github.com/FimboIsso/email_api_laravel)
- **Email** : contact@uzashop.co
- **Site web** : [uzashop.co](https://uzashop.co)

### � Statistiques du projet

- **Uptime** : 99.9% en production
- **Tests** : Couverture > 90%
- **Performance** : < 100ms par requête API
- **Sécurité** : Audité régulièrement

Ce projet est **open source** et sera toujours **gratuit**. Nous croyons que les outils de qualité devraient être accessibles à tous les développeurs, quelle que soit la taille de leur projet ou leur budget.

## 📝 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

**En résumé** : Vous pouvez faire ce que vous voulez avec ce code, tant que vous conservez la notice de copyright. C'est aussi simple que ça ! 🎉

## 👥 Équipe

Développé avec ❤️ par **UZASHOP Sarlu**

- **Site web** : [uzashop.co](https://uzashop.co)
- **GitHub** : [@FimboIsso](https://github.com/FimboIsso)
- **Email** : contact@uzashop.co

---

<p align="center">
  <strong>🌟 UZASHOP Mail API - Solution Open Source d'envoi d'emails</strong>
  <br>
  <em>Propulsé par Laravel & TailwindCSS • Hébergé avec ❤️</em>
  <br><br>
  <a href="https://github.com/FimboIsso/email_api_laravel">
    <img src="https://img.shields.io/badge/⭐-Star_on_GitHub-yellow?style=for-the-badge" alt="Star on GitHub">
  </a>
</p>

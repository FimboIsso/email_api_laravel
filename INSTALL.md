# 📋 Guide d'Installation - UZASHOP Mail API

Ce guide vous accompagne étape par étape pour installer et configurer l'API Mail UZASHOP.

## ✅ Prérequis

Avant de commencer, assurez-vous d'avoir :

- **PHP 8.1+** avec les extensions : `mbstring`, `xml`, `ctype`, `json`, `bcmath`, `fileinfo`, `tokenizer`
- **Composer** (gestionnaire de dépendances PHP)
- **Node.js** et **npm** (pour la compilation des assets)
- **Serveur web** (Apache/Nginx) ou utiliser le serveur intégré de Laravel
- **Base de données** (MySQL recommandé, SQLite pour les tests)

### Vérification des prérequis

```bash
# Vérifier PHP
php --version

# Vérifier Composer
composer --version

# Vérifier Node.js
node --version && npm --version
```

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/FimboIsso/email_api_laravel.git
cd email_api_laravel
```

### 2. Installation des dépendances

```bash
# Dépendances PHP
composer install

# Dépendances JavaScript
npm install
```

### 3. Configuration de l'environnement

```bash
# Copier le fichier de configuration
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4. Configuration de la base de données

Éditez le fichier `.env` et configurez votre base de données :

#### Option A : MySQL (Recommandé)

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mail_api_laravel
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

Créez la base de données :
```bash
mysql -u root -p -e "CREATE DATABASE mail_api_laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

#### Option B : SQLite (Pour les tests)

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database.sqlite
```

Créez le fichier de base de données :
```bash
touch database/database.sqlite
```

### 5. Migrations et préparation

```bash
# Exécuter les migrations
php artisan migrate

# Compiler les assets
npm run build
```

### 6. Démarrer le serveur

```bash
# Serveur de développement
php artisan serve

# Ou spécifier host et port
php artisan serve --host=0.0.0.0 --port=8000
```

L'application sera accessible à : `http://localhost:8000`

## 🔧 Configuration Avancée

### Configuration Email

Par défaut, l'API utilise le driver `log` pour les emails (stockage dans `storage/logs/laravel.log`). Chaque utilisateur peut configurer ses propres paramètres SMTP via l'interface web.

### Configuration de Production

Pour un environnement de production, modifiez le fichier `.env` :

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Optimisations
CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

# Sécurité
FORCE_HTTPS=true
SESSION_SECURE_COOKIE=true
```

Puis optimisez l'application :

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🎯 Premier Test

### 1. Créer un compte utilisateur

1. Visitez `http://localhost:8000`
2. Cliquez sur "S'inscrire"
3. Remplissez le formulaire d'inscription

### 2. Générer un token API

1. Connectez-vous à votre compte
2. Accédez au tableau de bord
3. Cliquez sur "Générer un Token"
4. **Important** : Copiez et sauvegardez le token affiché

### 3. Configurer SMTP (optionnel)

Dans le tableau de bord, configurez vos paramètres SMTP :

```
Mailer: smtp
Serveur: smtp.gmail.com
Port: 587
Encryption: tls
Username: votre.email@gmail.com
Password: votre_mot_de_passe_app
Email d'expédition: noreply@votredomaine.com
Nom d'expédition: Votre App
```

### 4. Tester l'API

```bash
curl -X POST http://localhost:8000/api/send-email \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer VOTRE_TOKEN" \
  -d '{
    "to": "test@example.com",
    "subject": "Test UZASHOP Mail API",
    "message": "Ceci est un test depuis UZASHOP Mail API"
  }'
```

## 🔍 Vérification de l'Installation

### Tests automatisés

```bash
# Lancer les tests
php artisan test
```

### Vérifications manuelles

1. **Page d'accueil** : `http://localhost:8000` - Doit afficher la documentation
2. **Inscription** : `http://localhost:8000/register` - Formulaire d'inscription
3. **Connexion** : `http://localhost:8000/login` - Formulaire de connexion
4. **Tableau de bord** : `http://localhost:8000/dashboard` - Interface de gestion (après connexion)

## ⚠️ Problèmes Courants

### Erreur "Permission denied"

```bash
# Donner les permissions sur les dossiers storage et bootstrap/cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Erreur "Class not found"

```bash
# Régénérer l'autoload
composer dump-autoload
```

### Erreur de base de données

```bash
# Vérifier la connexion
php artisan tinker
>>> DB::connection()->getPdo();
```

### Assets non compilés

```bash
# Recompiler les assets
npm run build

# Pour le développement avec hot-reload
npm run dev
```

## 🛠️ Outils de Développement

### Logs de développement

```bash
# Surveiller les logs en temps réel
tail -f storage/logs/laravel.log
```

### Interface Tinker

```bash
# Console interactive Laravel
php artisan tinker

# Exemples de commandes
>>> User::count()
>>> Mail::raw('Test', function($m) { $m->to('test@test.com'); })
```

### Debugging

Ajoutez dans `.env` pour plus de détails :

```env
APP_DEBUG=true
LOG_LEVEL=debug
```

## 📦 Structure après Installation

```
email_api_laravel/
├── app/                    # Code de l'application
├── bootstrap/              # Fichiers de démarrage
├── config/                 # Fichiers de configuration
├── database/               # Migrations et seeders
├── public/                 # Point d'entrée web
├── resources/              # Vues, assets, langues
├── routes/                 # Définitions des routes
├── storage/                # Fichiers générés, logs
├── tests/                  # Tests automatisés
├── vendor/                 # Dépendances Composer
├── .env                    # Configuration environnement
├── composer.json           # Dépendances PHP
├── package.json            # Dépendances JavaScript
└── README.md               # Documentation
```

## 🎉 Installation Terminée !

Votre API Mail UZASHOP est maintenant prête à l'emploi !

### Prochaines étapes :

1. **Personnalisation** : Modifiez les templates et styles selon vos besoins
2. **Configuration SMTP** : Configurez vos paramètres d'envoi d'emails
3. **Tests** : Testez l'API avec vos applications
4. **Déploiement** : Déployez en production avec les optimisations

### Support

- **Documentation complète** : [README.md](README.md)
- **Issues GitHub** : [Issues](https://github.com/FimboIsso/email_api_laravel/issues)
- **Site UZASHOP** : [uzashop.co](https://uzashop.co)

---

**UZASHOP Mail API** - Installation réussie ! 🎉

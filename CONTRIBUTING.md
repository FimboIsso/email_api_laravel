# 🤝 Guide de Contribution - UZASHOP Mail API

Merci de votre intérêt pour contribuer à UZASHOP Mail API ! Ce projet open source prospère grâce aux contributions de la communauté.

## 🌟 Types de Contributions

Nous accueillons tous les types de contributions :

- 🐛 **Corrections de bugs**
- ✨ **Nouvelles fonctionnalités**
- 📖 **Amélioration de la documentation**
- 🧹 **Refactoring de code**
- 🚀 **Optimisations de performance**
- 🌐 **Traductions**
- ✅ **Tests supplémentaires**

## 🚀 Comment Contribuer

### 1. Prérequis

- PHP 8.1+
- Composer
- Node.js & npm
- Git

### 2. Fork et Clone

```bash
# Fork le projet sur GitHub, puis clonez votre fork
git clone https://github.com/VOTRE_USERNAME/email_api_laravel.git
cd email_api_laravel

# Ajoutez le repository original comme remote
git remote add upstream https://github.com/FimboIsso/email_api_laravel.git
```

### 3. Installation

```bash
# Installer les dépendances
composer install
npm install

# Copier et configurer l'environnement
cp .env.example .env
php artisan key:generate

# Configurer la base de données et lancer les migrations
php artisan migrate

# Générer les assets
npm run build
```

### 4. Créer une Branche

```bash
# Créer une branche pour votre contribution
git checkout -b feature/ma-nouvelle-fonctionnalite
# ou
git checkout -b fix/correction-bug-important
```

### 5. Développement

- Écrivez du code propre et bien documenté
- Suivez les conventions de codage PSR-12
- Ajoutez des tests pour les nouvelles fonctionnalités
- Mettez à jour la documentation si nécessaire

### 6. Tests

```bash
# Lancer les tests
php artisan test

# Vérifier le style de code
./vendor/bin/phpstan analyse

# Tester manuellement votre fonctionnalité
php artisan serve
```

### 7. Commit

```bash
# Ajouter vos fichiers
git add .

# Commit avec un message descriptif
git commit -m "✨ Ajouter support pour les templates d'email personnalisés"
```

**Format des messages de commit :**
- `✨ feat:` nouvelle fonctionnalité
- `🐛 fix:` correction de bug
- `📖 docs:` documentation
- `🎨 style:` formatage
- `♻️ refactor:` refactoring
- `⚡ perf:` amélioration performance
- `✅ test:` ajout/modification de tests

### 8. Push et Pull Request

```bash
# Push vers votre fork
git push origin feature/ma-nouvelle-fonctionnalite
```

Créez une Pull Request sur GitHub avec :

- **Titre clair** : Résumé de votre contribution
- **Description détaillée** : Que fait votre changement et pourquoi
- **Tests** : Comment tester votre contribution
- **Screenshots** : Si changement visuel

## 📋 Checklist avant Pull Request

- [ ] Le code respecte les standards PSR-12
- [ ] Tous les tests passent
- [ ] La documentation est mise à jour
- [ ] Les nouveaux fichiers incluent les headers de licence
- [ ] Les messages de commit sont clairs
- [ ] Aucun fichier de configuration personnel (.env, IDE)

## 🐛 Signaler des Bugs

1. **Vérifiez** que le bug n'a pas déjà été signalé
2. **Créez une issue** avec le template bug
3. **Incluez** :
   - Description détaillée
   - Étapes pour reproduire
   - Comportement attendu vs actuel
   - Environnement (OS, PHP, Laravel)
   - Captures d'écran si pertinent

## 💡 Proposer des Fonctionnalités

1. **Ouvrez une issue** avec le template feature request
2. **Décrivez** la fonctionnalité souhaitée
3. **Expliquez** le cas d'usage
4. **Discutez** avec la communauté

## 📖 Améliorer la Documentation

- Corriger les fautes de frappe
- Améliorer les explications
- Ajouter des exemples
- Traduire dans d'autres langues

## 🎨 Standards de Code

### PHP

- **PSR-12** pour le style de code
- **DocBlocks** pour toutes les méthodes publiques
- **Type hints** pour tous les paramètres
- **Return types** déclarés

### JavaScript

- **ESLint** configuration incluse
- **Conventions modernes** (ES6+)
- **Comments** pour la logique complexe

### Templates Blade

- **Indentation** 4 espaces
- **Noms descriptifs** pour les variables
- **Structure** claire et logique

## 🤔 Questions ?

- **GitHub Issues** : Pour les questions techniques
- **Email** : contact@uzashop.co
- **Discussions** : GitHub Discussions pour les idées

## 🏆 Reconnaissance

Tous les contributeurs sont reconnus dans :

- Le fichier README.md
- La page de crédits de l'application
- Les releases notes

## 📜 Licence

En contribuant, vous acceptez que vos contributions soient sous licence MIT, la même licence que le projet.

---

**Merci de contribuer à UZASHOP Mail API ! Ensemble, créons la meilleure API d'envoi d'emails open source.** 🚀

*Développé avec ❤️ par la communauté UZASHOP*

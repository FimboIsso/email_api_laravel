# Paramètres Templates - Guide de Référence

## Vue d'ensemble
Documentation complète des paramètres pour utiliser les templates dynamiques Blade avec l'API Email UZASHOP.

## Paramètres API

### `template_content` (string, requis si pas de `message`)
- **Description** : Contenu HTML/Blade du template avec variables dynamiques
- **Limite** : 50 000 caractères maximum
- **Format** : HTML valide avec syntaxe Blade
- **Variables** : `{{ $variable_name }}`
- **Directives** : `@if`, `@foreach`, `@include`

### `template_data` (object, optionnel)
- **Description** : Objet JSON contenant les variables à injecter
- **Limite** : 5 000 caractères maximum
- **Format** : JSON valide
- **Profondeur** : Maximum 3 niveaux
- **Types** : string, number, boolean, array, object

## Exemple d'Usage

```bash
curl -X POST http://votre-api.com/api/send-email \
  -H "Content-Type: application/json" \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -d '{
    "to": "destinataire@example.com",
    "subject": "Bonjour {{ $user_name }} !",
    "template_content": "<h1>Bienvenue {{ $user_name }} !</h1><p>Votre commande #{{ $order_id }} est confirmée.</p>",
    "template_data": {
      "user_name": "Marie Dupont",
      "order_id": "CMD-12345"
    }
  }'
```

## Validation et Sécurité

### Règles de Validation
- Templates HTML valides uniquement
- Variables Blade échappées automatiquement
- Scripts JavaScript bloqués
- Timeout de compilation : 5 secondes

### Gestion d'Erreurs
- **400** : Template invalid - Syntaxe incorrecte
- **422** : JSON invalid - Format template_data incorrect
- **413** : Content too large - Limite de taille dépassée

### Mécanisme de Fallback
Si le template échoue, l'API utilise automatiquement le paramètre `message` comme contenu de secours.

## Bonnes Pratiques

### ✅ Recommandé
- Utilisez des noms de variables descriptifs
- Testez avec des données factices
- Incluez toujours un message de fallback
- Utilisez CSS inline
- Validez le JSON avant envoi

### ❌ À Éviter
- JavaScript dans les templates
- Templates trop complexes (>10k caractères)
- Données sensibles dans template_data
- Boucles infinies
- Variables non échappées dans URLs

## Performance
- Templates compacts pour compilation rapide
- Données structurées logiquement  
- Cache automatique des templates identiques

## Documentation Complète
Pour plus d'exemples et de cas d'usage avancés, consultez :
- [Documentation API complète](API.md)
- [Guide des Templates](TEMPLATE_GUIDE.md)
- [Page de documentation interactive](http://votre-api.com/mail-api-docs#template-params)

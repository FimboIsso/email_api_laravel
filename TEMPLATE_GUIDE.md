# 🎨 Guide Complet des Templates Email

Ce guide détaillé explique comment utiliser les templates Blade personnalisés avec l'API Email UZASHOP.

## 📋 Table des Matières

1. [Vue d'ensemble](#vue-densemble)
2. [Syntaxe Blade](#syntaxe-blade)
3. [Variables et Données](#variables-et-données)
4. [Exemples Pratiques](#exemples-pratiques)
5. [Bonnes Pratiques](#bonnes-pratiques)
6. [Dépannage](#dépannage)

---

## Vue d'ensemble

### Qu'est-ce qu'un Template Email ?

Un template email est un modèle HTML avec des variables dynamiques qui peuvent être personnalisées pour chaque envoi. L'API utilise le moteur de template **Blade de Laravel** pour traiter les templates.

### Avantages des Templates

- ✅ **Personnalisation dynamique** : Variables injectées en temps réel
- ✅ **Logique conditionnelle** : Affichage conditionnel de contenu
- ✅ **Boucles** : Répétition de sections (listes, tableaux)
- ✅ **Réutilisabilité** : Même template pour différents clients
- ✅ **Maintenance simplifiée** : Templates centralisés côté client

---

## Syntaxe Blade

### Variables de Base

```blade
<!-- Variable simple -->
{{ $nom }}

<!-- Variable avec valeur par défaut -->
{{ $nom ?? 'Valeur par défaut' }}

<!-- HTML non échappé (attention sécurité!) -->
{!! $contenu_html !!}

<!-- Echapper des accolades -->
@{{ ceci_ne_sera_pas_traité }}
```

### Conditions

```blade
<!-- If simple -->
@if($age >= 18)
    <p>Vous êtes majeur</p>
@endif

<!-- If/Else -->
@if($status == 'premium')
    <p>Compte Premium</p>
@else
    <p>Compte Standard</p>
@endif

<!-- If/ElseIf/Else -->
@if($score >= 90)
    <p>Excellent !</p>
@elseif($score >= 70)
    <p>Bien !</p>
@else
    <p>Peut mieux faire</p>
@endif

<!-- Unless (sauf si) -->
@unless($is_banned)
    <p>Bienvenue sur la plateforme</p>
@endunless

<!-- Isset/Empty -->
@isset($user)
    <p>Utilisateur connecté : {{ $user }}</p>
@endisset

@empty($items)
    <p>Aucun élément à afficher</p>
@endempty
```

### Boucles

```blade
<!-- Foreach -->
@foreach($produits as $produit)
    <div class="produit">
        <h3>{{ $produit['nom'] }}</h3>
        <p>Prix : {{ $produit['prix'] }}€</p>
    </div>
@endforeach

<!-- Foreach avec index -->
@foreach($items as $index => $item)
    <p>{{ $index + 1 }}. {{ $item }}</p>
@endforeach

<!-- For classique -->
@for($i = 1; $i <= 5; $i++)
    <p>Ligne {{ $i }}</p>
@endfor

<!-- While -->
@while($condition)
    <p>Tant que condition est vraie</p>
@endwhile

<!-- Forelse (foreach avec cas vide) -->
@forelse($commandes as $commande)
    <p>Commande #{{ $commande['id'] }}</p>
@empty
    <p>Aucune commande trouvée</p>
@endforelse
```

### Variables de Boucle

Blade fournit automatiquement la variable `$loop` dans les boucles :

```blade
@foreach($items as $item)
    <p>
        Item {{ $loop->iteration }} sur {{ $loop->count }}
        @if($loop->first) (Premier) @endif
        @if($loop->last) (Dernier) @endif
    </p>
@endforeach
```

Propriétés de `$loop` :
- `$loop->index` : Index (0, 1, 2...)
- `$loop->iteration` : Itération (1, 2, 3...)
- `$loop->first` : true si premier élément
- `$loop->last` : true si dernier élément
- `$loop->count` : Nombre total d'éléments
- `$loop->remaining` : Éléments restants

---

## Variables et Données

### Types de Données Supportés

```json
{
  "template_data": {
    "string_simple": "Bonjour",
    "number": 42,
    "float": 19.99,
    "boolean": true,
    "null_value": null,
    "array_simple": ["item1", "item2", "item3"],
    "array_associatif": {
      "nom": "Jean",
      "age": 30,
      "email": "jean@example.com"
    },
    "array_complexe": [
      {
        "id": 1,
        "nom": "Produit A",
        "prix": 25.50,
        "categories": ["tech", "gadget"]
      },
      {
        "id": 2,
        "nom": "Produit B",
        "prix": 15.00,
        "categories": ["livre"]
      }
    ]
  }
}
```

### Accès aux Données Complexes

```blade
<!-- Objet simple -->
<p>Nom : {{ $user['nom'] }}</p>
<p>Email : {{ $user['email'] }}</p>

<!-- Tableau de tableaux -->
@foreach($produits as $produit)
    <h3>{{ $produit['nom'] }}</h3>
    <p>Prix : {{ $produit['prix'] }}€</p>
    
    <!-- Sous-tableau -->
    @if(!empty($produit['categories']))
        <p>Catégories : 
        @foreach($produit['categories'] as $cat)
            <span class="tag">{{ $cat }}</span>
        @endforeach
        </p>
    @endif
@endforeach
```

---

## Exemples Pratiques

### 1. Email de Confirmation de Commande

```json
{
  "to": "client@example.com",
  "subject": "Confirmation de votre commande #{{ $order_id }}",
  "message": "Votre commande a été confirmée",
  "template_content": "<!DOCTYPE html><html><head><meta charset='utf-8'><style>body{font-family:Arial,sans-serif;line-height:1.6;margin:0;padding:20px;background:#f4f4f4}.container{max-width:600px;margin:0 auto;background:white;padding:30px;border-radius:10px;box-shadow:0 2px 10px rgba(0,0,0,0.1)}.header{text-align:center;border-bottom:2px solid #28a745;padding-bottom:20px;margin-bottom:30px}.header h1{color:#28a745;margin:0}.order-info{background:#f8f9fa;padding:20px;border-radius:5px;margin:20px 0}.item{display:flex;justify-content:space-between;padding:10px 0;border-bottom:1px solid #eee}.item:last-child{border-bottom:none}.total{background:#28a745;color:white;padding:15px;border-radius:5px;text-align:center;font-size:18px;font-weight:bold;margin:20px 0}.footer{text-align:center;color:#666;font-size:12px;margin-top:30px}</style></head><body><div class='container'><div class='header'><h1>{{ $company_name }}</h1><p>Confirmation de Commande</p></div><h2>Bonjour {{ $customer_name }},</h2><p>Merci pour votre commande ! Voici un récapitulatif :</p><div class='order-info'><p><strong>Commande :</strong> #{{ $order_id }}</p><p><strong>Date :</strong> {{ $order_date }}</p><p><strong>Statut :</strong> {{ $order_status }}</p></div><h3>Articles commandés :</h3>@foreach($items as $item)<div class='item'><div><strong>{{ $item['name'] }}</strong><br><small>{{ $item['description'] }}</small></div><div><span>{{ $item['quantity'] }}x {{ number_format($item['price'], 2) }}€</span></div></div>@endforeach<div class='total'>Total : {{ number_format($total, 2) }}€</div><p><strong>Adresse de livraison :</strong><br>{{ $shipping_address }}</p><p>Votre commande sera traitée dans les prochaines 24h. Vous recevrez un email de confirmation d'expédition.</p><p>Merci de votre confiance !<br>L'équipe {{ $company_name }}</p><div class='footer'><p>{{ $company_name }} - {{ $company_address }}</p><p>Email: {{ $company_email }} | Tél: {{ $company_phone }}</p></div></div></body></html>",
  "template_data": {
    "customer_name": "Marie Dubois",
    "company_name": "UZASHOP Store",
    "order_id": "CMD-2025-00142",
    "order_date": "28/08/2025",
    "order_status": "Confirmée",
    "items": [
      {
        "name": "MacBook Pro 13\"",
        "description": "Puce M2, 256GB SSD",
        "quantity": 1,
        "price": 1299.00
      },
      {
        "name": "Magic Mouse",
        "description": "Souris sans fil Apple",
        "quantity": 1,
        "price": 85.00
      }
    ],
    "total": 1384.00,
    "shipping_address": "Marie Dubois\n15 Avenue des Champs\n75008 Paris",
    "company_address": "UZASHOP, 123 Rue du Commerce, 75001 Paris",
    "company_email": "contact@uzashop.co",
    "company_phone": "+33 1 23 45 67 89"
  }
}
```

### 2. Email de Newsletter

```json
{
  "to": "subscriber@example.com",
  "subject": "{{ $newsletter_title }} - {{ $newsletter_edition }}",
  "message": "Notre newsletter est disponible",
  "template_content": "<!DOCTYPE html><html><head><meta charset='utf-8'><style>body{font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;line-height:1.6;margin:0;padding:0;background:#f8f9fa}.container{max-width:700px;margin:0 auto;background:white}.header{background:linear-gradient(135deg,#667eea,#764ba2);color:white;padding:40px 30px;text-align:center}.header h1{margin:0;font-size:28px;font-weight:300}.header p{margin:10px 0 0 0;opacity:0.9}.content{padding:30px}.intro{font-size:18px;color:#555;margin-bottom:30px}.article{margin:30px 0;padding:25px;border-radius:8px;background:#fff;box-shadow:0 2px 5px rgba(0,0,0,0.1)}.article h2{color:#333;margin-top:0;font-size:22px}.article-meta{color:#888;font-size:14px;margin:10px 0}.article-excerpt{color:#666;margin:15px 0}.read-more{display:inline-block;background:#667eea;color:white;padding:8px 20px;text-decoration:none;border-radius:20px;font-size:14px}.footer{background:#2c3e50;color:white;padding:30px;text-align:center}.footer a{color:#3498db}.social{margin:20px 0}.social a{display:inline-block;margin:0 10px;color:#3498db;text-decoration:none}</style></head><body><div class='container'><div class='header'><h1>{{ $newsletter_title }}</h1><p>{{ $newsletter_edition }} | {{ $newsletter_date }}</p></div><div class='content'><div class='intro'>Bonjour {{ $subscriber_name }},<br>Découvrez notre sélection d'articles de cette {{ $newsletter_period }}.</div>@foreach($articles as $article)<div class='article'><h2>{{ $article['title'] }}</h2><div class='article-meta'>Par {{ $article['author'] }} | {{ $article['category'] }} | {{ $article['read_time'] }} min</div><p class='article-excerpt'>{{ $article['excerpt'] }}</p><a href='{{ $article['url'] }}' class='read-more'>Lire l'article complet →</a></div>@endforeach@if(!empty($featured_product))<div class='article' style='border-left:4px solid #e74c3c'><h2>🔥 Produit du mois</h2><p><strong>{{ $featured_product['name'] }}</strong></p><p>{{ $featured_product['description'] }}</p><p style='color:#e74c3c;font-size:18px;font-weight:bold'>{{ number_format($featured_product['price'], 2) }}€</p><a href='{{ $featured_product['url'] }}' class='read-more' style='background:#e74c3c'>Voir le produit</a></div>@endif</div><div class='footer'><p>Merci de votre fidélité !<br>L'équipe {{ $company_name }}</p><div class='social'><a href='{{ $social_links['facebook'] }}'>Facebook</a><a href='{{ $social_links['twitter'] }}'>Twitter</a><a href='{{ $social_links['linkedin'] }}'>LinkedIn</a></div><p><small>Vous recevez cet email car vous êtes abonné à notre newsletter.<br><a href='{{ $unsubscribe_link }}'>Se désabonner</a> | <a href='{{ $preferences_link }}'>Gérer mes préférences</a></small></p></div></div></body></html>",
  "template_data": {
    "newsletter_title": "TechNews UZASHOP",
    "newsletter_edition": "Édition #47",
    "newsletter_date": "Août 2025",
    "newsletter_period": "semaine",
    "subscriber_name": "Sophie Martin",
    "company_name": "UZASHOP",
    "articles": [
      {
        "title": "L'IA révolutionne le e-commerce",
        "author": "Jean Dupont",
        "category": "Intelligence Artificielle",
        "read_time": 5,
        "excerpt": "Découvrez comment l'intelligence artificielle transforme l'expérience d'achat en ligne et booste les ventes.",
        "url": "https://uzashop.co/blog/ia-ecommerce"
      },
      {
        "title": "Guide complet des APIs RESTful",
        "author": "Marie Leblanc",
        "category": "Développement",
        "read_time": 8,
        "excerpt": "Apprenez à concevoir des APIs RESTful robustes et scalables avec les meilleures pratiques du secteur.",
        "url": "https://uzashop.co/blog/api-restful-guide"
      }
    ],
    "featured_product": {
      "name": "Formation Laravel Avancée",
      "description": "Maîtrisez Laravel avec notre formation complète de 40h incluant projets pratiques.",
      "price": 299.00,
      "url": "https://uzashop.co/formation/laravel-avance"
    },
    "social_links": {
      "facebook": "https://facebook.com/uzashop",
      "twitter": "https://twitter.com/uzashop",
      "linkedin": "https://linkedin.com/company/uzashop"
    },
    "unsubscribe_link": "https://uzashop.co/unsubscribe?token=abc123",
    "preferences_link": "https://uzashop.co/preferences?token=abc123"
  }
}
```

### 3. Email de Rappel d'Abandon de Panier

```json
{
  "to": "client@example.com",
  "subject": "{{ $customer_name }}, votre panier vous attend 🛒",
  "message": "Vous avez des articles dans votre panier",
  "template_content": "<!DOCTYPE html><html><head><meta charset='utf-8'><style>body{font-family:Arial,sans-serif;margin:0;padding:20px;background:#f5f5f5}.container{max-width:600px;margin:0 auto;background:white;border-radius:10px;overflow:hidden;box-shadow:0 4px 15px rgba(0,0,0,0.1)}.header{background:linear-gradient(45deg,#ff6b6b,#ee5a24);color:white;padding:30px;text-align:center}.header h1{margin:0;font-size:24px}.content{padding:30px}.cart-items{margin:20px 0}.cart-item{display:flex;padding:15px;border:1px solid #eee;border-radius:8px;margin:10px 0;align-items:center}.item-info{flex:1}.item-name{font-weight:bold;color:#333}.item-price{color:#e74c3c;font-size:18px;font-weight:bold}.urgency{background:#fff3cd;border:1px solid #ffeaa7;border-radius:5px;padding:15px;margin:20px 0;text-align:center}.urgency strong{color:#856404}.cta{text-align:center;margin:30px 0}.cta-button{display:inline-block;background:#00b894;color:white;padding:15px 40px;text-decoration:none;border-radius:25px;font-size:16px;font-weight:bold}.incentive{background:#e8f5e8;border:1px solid #00b894;border-radius:8px;padding:20px;margin:20px 0;text-align:center}.savings{color:#00b894;font-size:20px;font-weight:bold}</style></head><body><div class='container'><div class='header'><h1>🛒 {{ $customer_name }}, votre panier vous attend !</h1><p>Vous avez laissé {{ count($cart_items) }} article(s) dans votre panier</p></div><div class='content'><p>Bonjour {{ $customer_name }},</p><p>Vous avez commencé vos achats sur {{ $store_name }} mais vous n'avez pas finalisé votre commande. Vos articles vous attendent toujours !</p><div class='cart-items'>@foreach($cart_items as $item)<div class='cart-item'><div class='item-info'><div class='item-name'>{{ $item['name'] }}</div><small>{{ $item['description'] }}</small></div><div class='item-price'>{{ number_format($item['price'], 2) }}€</div></div>@endforeach</div><div class='urgency'><strong>⏰ Attention !</strong> Votre panier sera supprimé dans {{ $expiry_hours }} heures. Certains articles sont en quantité limitée.</div>@if($discount_available)<div class='incentive'><h3>🎁 Offre spéciale pour vous !</h3><p>Finalisez votre commande maintenant et bénéficiez de <span class='savings'>{{ $discount_percent }}% de réduction</span></p><p>Code promo : <strong>{{ $discount_code }}</strong></p></div>@endif<div class='cta'><a href='{{ $cart_url }}' class='cta-button'>Finaliser ma commande</a></div><p><strong>Total de votre panier : {{ number_format($cart_total, 2) }}€</strong>@if($discount_available)<br><small>Avec réduction : {{ number_format($cart_total * (100 - $discount_percent) / 100, 2) }}€</small>@endif</p><p>Besoin d'aide ? Notre équipe est là pour vous :<br>📧 {{ $support_email }}<br>📞 {{ $support_phone }}</p><p>Merci de votre confiance,<br>L'équipe {{ $store_name }}</p></div></div></body></html>",
  "template_data": {
    "customer_name": "Lucas Bernard",
    "store_name": "UZASHOP Store",
    "cart_items": [
      {
        "name": "iPhone 15 Pro",
        "description": "256GB, Titane Naturel",
        "price": 1229.00
      },
      {
        "name": "AirPods Pro",
        "description": "Avec étui de charge MagSafe",
        "price": 279.00
      }
    ],
    "cart_total": 1508.00,
    "expiry_hours": 24,
    "discount_available": true,
    "discount_percent": 10,
    "discount_code": "RETOUR10",
    "cart_url": "https://uzashop.co/cart?token=cart123",
    "support_email": "aide@uzashop.co",
    "support_phone": "+33 1 23 45 67 89"
  }
}
```

---

## Bonnes Pratiques

### 1. Sécurité

#### Échappement des Variables
```blade
<!-- ✅ Bon : Variables échappées (sécurisé) -->
<p>Nom : {{ $user_name }}</p>

<!-- ⚠️ Attention : HTML non échappé -->
{!! $trusted_html_content !!}
```

#### Validation des Données
```blade
<!-- ✅ Vérifier l'existence des variables -->
@isset($user)
    <p>Utilisateur : {{ $user['name'] }}</p>
@endisset

<!-- ✅ Valeurs par défaut -->
<p>Status : {{ $status ?? 'Inconnu' }}</p>
```

### 2. Performance

#### Templates Légers
```blade
<!-- ✅ Bon : CSS inline minimal -->
<div style="padding: 20px; background: #f5f5f5;">
    <h1 style="color: #333;">Titre</h1>
</div>

<!-- ❌ Éviter : CSS externe (ne fonctionne pas) -->
<link rel="stylesheet" href="styles.css">
```

#### Optimisation des Boucles
```blade
<!-- ✅ Bon : Vérifier avant boucle -->
@if(!empty($items))
    @foreach($items as $item)
        <p>{{ $item }}</p>
    @endforeach
@else
    <p>Aucun élément</p>
@endif

<!-- ✅ Encore mieux : forelse -->
@forelse($items as $item)
    <p>{{ $item }}</p>
@empty
    <p>Aucun élément</p>
@endforelse
```

### 3. Compatibilité Email

#### Tables pour la Mise en Page
```blade
<!-- ✅ Bon : Tables pour structure -->
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td style="padding: 20px;">
            <h1>{{ $title }}</h1>
        </td>
    </tr>
</table>
```

#### Images
```blade
<!-- ✅ Bon : Images avec alt et dimensions -->
<img src="{{ $product_image }}" 
     alt="{{ $product_name }}" 
     width="200" 
     height="150"
     style="display: block;">
```

### 4. Accessibilité

```blade
<!-- ✅ Attributs alt sur images -->
<img src="{{ $image_url }}" alt="{{ $image_description }}">

<!-- ✅ Texte de contraste suffisant -->
<p style="color: #333; background: #fff;">Texte lisible</p>

<!-- ✅ Liens descriptifs -->
<a href="{{ $product_url }}">Voir le produit {{ $product_name }}</a>
```

---

## Dépannage

### Erreurs Courantes

#### 1. Variable Non Définie
```
Erreur: Undefined variable: $name
```

**Solution :**
```json
// ✅ S'assurer que la variable existe dans template_data
{
  "template_data": {
    "name": "Jean Dupont"
  }
}
```

```blade
<!-- ✅ Ou utiliser une valeur par défaut -->
{{ $name ?? 'Utilisateur' }}
```

#### 2. Erreur de Syntaxe Blade
```
Erreur: syntax error, unexpected 'endforeach'
```

**Solution :**
```blade
<!-- ❌ Erreur : boucle mal fermée -->
@foreach($items as $item)
    <p>{{ $item }}</p>
@endfor

<!-- ✅ Correct -->
@foreach($items as $item)
    <p>{{ $item }}</p>
@endforeach
```

#### 3. Template Trop Volumineux
```
Erreur: Template content too large
```

**Solution :**
- Réduire le CSS inline
- Supprimer les espaces inutiles
- Séparer en plusieurs emails si nécessaire

### Debug et Tests

#### Tester un Template Localement
```php
// Créer un fichier test_template.php
<?php
$templateContent = '<h1>Bonjour {{ $name }}</h1>';
$templateData = ['name' => 'Jean'];

// Simuler l'API call
$response = Http::withToken('YOUR_TOKEN')
    ->post('http://localhost:8000/api/send-email', [
        'to' => 'test@example.com',
        'subject' => 'Test Template',
        'message' => 'Fallback message',
        'template_content' => $templateContent,
        'template_data' => $templateData
    ]);

echo $response->body();
?>
```

#### Vérifier les Logs
```bash
# Voir les logs Laravel
tail -f storage/logs/laravel.log

# Filtrer les erreurs de templates
grep "Template processing failed" storage/logs/laravel.log
```

---

## Ressources Utiles

### Documentation Blade Laravel
- [Blade Templates](https://laravel.com/docs/blade)
- [Blade Directives](https://laravel.com/docs/blade#blade-directives)

### Outils de Test Email
- [Litmus](https://litmus.com) - Test multi-clients
- [Email on Acid](https://www.emailonacid.com) - Validation HTML
- [Can I Email](https://www.caniemail.com) - Compatibilité CSS

### Générateurs de Template
- [MJML](https://mjml.io) - Framework responsive
- [Foundation for Emails](https://get.foundation/emails.html)
- [Email Blueprint](https://email-blueprint.com)

---

**UZASHOP Template Guide** v1.0 - Guide complet des templates email

# Architecture du projet - Bibliothèque IUT Dijon

## Vue d'ensemble

Ce projet suit une architecture **MVC (Modèle-Vue-Contrôleur)** modulaire utilisant la **Programmation Orientée Objet (POO)** en PHP.

## Paradigmes et principes

### Programmation Orientée Objet (POO)

Tous les composants principaux sont implémentés en tant que classes :
- **Encapsulation** : Les propriétés sont privées avec des getters/setters
- **Héritage** : (Peut être étendu pour des besoins futurs)
- **Polymorphisme** : Les méthodes peuvent être redéfinies dans les sous-classes

### Design Patterns

#### 1. Singleton (Database.php)
La classe Database utilise le pattern Singleton pour garantir une seule instance de connexion à la base de données.

```php
$db = Database::getInstance()->getConnection();
```

**Avantages** :
- Une seule connexion réutilisée
- Économie de ressources
- Contrôle centralisé

#### 2. MVC (Model-View-Controller)
Séparation des responsabilités en trois couches :

**Modèles** : Gestion des données et logique métier
- `User.php` : Utilisateurs et authentification
- `Book.php` : Livres et catalogue
- `Loan.php` : Emprunts et retours
- `Category.php` : Catégories de livres

**Vues** : Interface utilisateur (HTML/CSS)
- Templates PHP pour l'affichage
- Pas de logique métier dans les vues
- Utilisation de layouts pour la cohérence

**Contrôleurs** : Logique applicative
- `HomeController.php` : Page d'accueil
- `BookController.php` : Gestion des livres
- `LoanController.php` : Gestion des emprunts
- `AuthController.php` : Authentification

## Structure des couches

### Couche Modèle (Model)

Chaque modèle représente une entité de la base de données et fournit des méthodes CRUD :

```php
class Book {
    // Propriétés privées
    private $id;
    private $titre;
    
    // Méthodes CRUD
    public function create()    // Créer
    public function read($id)   // Lire
    public function update()    // Mettre à jour
    public function delete()    // Supprimer
    
    // Méthodes métier
    public function search($query)
    public function isAvailable()
}
```

### Couche Vue (View)

Templates PHP organisés par fonctionnalité :

```
views/
├── layouts/           # Composants réutilisables
│   ├── header.php     # En-tête commun
│   └── footer.php     # Pied de page commun
├── home/              # Vues de la page d'accueil
├── books/             # Vues des livres
├── loans/             # Vues des emprunts
└── auth/              # Vues d'authentification
```

### Couche Contrôleur (Controller)

Gère les requêtes HTTP et coordonne les modèles et vues :

```php
class BookController {
    public function index() {
        // 1. Récupérer les données (Modèle)
        $book = new Book();
        $books = $book->getAll();
        
        // 2. Préparer les données
        $data = ['books' => $books];
        
        // 3. Afficher la vue
        $this->render('books/index', $data);
    }
}
```

## Flux de données

```
1. Requête HTTP
   ↓
2. Router (public/index.php)
   ↓
3. Contrôleur approprié
   ↓
4. Modèle (accès BDD)
   ↓
5. Vue (affichage)
   ↓
6. Réponse HTTP
```

## Base de données

### Schéma relationnel

```
users (utilisateurs)
├── id (PK)
├── email
├── password (hashé)
├── nom
├── prenom
├── role (admin/bibliothecaire/etudiant)
└── actif

categories (catégories de livres)
├── id (PK)
├── nom
└── description

books (livres)
├── id (PK)
├── isbn
├── titre
├── auteur
├── editeur
├── annee_publication
├── category_id (FK → categories.id)
├── nombre_exemplaires
├── nombre_disponibles
└── description

loans (emprunts)
├── id (PK)
├── user_id (FK → users.id)
├── book_id (FK → books.id)
├── date_emprunt
├── date_retour_prevue
├── date_retour_effective
└── statut (en_cours/retourne/en_retard)

reservations (réservations)
├── id (PK)
├── user_id (FK → users.id)
├── book_id (FK → books.id)
├── date_reservation
└── statut
```

### Relations

- Un utilisateur peut avoir **plusieurs emprunts** (1:N)
- Un livre peut être **emprunté plusieurs fois** (1:N)
- Un livre appartient à **une catégorie** (N:1)

## Sécurité

### Authentification
- Mots de passe hashés avec `password_hash()` (bcrypt)
- Vérification avec `password_verify()`
- Sessions PHP pour maintenir l'état de connexion

### Protection contre les injections SQL
- Utilisation de **requêtes préparées** (PDO)
- Paramètres liés avec `bindParam()`

```php
$stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
$stmt->bindParam(':email', $email);
```

### Protection XSS
- Échappement des sorties avec `htmlspecialchars()`

```php
echo htmlspecialchars($book->getTitre());
```

### Contrôle d'accès
- Vérification des rôles dans les contrôleurs
- Redirection si non autorisé

```php
if (!in_array($_SESSION['user']['role'], ['admin', 'bibliothecaire'])) {
    header('Location: /');
    exit;
}
```

## Extensibilité

### Ajouter un nouveau modèle

1. Créer la table dans la base de données
2. Créer la classe dans `models/`
3. Implémenter les méthodes CRUD
4. Charger le modèle dans `public/index.php`

### Ajouter une nouvelle fonctionnalité

1. Créer le contrôleur dans `controllers/`
2. Créer les vues dans `views/`
3. Ajouter les routes dans `public/index.php`

### Ajouter des middlewares

Possibilité d'ajouter des middlewares pour :
- Logging
- Validation
- Cache
- Compression

## Bonnes pratiques appliquées

✅ **Séparation des responsabilités** (MVC)
✅ **POO avec encapsulation**
✅ **Requêtes préparées** (sécurité)
✅ **Hashage des mots de passe**
✅ **Design Pattern Singleton**
✅ **Code modulaire et réutilisable**
✅ **Nommage cohérent** (français pour le métier)
✅ **Documentation dans le code**

## Améliorations futures possibles

- Système de réservation de livres
- Notifications par email
- API REST pour applications mobiles
- Gestion des amendes pour retards
- Statistiques et rapports
- Recherche avancée avec filtres
- Export de données (PDF, Excel)
- Système de notation et commentaires

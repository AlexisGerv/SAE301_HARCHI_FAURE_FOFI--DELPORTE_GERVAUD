# Guide d'installation - Bibliothèque IUT Dijon

## Prérequis

- PHP 7.4 ou supérieur
- MySQL 5.7 ou supérieur (ou MariaDB)
- Serveur web (Apache, Nginx, ou serveur PHP intégré pour le développement)
- Extension PHP PDO et PDO_MySQL

## Installation

### 1. Cloner le projet

```bash
git clone https://github.com/AlexisGerv/SAE310_Labille.git
cd SAE310_Labille
```

### 2. Configuration de la base de données

#### Créer la base de données

1. Connectez-vous à MySQL :
```bash
mysql -u root -p
```

2. Créez la base de données et importez le schéma :
```sql
source database/schema.sql
```

Ou importez le fichier via phpMyAdmin.

#### Configuration de la connexion

1. Copiez le fichier de configuration :
```bash
cp config/database.example.php config/database.php
```

2. Modifiez `config/database.php` avec vos informations de connexion :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'bibliotheque_iut');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
define('DB_CHARSET', 'utf8mb4');
```

### 3. Configuration de l'application

Modifiez `config/config.php` si nécessaire, notamment la constante `BASE_URL` :
```php
define('BASE_URL', 'http://localhost/SAE310_Labille');
```

### 4. Démarrage du serveur

#### Option 1 : Serveur PHP intégré (développement)

```bash
cd public
php -S localhost:8000
```

Accédez à l'application : `http://localhost:8000`

#### Option 2 : Apache

1. Configurez un VirtualHost pointant vers le dossier `public/`
2. Activez le module `mod_rewrite` si nécessaire

#### Option 3 : Nginx

Configurez le serveur pour pointer vers le dossier `public/` avec index.php comme fichier d'index.

## Compte administrateur par défaut

Un compte administrateur est créé automatiquement lors de l'import du schéma :

- **Email** : admin@iut-dijon.fr
- **Mot de passe** : admin123

⚠️ **Important** : Changez ce mot de passe après la première connexion !

## Structure du projet

```
SAE310_Labille/
├── config/              # Configuration de l'application
│   ├── config.php       # Configuration générale
│   └── database.example.php  # Exemple de configuration BDD
├── models/              # Modèles (classes OOP)
│   ├── Database.php     # Connexion à la base de données
│   ├── User.php         # Gestion des utilisateurs
│   ├── Book.php         # Gestion des livres
│   ├── Loan.php         # Gestion des emprunts
│   └── Category.php     # Gestion des catégories
├── controllers/         # Contrôleurs (logique métier)
│   ├── HomeController.php
│   ├── BookController.php
│   ├── LoanController.php
│   └── AuthController.php
├── views/               # Vues (interface utilisateur)
│   ├── layouts/         # En-tête et pied de page
│   ├── home/            # Pages d'accueil
│   ├── books/           # Pages de livres
│   ├── loans/           # Pages d'emprunts
│   └── auth/            # Pages d'authentification
├── public/              # Fichiers publics
│   ├── css/             # Feuilles de style
│   ├── js/              # Scripts JavaScript
│   ├── images/          # Images
│   └── index.php        # Point d'entrée de l'application
└── database/            # Scripts de base de données
    └── schema.sql       # Schéma de la base de données
```

## Dépannage

### Erreur de connexion à la base de données

Vérifiez que :
- MySQL est démarré
- Les identifiants dans `config/database.php` sont corrects
- La base de données `bibliotheque_iut` existe

### Erreur 404 ou page blanche

Vérifiez que :
- Le serveur web pointe vers le dossier `public/`
- PHP est correctement installé
- Les extensions PDO et PDO_MySQL sont activées

### Problèmes de permissions

```bash
chmod -R 755 .
chmod -R 777 public/images/
```

## Support

Pour toute question ou problème, veuillez créer une issue sur le dépôt GitHub.

# Guide de démarrage rapide - Bibliothèque IUT Dijon

## 🚀 Installation en 5 minutes

### Prérequis
- PHP 7.4+ installé
- MySQL/MariaDB installé
- Terminal/Console

### Étapes

#### 1️⃣ Récupérer le projet
```bash
git clone https://github.com/AlexisGerv/SAE310_Labille.git
cd SAE310_Labille
```

#### 2️⃣ Créer la base de données
```bash
# Se connecter à MySQL
mysql -u root -p

# Dans MySQL, exécuter :
source database/schema.sql;
exit;
```

Ou via phpMyAdmin :
- Importer le fichier `database/schema.sql`

#### 3️⃣ Configurer la connexion
```bash
# Copier le fichier d'exemple
cp config/database.example.php config/database.php

# Éditer avec vos identifiants
nano config/database.php  # ou votre éditeur préféré
```

Modifier ces lignes :
```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'bibliotheque_iut');
define('DB_USER', 'votre_user');     // ← Changer ici
define('DB_PASS', 'votre_password'); // ← Changer ici
```

#### 4️⃣ Lancer le serveur
```bash
cd public
php -S localhost:8000
```

#### 5️⃣ Accéder à l'application
Ouvrir dans le navigateur : **http://localhost:8000**

## 🔑 Premier test

### Se connecter avec le compte admin
- **Email** : `admin@iut-dijon.fr`
- **Mot de passe** : `admin123`

⚠️ **IMPORTANT** : Changez ce mot de passe après la première connexion !

## ✅ Vérification rapide

### Tester les fonctionnalités
1. **Voir le catalogue** : Cliquer sur "Catalogue"
2. **Ajouter un livre** : Cliquer sur "Ajouter un livre" (vous êtes admin)
3. **Créer un compte** : Se déconnecter et créer un nouveau compte étudiant
4. **Emprunter** : Se connecter avec le nouveau compte et emprunter un livre
5. **Retourner** : Aller dans "Mes emprunts" et retourner le livre

## 📁 Structure des fichiers importants

```
SAE310_Labille/
├── public/index.php          ← Point d'entrée (router)
├── config/
│   ├── config.php            ← Config générale
│   └── database.php          ← Config BDD (à créer)
├── models/                   ← Classes métier (OOP)
├── controllers/              ← Logique applicative
├── views/                    ← Templates HTML
└── database/schema.sql       ← Schéma de la BDD
```

## 🐛 Résolution de problèmes

### Erreur : "Connection refused"
```bash
# Vérifier que MySQL est démarré
sudo service mysql start    # Linux
brew services start mysql   # Mac
```

### Erreur : "Access denied"
Vérifiez vos identifiants dans `config/database.php`

### Erreur : "Database not found"
```bash
# Réimporter la base
mysql -u root -p < database/schema.sql
```

### Page blanche
```bash
# Vérifier les erreurs PHP
tail -f /var/log/php_errors.log

# Ou ajouter dans config/config.php :
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📚 Documentation complète

- **README.md** : Vue d'ensemble du projet
- **INSTALLATION.md** : Guide d'installation détaillé
- **ARCHITECTURE.md** : Architecture technique
- **FEATURES.md** : Guide des fonctionnalités
- **PROJECT_SUMMARY.md** : Résumé complet du projet

## 💡 Astuces

### Réinitialiser la base de données
```bash
mysql -u root -p
DROP DATABASE bibliotheque_iut;
source database/schema.sql;
exit;
```

### Ajouter des données de test
Après l'installation, connectez-vous en admin et ajoutez quelques livres via l'interface.

### Changer l'URL de base
Si vous utilisez Apache ou Nginx, modifiez dans `config/config.php` :
```php
define('BASE_URL', 'http://votre-domaine.com');
```

### Activer le mode debug
Dans `public/index.php`, avant le try/catch :
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 🔐 Sécurité

### Changer le mot de passe admin
1. Se connecter en admin
2. Cette fonctionnalité sera ajoutée - pour l'instant :
```sql
mysql -u root -p
USE bibliotheque_iut;
UPDATE users SET password = '$2y$10$NOUVEAU_HASH' WHERE email = 'admin@iut-dijon.fr';
```

Générer un hash :
```php
echo password_hash('nouveau_mdp', PASSWORD_DEFAULT);
```

### Protéger config/database.php
```bash
chmod 600 config/database.php
```

## 🚀 Prochaines étapes

1. ✅ Installer et tester l'application
2. 📖 Lire FEATURES.md pour comprendre toutes les fonctionnalités
3. 🏗️ Lire ARCHITECTURE.md pour comprendre le code
4. 🎨 Personnaliser le CSS dans `public/css/style.css`
5. 🔧 Étendre les fonctionnalités selon vos besoins

## 💻 Développement

### Structure MVC
```
Requête → Router (index.php)
        → Contrôleur (BookController)
        → Modèle (Book.php)
        → Vue (books/index.php)
        → Réponse HTML
```

### Ajouter une nouvelle fonctionnalité

1. **Créer le modèle** : `models/MonModele.php`
2. **Créer le contrôleur** : `controllers/MonController.php`
3. **Créer les vues** : `views/mon_module/`
4. **Ajouter la route** : dans `public/index.php`

## 📞 Besoin d'aide ?

- Consultez la documentation complète
- Vérifiez les fichiers `.md` à la racine
- Créez une issue sur GitHub

---

**Bonne utilisation ! 🎉**

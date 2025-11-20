# Bibliothèque IUT Dijon - SAE310

Refonte complète du site web de la bibliothèque de l'IUT de Dijon. Application web modulaire développée en PHP avec une architecture MVC et programmation orientée objet (POO).

## 📋 Fonctionnalités

### Pour tous les utilisateurs
- 🔍 Recherche de livres par titre, auteur ou ISBN
- 📚 Consultation du catalogue complet
- 👀 Visualisation des détails des livres
- 📊 Consultation des catégories

### Pour les utilisateurs connectés
- 📖 Emprunt de livres disponibles
- 📋 Consultation de l'historique des emprunts
- ⏰ Suivi des dates de retour
- 🔄 Retour de livres empruntés

### Pour les administrateurs et bibliothécaires
- ➕ Ajout de nouveaux livres
- 📝 Gestion du catalogue
- 👥 Visualisation de tous les emprunts
- 🔐 Gestion complète de la bibliothèque

## 🛠️ Technologies utilisées

- **Backend** : PHP 7.4+ avec POO
- **Base de données** : MySQL/MariaDB
- **Frontend** : HTML5, CSS3
- **Architecture** : MVC (Modèle-Vue-Contrôleur)
- **Sécurité** : PDO (requêtes préparées), password hashing

## 📁 Structure du projet

```
SAE310_Labille/
├── config/              # Configuration (BDD, application)
├── models/              # Modèles OOP (User, Book, Loan, Category)
├── controllers/         # Contrôleurs (logique métier)
├── views/               # Vues (templates HTML/PHP)
├── public/              # Fichiers publics (CSS, JS, images)
├── database/            # Schéma SQL
└── docs/                # Documentation
```

## 🚀 Installation

Consultez le fichier [INSTALLATION.md](INSTALLATION.md) pour les instructions détaillées.

### Installation rapide

1. Cloner le projet
```bash
git clone https://github.com/AlexisGerv/SAE310_Labille.git
cd SAE310_Labille
```

2. Importer la base de données
```bash
mysql -u root -p < database/schema.sql
```

3. Configurer la connexion
```bash
cp config/database.example.php config/database.php
# Éditer config/database.php avec vos identifiants
```

4. Démarrer le serveur
```bash
cd public
php -S localhost:8000
```

## 🔑 Compte par défaut

- **Email** : admin@iut-dijon.fr
- **Mot de passe** : admin123

⚠️ Changez ce mot de passe après la première connexion !

## 📖 Architecture

Ce projet utilise :
- **Pattern MVC** pour la séparation des responsabilités
- **Pattern Singleton** pour la connexion à la base de données
- **POO** avec encapsulation et modularité
- **Requêtes préparées** pour la sécurité

Consultez [ARCHITECTURE.md](ARCHITECTURE.md) pour plus de détails.

## 🔒 Sécurité

- ✅ Mots de passe hashés (bcrypt)
- ✅ Protection contre les injections SQL (PDO)
- ✅ Protection XSS (htmlspecialchars)
- ✅ Gestion des sessions
- ✅ Contrôle d'accès par rôles

## 👥 Rôles utilisateurs

- **Étudiant** : Emprunter et retourner des livres
- **Bibliothécaire** : Gérer le catalogue et les emprunts
- **Administrateur** : Accès complet au système

## 📚 Modèles disponibles

- `User` : Gestion des utilisateurs et authentification
- `Book` : Gestion des livres et du catalogue
- `Loan` : Gestion des emprunts et retours
- `Category` : Gestion des catégories de livres
- `Database` : Connexion singleton à la base de données

## 🎨 Interface

Interface responsive et moderne avec :
- Design épuré et intuitif
- Grilles adaptatives pour les livres
- Recherche en temps réel
- Messages de feedback utilisateur
- Thème violet/bleu pour l'IUT

## 🔄 Workflow d'emprunt

1. L'utilisateur recherche un livre
2. Consulte les détails et la disponibilité
3. Emprunte le livre (durée : 2 semaines)
4. Le système décrémente le nombre disponible
5. L'utilisateur peut retourner le livre
6. Le système incrémente le nombre disponible

## 📝 Base de données

5 tables principales :
- `users` : Utilisateurs du système
- `categories` : Catégories de livres
- `books` : Catalogue des livres
- `loans` : Historique des emprunts
- `reservations` : Système de réservation (future implémentation)

## 🚧 Améliorations futures

- [ ] Système de réservation complet
- [ ] Notifications par email
- [ ] API REST
- [ ] Gestion des amendes
- [ ] Statistiques et rapports
- [ ] Export de données
- [ ] Système de notation

## 👨‍💻 Auteur

Projet SAE310 - IUT Dijon

## 📄 Licence

Ce projet est développé dans le cadre académique pour l'IUT de Dijon.

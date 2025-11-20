# Guide des fonctionnalités - Bibliothèque IUT Dijon

## 🏠 Page d'accueil

La page d'accueil propose :
- Un message de bienvenue
- Une barre de recherche pour trouver rapidement des livres
- Les catégories disponibles (Informatique, Mathématiques, Sciences, etc.)
- Les 6 livres les plus récents du catalogue

**Accès** : `http://localhost:8000/` ou `http://localhost:8000/public/index.php`

## 📚 Catalogue de livres

### Liste des livres (`?page=books`)
- Affichage de tous les livres sous forme de grille
- Pour chaque livre :
  - Image de couverture (si disponible)
  - Titre
  - Auteur
  - Catégorie
  - Année de publication
  - Disponibilité (nombre d'exemplaires disponibles)
  - Bouton "Voir détails"

### Détails d'un livre (`?page=book&id=X`)
- Informations complètes :
  - Image agrandie
  - ISBN
  - Éditeur
  - Description
  - Disponibilité détaillée
- Actions possibles :
  - Emprunter le livre (si connecté et disponible)
  - Retour au catalogue

### Recherche (`?page=books&action=search&q=...`)
- Recherche par :
  - Titre du livre
  - Nom de l'auteur
  - ISBN
- Affichage du nombre de résultats
- Résultats présentés comme le catalogue

## 🔐 Authentification

### Connexion (`?page=login`)
- Formulaire avec email et mot de passe
- Message d'erreur si identifiants incorrects
- Redirection vers la page d'accueil après connexion

### Inscription (`?page=register`)
- Formulaire d'inscription avec :
  - Nom et prénom
  - Email (unique)
  - Mot de passe (minimum 6 caractères)
  - Confirmation du mot de passe
- Création automatique d'un compte "étudiant"
- Connexion automatique après inscription

### Déconnexion (`?page=logout`)
- Destruction de la session
- Redirection vers la page d'accueil

## 📖 Gestion des emprunts

### Mes emprunts (`?page=loans`)

**Pour les étudiants :**
- Liste de leurs propres emprunts
- Informations affichées :
  - Titre et auteur du livre
  - Date d'emprunt
  - Date de retour prévue
  - Statut (En cours / Retourné / En retard)
  - Bouton "Retourner" pour les emprunts en cours

**Pour les bibliothécaires et admins :**
- Liste de TOUS les emprunts de la bibliothèque
- Informations supplémentaires :
  - Nom de l'emprunteur
  - Email de contact
- Gestion complète des retours

### Emprunter un livre (`?page=loan&action=create&book_id=X`)
- Disponible uniquement pour les utilisateurs connectés
- Vérifie la disponibilité du livre
- Crée l'emprunt avec :
  - Durée : 2 semaines
  - Statut : "en cours"
  - Décrémente le nombre d'exemplaires disponibles

### Retourner un livre (`?page=loan&action=return&loan_id=X`)
- Accessible au propriétaire de l'emprunt ou aux admins/bibliothécaires
- Marque l'emprunt comme "retourné"
- Enregistre la date de retour effective
- Incrémente le nombre d'exemplaires disponibles

## 👨‍💼 Gestion administrative

### Ajouter un livre (`?page=books&action=create`)

**Accès réservé** : Administrateurs et bibliothécaires uniquement

Formulaire pour ajouter un nouveau livre :
- ISBN (optionnel mais recommandé)
- Titre (obligatoire)
- Auteur (obligatoire)
- Éditeur
- Année de publication
- Catégorie (liste déroulante)
- Nombre d'exemplaires (obligatoire)
- Description

Le système initialise automatiquement le nombre d'exemplaires disponibles.

## 🎯 Rôles et permissions

### Étudiant
✅ Voir le catalogue
✅ Rechercher des livres
✅ Emprunter des livres
✅ Voir ses propres emprunts
✅ Retourner ses livres
❌ Ajouter/modifier/supprimer des livres
❌ Voir les emprunts des autres

### Bibliothécaire
✅ Toutes les permissions des étudiants
✅ Ajouter des livres au catalogue
✅ Voir tous les emprunts
✅ Gérer les retours de tous les utilisateurs

### Administrateur
✅ Toutes les permissions
✅ Gestion complète du système

## 🔔 Indicateurs visuels

### États des livres
- 🟢 **Disponible** : Couleur verte, nombre d'exemplaires affiché
- 🔴 **Non disponible** : Couleur rouge, tous les exemplaires empruntés

### États des emprunts
- 🔵 **En cours** : Emprunt actif
- 🟢 **Retourné** : Livre rendu
- 🔴 **En retard** : Date de retour dépassée (ligne surlignée en rouge)

### Messages système
- ✅ **Succès** : Fond vert pour les actions réussies
- ❌ **Erreur** : Fond rouge pour les erreurs

## 🔄 Flux d'utilisation typique

### Étudiant cherchant un livre

1. **Recherche**
   - Accède à la page d'accueil
   - Utilise la barre de recherche
   - Ou navigue dans le catalogue complet

2. **Consultation**
   - Clique sur "Voir détails"
   - Vérifie la disponibilité
   - Lit la description

3. **Emprunt**
   - Se connecte (si pas déjà connecté)
   - Clique sur "Emprunter ce livre"
   - Confirme l'emprunt

4. **Suivi**
   - Va dans "Mes emprunts"
   - Vérifie les dates de retour
   - Retourne le livre en temps voulu

### Bibliothécaire ajoutant un livre

1. **Connexion**
   - Se connecte avec son compte bibliothécaire/admin

2. **Ajout**
   - Clique sur "Ajouter un livre" dans le menu
   - Remplit le formulaire complet
   - Sélectionne la catégorie appropriée
   - Soumet le formulaire

3. **Vérification**
   - Le livre apparaît dans le catalogue
   - Disponible immédiatement pour emprunt

## 📊 Pages disponibles

| URL | Page | Accès |
|-----|------|-------|
| `/` ou `/?page=home` | Accueil | Public |
| `/?page=books` | Catalogue | Public |
| `/?page=book&id=X` | Détails livre | Public |
| `/?page=books&action=search&q=...` | Recherche | Public |
| `/?page=login` | Connexion | Public |
| `/?page=register` | Inscription | Public |
| `/?page=loans` | Mes emprunts | Connecté |
| `/?page=loan&action=create&book_id=X` | Emprunter | Connecté |
| `/?page=loan&action=return&loan_id=X` | Retourner | Connecté |
| `/?page=books&action=create` | Ajouter livre | Admin/Biblio |
| `/?page=logout` | Déconnexion | Connecté |

## 💡 Conseils d'utilisation

1. **Première connexion** : Utilisez le compte admin pour tester toutes les fonctionnalités
2. **Données de test** : Le schéma SQL inclut des catégories prédéfinies
3. **Ajout de livres** : Ajoutez quelques livres de test avant de tester les emprunts
4. **Test complet** : Créez plusieurs comptes utilisateurs pour tester les différents rôles
5. **Recherche** : La recherche fonctionne sur titre, auteur et ISBN simultanément

## 🚀 Prochaines fonctionnalités

Les fonctionnalités suivantes pourraient être ajoutées :
- Système de réservation pour les livres non disponibles
- Notifications par email (rappels de retour)
- Historique complet des emprunts passés
- Statistiques pour les administrateurs
- Gestion des amendes pour retards
- Upload d'images de couverture
- Export de données (PDF, Excel)
- Système de notation et avis

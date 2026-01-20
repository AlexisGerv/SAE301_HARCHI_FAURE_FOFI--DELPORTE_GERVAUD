<?php
// controleurs/emprunt.php

/**
 * Contrôleur de gestion des emprunts.
 * 
 * Ce script gère :
 * 1. La vérification que l'utilisateur est connecté.
 * 2. La vérification qu'il a le droit d'emprunter.
 * 3. La création de l'emprunt en base de données.
 * 4. La mise à jour du stock du livre.
 */

require_once __DIR__ . '/../autoload.php';
// Démarrage de la session pour accéder à $_SESSION['user']
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';

// ------------------------------------------------------------------
// 1. Vérification de l'authentification
// ------------------------------------------------------------------
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php?page=connexion');
    exit();
}

$user = $_SESSION['user'];

// ------------------------------------------------------------------
// 2. Vérification des droits d'emprunt
// ------------------------------------------------------------------
if (!$user->getPeutEmprunter()) {
    die("Vous n'avez pas le droit d'emprunter.");
}

// ------------------------------------------------------------------
// 3. Traitement de la demande d'emprunt
// ------------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['livre_id'])) {
    $livreId = (int) $_POST['livre_id'];
    $managerLivre = new ManagerLivre($bdd);
    $livre = $managerLivre->getOne($livreId);

    // Vérifie si le livre existe et s'il reste des exemplaires
    if ($livre && $livre->getNbExemplairesDisponible() > 0) {
        $managerEmprunt = new ManagerEmprunt($bdd);

        // Définition des dates : Aujourd'hui et +21 jours
        $dateEmprunt = new DateTime();
        $dateRetour = new DateTime('+21 days'); // Durée par défaut

        $donnees = [
            'utilisateur_id' => $user->getUserId(),
            'livre_id' => $livreId,
            'date_emprunt' => $dateEmprunt,
            'date_retour_prevue' => $dateRetour,
            'est_en_retard' => false,
            'nombre_prolongations' => 0
        ];

        /*
         * Note : Les champs 'nom_emprunteur' et 'titre_livre' ne sont pas stockés 
         * dans la table Emprunt, ils sont récupérés via des JOIN dans ManagerEmprunt::getAll().
         */
        $emprunt = new Emprunt($donnees);

        // Enregistrement de l'emprunt
        $managerEmprunt->add($emprunt);

        // --------------------------------------------------------------
        // 4. Mise à jour du stock
        // --------------------------------------------------------------
        $livre->setNbExemplairesDisponible($livre->getNbExemplairesDisponible() - 1);

        // Si le stock atteint 0, on passe le statut à "Indisponible"
        if ($livre->getNbExemplairesDisponible() === 0) {
            $livre->setEstDisponible(false);
        }
        $managerLivre->update($livre);

        // Redirection avec succès (affichera le popup JS)
        header("Location: ../index.php?page=livre&id=$livreId&success=1");
        exit();

    } else {
        // Redirection erreur (livre indisponible)
        header("Location: ../index.php?page=livre&id=$livreId&error=unavailable");
        exit();
    }
} else {
    // Redirection si accès direct
    header('Location: ../index.php');
    exit();
}

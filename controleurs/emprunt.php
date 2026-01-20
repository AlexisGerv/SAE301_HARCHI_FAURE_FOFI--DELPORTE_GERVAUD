<?php
// controleurs/emprunt.php

require_once __DIR__ . '/../autoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';

// Access Control
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php?page=connexion');
    exit();
}

$user = $_SESSION['user'];

// Check borrowing rights
if (!$user->getPeutEmprunter()) {
    die("Vous n'avez pas le droit d'emprunter.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['livre_id'])) {
    $livreId = (int) $_POST['livre_id'];
    $managerLivre = new ManagerLivre($bdd);
    $livre = $managerLivre->getOne($livreId);

    if ($livre && $livre->getNbExemplairesDisponible() > 0) {
        $managerEmprunt = new ManagerEmprunt($bdd);

        // Date logic
        $dateEmprunt = new DateTime();
        $dateRetour = new DateTime('+21 days'); // 3 weeks default

        $donnees = [
            'utilisateur_id' => $user->getUserId(),
            'livre_id' => $livreId,
            'date_emprunt' => $dateEmprunt,
            'date_retour_prevue' => $dateRetour,
            'est_en_retard' => false,
            'nombre_prolongations' => 0
        ];

        $emprunt = new Emprunt($donnees);

        // Optional: pre-fill denormalized data if needed by ManagerEmprunt logic, 
        // though ManagerEmprunt->add() seems to fetch it if missing.
        $emprunt->setNomEmprunteur($user->getNom());
        $emprunt->setPrenomEmprunteur($user->getPrenom());
        $emprunt->setTitreLivre($livre->getTitre());

        $managerEmprunt->add($emprunt);

        // Decrease stock
        $livre->setNbExemplairesDisponible($livre->getNbExemplairesDisponible() - 1);
        if ($livre->getNbExemplairesDisponible() === 0) {
            $livre->setEstDisponible(false);
        }
        $managerLivre->update($livre);

        // Redirect with success
        header("Location: ../controleurs/livre.php?id=$livreId&success=1");
        exit();

    } else {
        // Book not available or doesn't exist
        header("Location: ../controleurs/livre.php?id=$livreId&error=unavailable");
        exit();
    }
} else {
    // Invalid request
    header('Location: ../index.php');
    exit();
}

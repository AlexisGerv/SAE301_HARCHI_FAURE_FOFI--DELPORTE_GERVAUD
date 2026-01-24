<?php
// controleurs/reserver.php

require_once __DIR__ . '/../autoload.php';
// Initialisation session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';

// 1. Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php?page=connexion');
    exit();
}

$user = $_SESSION['user'];

// 2. Vérifie les droits d'emprunt
if (!$user->getPeutEmprunter()) {
    die("Vous n'avez pas le droit d'emprunter/réserver.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['livre_id'])) {
    $livreId = (int) $_POST['livre_id'];
    $managerReservation = new ManagerReservation($bdd);
    $managerLivre = new ManagerLivre($bdd);
    $livre = $managerLivre->getOne($livreId);

    if ($livre) {
        // Vérifie si l'utilisateur a déjà réservé ce livre
        if ($managerReservation->userHasReserved($user->getUserId(), $livreId)) {
            header("Location: ../index.php?page=livre&id=$livreId&error=already_reserved");
            exit();
        }

        // Création de la réservation
        $reservation = new Reservation([
            'utilisateur_id' => $user->getUserId(),
            'livre_id' => $livreId,
            'date_demande' => new DateTime()
        ]);

        $managerReservation->add($reservation);

        // Redirection succès
        header("Location: ../index.php?page=livre&id=$livreId&success_reservation=1");
        exit();

    } else {
        // Livre s'il n'existe pas
        header("Location: ../index.php");
        exit();
    }
} else {
    // Accès direct interdit
    header("Location: ../index.php");
    exit();
}

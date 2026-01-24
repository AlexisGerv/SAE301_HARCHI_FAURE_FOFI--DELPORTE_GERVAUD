<?php
// controleurs/profil.php

require_once __DIR__ . '/../autoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';

// Vérification de connexion
if (!isset($_SESSION['user'])) {
    header('Location: ../index.php?page=connexion');
    exit();
}

$user = $_SESSION['user'];
$userId = $user->getUserId();

$managerReservation = new ManagerReservation($bdd);
$managerEmprunt = new ManagerEmprunt($bdd);
$managerHistorique = new ManagerHistorique($bdd);

// Récupération des données
$reservations = $managerReservation->getAllByUser($userId);


$emprunts = $managerEmprunt->getAllByEtudiant($userId);
$historique = $managerHistorique->getAllByUser($userId);

include __DIR__ . '/../vue/VueProfil.php';

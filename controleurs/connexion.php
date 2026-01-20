<?php
session_start();
require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../modeles/connect.php';
require_once __DIR__ . '/../modeles/connexion.php'; 

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    
    // On appelle la fonction du modèle
    $user = tenterConnexion($bdd, $_POST['email'], $_POST['password']);

    if ($user) {
        // Succès : On stocke l'utilisateur en session
        $_SESSION['user'] = $user;
        header('Location: ../index.php'); // Retour à l'accueil connecté
        exit();
    } else {
        // Échec : Retour au formulaire avec une erreur
        header('Location: ../index.php?page=connexion&error=1');
        exit();
    }
}
<?php
/**
 * Contrôleur gérant la soumission du formulaire de connexion.
 * 
 * Ce script :
 * 1. Reçoit les données POST (email, password).
 * 2. Appelle la fonction de vérification (dans le modèle procedural ou Manager).
 * 3. Initialise la session utilisateur en cas de succès.
 * 4. Redirige vers l'accueil ou renvoie vers le formulaire avec une erreur.
 */

require_once __DIR__ . '/../autoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';
// Note: Le modèle procédural est inclus ici, mais on pourrait utiliser ManagerUtilisateur
require_once __DIR__ . '/../modeles/connexion.php';

if (!empty($_POST['email']) && !empty($_POST['password'])) {

    // Tentative de connexion via le modèle
    $user = tenterConnexion($bdd, $_POST['email'], $_POST['password']);

    if ($user) {
        // Succès : Stockage de l'objet utilisateur en session
        $_SESSION['user'] = $user;
        header('Location: ../index.php'); // Redirection vers l'accueil
        exit();
    } else {
        // Échec : Redirection avec flag d'erreur
        header('Location: ../index.php?page=connexion&error=1');
        exit();
    }
} else {
    // Si accès direct sans POST ou champs vides
    header('Location: ../index.php?page=connexion');
    exit();
}
<?php
/**
 * Contrôleur gérant la déconnexion.
 * 
 * Ce script :
 * 1. Démarre la session (si pas déjà fait).
 * 2. Détruit toutes les données de session ($_SESSION).
 * 3. Redirige vers l'accueil.
 */

session_start();
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session active

header('location: ../index.php');
exit();
?>
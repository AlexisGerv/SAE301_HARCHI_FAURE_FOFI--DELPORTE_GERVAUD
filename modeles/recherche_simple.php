<?php
require_once("./modeles/connect.php");

// 2. Gestion de la saisie utilisateur
// On récupère 'q' depuis le formulaire du header (VueHeader.php)
$recherche = isset($_POST['recherche']) ? trim(htmlspecialchars($_POST['recherche'])) : '';

// On initialise le tableau pour éviter les erreurs si aucune recherche n'est faite
$resultats = [];

// 3. Traitement de la recherche simple
if (!empty($recherche)) {
    // Préparation de la requête SQL (Basée sur ton fichier bibliotheque.sql)
    // On cherche dans 'titre' ou '_resume'
    $sql = "SELECT * FROM Livre WHERE titre LIKE :mot OR _resume LIKE :mot";
    $stmt = $pdo->prepare($sql);
    
    // Exécution avec les jokers % pour trouver le mot n'importe où
    $stmt->execute(['mot' => '%' . $recherche . '%']);
    
    // Récupération des données sous forme de tableau associatif
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
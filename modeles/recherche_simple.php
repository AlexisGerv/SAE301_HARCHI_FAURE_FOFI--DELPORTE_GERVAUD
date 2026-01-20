<?php
/**
 * Modèle de recherche simple.
 * Effectue la requête SQL de recherche sur les titres et résumés.
 * 
 * Variables attendues :
 * - $bdd : Instance PDO
 * - $recherche : Terme de recherche
 */

// La variable $bdd est déjà disponible car ce fichier est inclus via index.php
$sql = "SELECT * FROM livre WHERE titre LIKE :mot OR _resume LIKE :mot";
$stmt = $bdd->prepare($sql);

// Exécution avec les jokers %
$stmt->execute(['mot' => '%' . $recherche . '%']);

// On remplit le tableau de résultats que la VueAccueil va parcourir
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
<?php
// modeles/recherche_simple.php

// La variable $bdd est déjà disponible car ce fichier est inclus via index.php
$sql = "SELECT * FROM livre WHERE titre LIKE :mot OR _resume LIKE :mot";
$stmt = $bdd->prepare($sql);

// Exécution avec les jokers %
$stmt->execute(['mot' => '%' . $recherche . '%']);

// On remplit le tableau de résultats que la VueAccueil va parcourir
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
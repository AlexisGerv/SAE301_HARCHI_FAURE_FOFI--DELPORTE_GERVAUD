<?php
// modeles/recherche_simple.php

// On prépare la variable avec les wildcards pour le LIKE SQL
$searchParam = "%" . $recherche . "%";

// Requête simple qui cherche dans le titre
$sql = "SELECT * FROM livre WHERE titre LIKE :recherche";
$stmt = $bdd->prepare($sql);

// On lie EXACTEMENT le paramètre attendu (:recherche)
$stmt->execute([
    'recherche' => $searchParam
]);

// On récupère les résultats sous forme d'objets Livre
$resultats = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $resultats[] = new Livre($row);
}
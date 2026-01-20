<?php
// controleurs/recherche.php

// Vérifications plus poussées (ex: longueur minimale)
if (strlen($recherche) < 2) {
    // Optionnel : définir un message d'erreur à afficher dans la vue
    $erreur = "Le terme de recherche doit faire au moins 2 caractères.";
} else {
    // Si tout est bon, on appelle le modèle pour exécuter la requête SQL
    require_once './modeles/recherche_simple.php';
}
<?php
// controleurs/recherche.php
require_once('./modeles/recherche_simple.php') ;
// On vérifie que le mot fait au moins 2 caractères pour éviter les recherches trop larges
if (strlen($recherche) < 2) {
    $erreur = "Le terme de recherche est trop court.";
} else {
    // Si c'est bon, on appelle le modèle (chemin relatif à index.php)
    require_once './modeles/recherche_simple.php';
}
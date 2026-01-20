<?php
// controleurs/recherche.php

/**
 * Contrôleur de recherche simple.
 * 
 * Ce script :
 * 1. Vérifie la longueur du terme de recherche.
 * 2. Si valide, appelle le modèle de recherche (qui doit retourner $resultats).
 */

// On vérifie que le mot fait au moins 2 caractères pour éviter les recherches trop larges
if (strlen($recherche) < 2) {
    $erreur = "Le terme de recherche est trop court.";
} else {
    // Si c'est bon, on appelle le modèle (chemin relatif à index.php)
    require_once './modeles/recherche_simple.php';
}
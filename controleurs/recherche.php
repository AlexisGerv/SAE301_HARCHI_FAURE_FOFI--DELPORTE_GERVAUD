<?php
// On récupère la saisie utilisateur depuis le formulaire du header 
// trim() enlève les espaces inutiles, htmlspecialchars() protège des scripts malveillants
$recherche = isset($_GET['recherche']) ? trim(htmlspecialchars($_GET['recherche'])) : '';

// On initialise un tableau de résultats vide
$resultats = [];

// On ne lance la recherche que si l'utilisateur a tapé quelque chose
if (!empty($recherche)) {
    // On appelle le modèle pour chercher les données (Recherche simple)
    // $livreManager est l'instance de ta classe de gestion de BDD
    $resultats = $livreManager->rechercherSimple($recherche);
}
?>


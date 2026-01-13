<?php
// 1. On inclut d'abord le fichier de la classe (Le Modèle)
require_once('../class/LivreManager.class.php'); 
require_once('../class/Livre.class.php'); 


// 2. Ensuite, on peut créer l'objet et gérer la saisie
$manager = new LivreManager($pdo); 

$recherche = isset($_GET['recherche']) ? trim(htmlspecialchars($_GET['recherche'])) : '';

if (!empty($recherche)) {
    // Utilisation de la méthode du modèle
    $resultats = $manager->rechercherSimple($recherche);
}
?>
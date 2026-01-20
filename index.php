<?php
// index.php
require_once './autoload.php';
require_once './modeles/connect.php'; // Définit la variable $bdd

// 1. Récupération et nettoyage simple
$recherche = isset($_POST['recherche']) ? trim(htmlspecialchars($_POST['recherche'])) : '';

// 2. Initialisation du tableau de résultats pour la vue
$resultats = [];

// 3. Appel du contrôleur si une recherche est lancée
if (!empty($recherche)) {
    require_once './controleurs/recherche.php';
}

// 4. Affichage des vues
include './vue/VueHeader.php';
?>

<main id="content">
    <?php include './vue/VueAccueil.php'; ?>
</main>

<?php 
include './vue/VueFooter.php'; 
?>
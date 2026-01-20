<?php
// index.php à la racine
require_once './autoload.php';
require_once './modeles/connect.php'; // Définit $bdd

// 1. Récupération de la recherche (on utilise POST car ton formulaire est en POST)
$recherche = isset($_POST['recherche']) ? trim(htmlspecialchars($_POST['recherche'])) : '';

// 2. Initialisation pour la VueAccueil.php
$resultats = [];

// 3. Si une recherche est faite, on passe par le contrôleur dédié
if (!empty($recherche)) {
    require_once './controleurs/recherche.php';
}

// 4. Affichage de la structure
include './vue/VueHeader.php';
?>

<main id="content">
    <?php include './vue/VueAccueil.php'; ?>
</main>

<?php include './vue/VueFooter.php'; ?>
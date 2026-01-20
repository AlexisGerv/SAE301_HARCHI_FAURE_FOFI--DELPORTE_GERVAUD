<?php
require_once './autoload.php';
require_once './modeles/connect.php';
session_start();

// On récupère la page demandée (par défaut 'accueil')
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

$recherche = isset($_POST['recherche']) ? trim(htmlspecialchars($_POST['recherche'])) : '';

// 2. Initialisation pour la VueAccueil.php
$resultats = [];

// 3. Si une recherche est faite, on passe par le contrôleur dédié
if (!empty($recherche)) {
    require_once './controleurs/recherche.php';
}

include './vue/VueHeader.php';

?>

<main id="content">
    <?php
    // Le routeur choisit quelle vue afficher au milieu du "sandwich"
    switch ($page) {
        case 'connexion':
            include './vue/VueConnexion.php';
            break;
        case 'livre':
            include './vue/VueLivre.php';
            break;
        default:
            include './vue/VueAccueil.php';
            break;
    }
    ?>
</main>

<?php
include './vue/VueFooter.php';
?>
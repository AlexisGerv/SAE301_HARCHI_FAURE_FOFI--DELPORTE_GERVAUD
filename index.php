<?php
session_start(); 
require_once './autoload.php';
require_once './modeles/connect.php';

// On récupère la page demandée (par défaut 'accueil')
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

include './vue/VueHeader.php';
?>

<main id="content">
    <?php 
    // Le routeur choisit quelle vue afficher au milieu du "sandwich"
    switch($page) {
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
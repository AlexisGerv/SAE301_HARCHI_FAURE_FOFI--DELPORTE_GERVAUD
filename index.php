<?php
/**
 * Point d'entrée principal de l'application (Routeur).
 * 
 * Ce fichier se charge de :
 * 1. Initialiser l'environnement (autoload, session, BDD).
 * 2. Définir des variables globales (comme $rootPath).
 * 3. Gérer le routage via le paramètre GET 'page'.
 * 4. Inclure les éléments communs (Header, Footer).
 */

require_once './autoload.php';
require_once './modeles/connect.php';
session_start();

// Chemin racine pour les inclusions et liens (utile pour les vues incluses)
$rootPath = './';

// Récupération de la page demandée, par défaut 'accueil'
$page = isset($_GET['page']) ? $_GET['page'] : 'accueil';

// Gestion de la recherche (accessible depuis le header)
$recherche = isset($_POST['recherche']) ? trim(htmlspecialchars($_POST['recherche'])) : '';

// Initialisation des variables pour la vue Accueil
$resultats = [];
$nouveautes = [];

if (!empty($recherche)) {
    // Si une recherche est effectuée, on charge le contrôleur de recherche
    require_once './controleurs/recherche.php';
} else {
    // Sinon, on charge les "nouveautés" (tous les livres pour l'instant) pour l'accueil
    $managerLivre = new ManagerLivre($bdd);
    $nouveautes = $managerLivre->getAll();
}

// Inclusion de l'en-tête commun
include './vue/VueHeader.php';

?>

<main id="content">
    <?php
    // Routage : Inclusion du contrôleur ou de la vue correspondante
    switch ($page) {
        case 'connexion':
            include './vue/VueConnexion.php';
            break;

        case 'livre':
            // Logique pour récupérer le détail d'un livre
            if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                $id = (int) $_GET['id'];
                $managerLivre = new ManagerLivre($bdd);
                $livre = $managerLivre->getOne($id);
                if (!$livre) {
                    $error = "Le livre demandé n'existe pas.";
                }
            } else {
                $error = "Identifiant de livre non spécifié.";
            }
            include './vue/VueLivre.php';
            break;

        case 'admin':
            include './controleurs/admin.php'; // Tableau de bord admin
            break;
        case 'settings':
            include './vue/VueSettings.php';
            break;
        case 'profil':
            include './controleurs/profil.php';
            break;
        case 'contact':
            include './vue/VueContact.php';
            break;
        case 'panier':
            include './vue/VuePanier.php';
            break;
        default:
            include './vue/VueAccueil.php'; // Page par défaut
            break;
    }
    ?>
</main>

<?php
// Inclusion du pied de page commun
include './vue/VueFooter.php';
?>
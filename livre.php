<?php
/**
 * Contrôleur de la page de détail d'un livre
 */

require_once 'autoload.php';
require_once './modeles/connect.php';

$titrePage = "Détail du livre";
$livre = null;
$error = null;

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

// Inclusion des vues
include 'vue/VueHeader.php';
include 'vue/VueLivre.php';
include 'vue/VueFooter.php';

<?php
/**
 * Contrôleur de la page de détail d'un livre (Accès direct).
 * 
 * Note : Ce fichier semble être un point d'entrée alternatif ou hérité.
 * Normalement, l'accès se fait via index.php?page=livre qui charge VueLivre.php.
 * Si utilisé directement, ce script charge le header, la vue détail et le footer.
 */

require_once __DIR__ . '/../autoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';

$rootPath = '../';

$titrePage = "Détail du livre";
$livre = null;
$error = null;

// Validation de l'ID passé en GET
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
include __DIR__ . '/../vue/VueHeader.php';
include __DIR__ . '/../vue/VueLivre.php';
include __DIR__ . '/../vue/VueFooter.php';

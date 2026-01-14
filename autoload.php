<?php
/**
 * Système d'autoload pour charger les classes automatiquement
 * Plus besoin de faire des require partout !
 */
spl_autoload_register(function ($nom_classe) {
    // 1. On définit le chemin vers le dossier "class"
    // __DIR__ permet de toujours partir de l'emplacement de ce fichier
    $dossier_classe = __DIR__ . '/class/';

    // 2. Liste des endroits où chercher les classes
    // On doit lister les sous-dossiers car tes classes sont rangées
    $chemins_possibles = [
        $dossier_classe . $nom_classe . '.class.php',           // Ex: class/Livre.class.php
        $dossier_classe . 'Manager/' . $nom_classe . '.class.php' // Ex: class/Manager/ManagerUser.class.php
    ];

    // 3. On teste chaque chemin
    foreach ($chemins_possibles as $fichier) {
        if (file_exists($fichier)) {
            require_once $fichier;
            return; // On arrête dès qu'on a trouvé
        }
    }
});
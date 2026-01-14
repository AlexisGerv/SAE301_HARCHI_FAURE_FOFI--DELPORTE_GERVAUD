<?php
/**
 * Système d'autoload pour charger les classes automatiquement
 * Plus besoin de faire des require partout !
 */
spl_autoload_register(function ($nom_classe) {
    $dossier_classe = __DIR__ . '/class/';
    $chemins_possibles = [
        $dossier_classe . $nom_classe . '.class.php',           // Ex: class/Livre.class.php
        $dossier_classe . 'Manager/' . $nom_classe . '.class.php' // Ex: class/Manager/ManagerUser.class.php
    ];

    foreach ($chemins_possibles as $fichier) {
        if (file_exists($fichier)) {
            require_once $fichier;
            return;
        }
    }
});
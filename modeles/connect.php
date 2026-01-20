<?php
/**
 * Script d'initialisation de la connexion BDD.
 * Utilise la classe SPDO pour récupérer l'instance PDO unique.
 * Inclus automatiquement par les contrôleurs et managers.
 */

require_once __DIR__ . "/../autoload.php";

try {
    $bdd = SPDO::getInstance()->getPDO();
} catch (Exception $e) {
    die("Erreur système : " . $e->getMessage());
}
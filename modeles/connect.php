<?php

require_once __DIR__ . "/../autoload.php";

try {
    $bdd = SPDO::getInstance()->getPDO();
} catch (Exception $e) {
    echo "Erreur système : " . $e->getMessage();
}
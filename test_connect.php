<?php
try {
    $bdd = new PDO("mysql:host=localhost;dbname=bibliotheque", "root", "");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection SUCCESS";
} catch (PDOException $e) {
    echo "Connection FAILED: " . $e->getMessage();
}

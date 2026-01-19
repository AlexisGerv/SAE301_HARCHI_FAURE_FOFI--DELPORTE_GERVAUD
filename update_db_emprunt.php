<?php
require_once __DIR__ . '/autoload.php';
require_once __DIR__ . '/modeles/connect.php';

try {
    echo "--- Mise à jour de la table Emprunt ---\n";

    // Add columns if they don't exist
    // We'll trust the error if they exist or check schema, but direct ALTER IGNORE or catch is easier for one-off
    // Checking columns first is safer

    $cols = $bdd->query("SHOW COLUMNS FROM Emprunt LIKE 'nom_emprunteur'")->fetch();
    if (!$cols) {
        $bdd->exec("ALTER TABLE Emprunt ADD COLUMN nom_emprunteur VARCHAR(100)");
        echo "[OK] Added nom_emprunteur\n";
    } else {
        echo "[INFO] nom_emprunteur already exists\n";
    }

    $cols = $bdd->query("SHOW COLUMNS FROM Emprunt LIKE 'prenom_emprunteur'")->fetch();
    if (!$cols) {
        $bdd->exec("ALTER TABLE Emprunt ADD COLUMN prenom_emprunteur VARCHAR(100)");
        echo "[OK] Added prenom_emprunteur\n";
    } else {
        echo "[INFO] prenom_emprunteur already exists\n";
    }

    $cols = $bdd->query("SHOW COLUMNS FROM Emprunt LIKE 'titre_livre'")->fetch();
    if (!$cols) {
        $bdd->exec("ALTER TABLE Emprunt ADD COLUMN titre_livre VARCHAR(255)");
        echo "[OK] Added titre_livre\n";
    } else {
        echo "[INFO] titre_livre already exists\n";
    }

    echo "\n[SUCCESS] Database updated.\n";

} catch (PDOException $e) {
    echo "\n[ERROR] " . $e->getMessage() . "\n";
}

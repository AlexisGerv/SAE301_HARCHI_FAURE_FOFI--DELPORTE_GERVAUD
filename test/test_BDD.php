<?php
// Comprehensive Integration Test for Emprunt Flow
// This script will:
// 1. CLEAR the database tables (Emprunt, Livre, Utilisateur)
// 2. Create a User (Etudiant)
// 3. Create a Book (Livre)
// 4. Create an Emprunt linking them
// 5. Verify data retrieval

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../modeles/connect.php'; // Provides $bdd (PDO)

echo "<h1>Test Intégration Système - Emprunt</h1>";
echo "<pre>";

try {
    // 1. CLEAN DATABASE
    echo "--- Nettoyage de la Base de Données ---\n";
    // Delete in order to respect FK constraints (Emprunt depends on User/Livre)
    $bdd->exec("DELETE FROM Emprunt");
    $bdd->exec("DELETE FROM Livre");
    $bdd->exec("DELETE FROM Utilisateur");
    // Reset Auto Increment if possible (optional, but cleaner for tests)
    $bdd->exec("ALTER TABLE Emprunt AUTO_INCREMENT = 1");
    $bdd->exec("ALTER TABLE Livre AUTO_INCREMENT = 1");
    $bdd->exec("ALTER TABLE Utilisateur AUTO_INCREMENT = 1");
    echo "[OK] Tables vidées.\n\n";

    // 2. CREATE USER (Etudiant)
    echo "--- Création d'un Étudiant ---\n";
    $managerUser = new ManagerUtilisateur($bdd);
    $etudiant = new Etudiant([
        'nom' => 'Dupont',
        'prenom' => 'Jean',
        'mail_iut' => 'jean.dupont@mmi.edu',
        'mdp' => 'password123',
        'num_etudiant' => '20230001',
        'formation' => 'MMI',
        'est_admin' => false,
        'peut_emprunter' => true
    ]);

    // Check if ManagerUser uses add/insert and if it handles inheritance correctly
    // Assuming ManagerUtilisateur handles insertion of Utilisateur/Etudiant
    $managerUser->add($etudiant);
    echo "[OK] Étudiant ajouté avec ID: " . $etudiant->getUserId() . "\n\n";

    // 3. CREATE BOOK
    echo "--- Création d'un Livre ---\n";
    $managerLivre = new ManagerLivre($bdd);
    $livre = new Livre([
        'titre' => 'PHP pour les Nuls',
        'auteur' => 'Jean-Pierre',
        'resume' => 'Apprendre le PHP facilement.',
        'isbn' => '978-3-16-148410-0',
        'categorie' => 'Informatique',
        'nb_exemplaires_total' => 5,
        'nb_exemplaires_disponible' => 5,
        'date_publication' => new DateTime('2023-01-01'),
        'est_disponible' => true,
        'format' => 'Broché',
        'editeur' => 'Editions Tech',
        'mots_cles' => ['PHP', 'Web'], // ManagerLivre expect array for implode? Or string? ManagerLivre:31 implode(',', ...), so it expects array.
        'image_couverture' => 'cover.jpg',
        'type_support' => 'Livre',
        '_collection' => 'Collection Pour les Nuls',
        'sudoc' => '123456789',
        'nb_pages' => 300
    ]);
    $managerLivre->add($livre);
    echo "[OK] Livre ajouté avec ID: " . $livre->getId() . "\n\n";

    // 4. CREATE EMPRUNT
    echo "--- Création d'un Emprunt ---\n";
    $managerEmprunt = new ManagerEmprunt($bdd);

    $dateEmprunt = new DateTime();
    $dateRetour = new DateTime('+15 days');

    $emprunt = new Emprunt();
    $emprunt->setEtudiant($etudiant); // Object setter we just added
    $emprunt->setLivre($livre);       // Object setter we just added
    $emprunt->setDateEmprunt($dateEmprunt);
    $emprunt->setDateRetourPrevue($dateRetour);
    $emprunt->setEstEnRetard(false);
    $emprunt->setNombreProlongations(0);

    $managerEmprunt->add($emprunt);
    echo "[OK] Emprunt ajouté avec ID: " . $emprunt->getId() . "\n";
    echo "    - Etudiant ID : " . $emprunt->getEtudiantId() . "\n";
    echo "    - Livre ID    : " . $emprunt->getLivreId() . "\n\n";

    // 5. VERIFY
    echo "--- Vérification Lecture (GetOne) ---\n";
    $empruntRecupere = $managerEmprunt->getOne($emprunt->getId());

    if ($empruntRecupere) {
        echo "[OK] Emprunt récupéré de la BDD.\n";
        if ($empruntRecupere->getEtudiantId() === $etudiant->getUserId()) {
            echo "[PASS] ID Étudiant correspond.\n";
        } else {
            echo "[FAIL] Erreur ID Étudiant: " . $empruntRecupere->getEtudiantId() . " vs " . $etudiant->getUserId() . "\n";
        }

        if ($empruntRecupere->getLivreId() === $livre->getId()) {
            echo "[PASS] ID Livre correspond.\n";
        } else {
            echo "[FAIL] Erreur ID Livre: " . $empruntRecupere->getLivreId() . " vs " . $livre->getId() . "\n";
        }
    } else {
        echo "[FAIL] Emprunt non trouvé en BDD.\n";
    }

    if ($empruntRecupere) {
        echo "\n--- Vérification des données dénormalisées ---\n";
        echo "Nom emprunteur (Attendu: Dupont): " . $empruntRecupere->getNomEmprunteur() . "\n";
        echo "Prénom emprunteur (Attendu: Jean): " . $empruntRecupere->getPrenomEmprunteur() . "\n";
        echo "Titre livre (Attendu: PHP pour les Nuls): " . $empruntRecupere->getTitreLivre() . "\n";

        if (
            $empruntRecupere->getNomEmprunteur() === 'Dupont' &&
            $empruntRecupere->getPrenomEmprunteur() === 'Jean' &&
            $empruntRecupere->getTitreLivre() === 'PHP pour les Nuls'
        ) {
            echo "[PASS] Données dénormalisées correctes.\n";
        } else {
            echo "[FAIL] Données dénormalisées incorrectes.\n";
        }
    }

} catch (Exception $e) {
    echo "\n[ERREUR CRITIQUE] : " . $e->getMessage();
    echo "\nTrace : " . $e->getTraceAsString();
}

echo "</pre>";
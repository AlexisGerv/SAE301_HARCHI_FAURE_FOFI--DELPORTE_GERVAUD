<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'class/Livre.class.php';
require_once 'class/Etudiant.class.php';
require_once 'class/Emprunt.class.php';
require_once 'class/Bibliothecaire.class.php';
require_once 'class/Suggestion.class.php';
require_once 'class/Avis.class.php';

echo "Testing Class Instantiation...\n";

try {
    $livre = new Livre([
        'titre' => 'Test Book',
        'nb_exemplaires_total' => 5,
        'date_publication' => '2023-01-01',
        'sujets' => [],
        'mots_cles' => []
    ]);
    echo "Livre instantiated successfully. Titre: " . $livre->getTitre() . "\n";

    $etudiant = new Etudiant(['nom' => 'Doe', 'prenom' => 'John']);
    echo "Etudiant instantiated successfully. Nom: " . $etudiant->getNom() . "\n";

    $emprunt = new Emprunt(['date_emprunt' => '2023-10-27']);
    echo "Emprunt instantiated successfully. Date: " . $emprunt->getDateEmprunt()->format('Y-m-d') . "\n";

    $biblio = new Bibliothecaire(['nom' => 'Admin']);
    echo "Bibliothecaire instantiated successfully.\n";

    $suggestion = new Suggestion(['titre' => 'New Book']);
    echo "Suggestion instantiated successfully.\n";

    $avis = new Avis(['note' => 5]);
    echo "Avis instantiated successfully.\n";

    echo "All classes verified.\n";

} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}

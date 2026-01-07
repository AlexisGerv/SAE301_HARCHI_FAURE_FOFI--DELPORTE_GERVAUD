<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../class/Livre.class.php';
require_once '../class/Etudiant.class.php';
require_once '../class/Emprunt.class.php';
require_once '../class/Bibliothecaire.class.php';
require_once '../class/Suggestion.class.php';
require_once '../class/Avis.class.php';

echo "Test des classes en cours...\n";

try {
    $livre = new Livre([
        'titre' => 'Test Book',
        'nb_exemplaires_total' => 5,
        'date_publication' => '2023-01-01',
        'sujets' => [],
        'mots_cles' => []
    ]);
    echo "Livre créé avec succès.\n";
    echo "Livre (titre): " . $livre->getTitre() . "\n";
    echo "Livre (nb_exemplaires_total): " . $livre->getNbExemplairesTotal() . "\n";

    $etudiant = new Etudiant(['nom' => 'Doe', 'prenom' => 'John', 'mail_iut' => 'john.doe@iut.fr']);
    echo "Etudiant créé (mail_iut): " . $etudiant->getMailIut() . "\n";

    $emprunt = new Emprunt(['dateemprunt' => '2023-10-27']);
    echo "Emprunt créé avec succès.\n";
    echo "Emprunt (dateemprunt): " . $emprunt->getDateEmprunt()->format('Y-m-d') . "\n";

    echo "Toutes les classes ont été vérifiées avec succès.\n";

} catch (Throwable $e) {
    echo "Une erreur est survenue : " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
 
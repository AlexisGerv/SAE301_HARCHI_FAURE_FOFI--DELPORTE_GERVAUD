<?php

require_once '../class/Manager/ManagerLivre.class.php';
require_once '../class/Livre.class.php';
require_once '../modeles/connect.php';


$manager = new ManagerLivre($bdd);

$livre = new Livre([
    'id' => 1,
    'titre' => 'Test changé',
    'auteur' => 'Test',
    'resume' => 'Test',
    'isbn' => 'test',
    'categorie' => 'Test',
    'nb_exemplaires_total' => 1,
    'nb_exemplaires_disponible' => 1,
    'date_publication' => new DateTime(),
    'est_disponible' => true,
    'format' => 'Test',
    'editeur' => 'Test',
    'mots_cles' => ['Test'],
    'image_couverture' => 'Test',
    'type_support' => 'Test',
    '_collection' => 'Test',
    'sudoc' => 'Test',
    'nb_pages' => 1
]);


// $manager->add($livre);

// $manager->update($livre);

// $manager->delete($livre);

echo $manager->getOne(4)->getTitre(); // Affiche le titre du livre avec l'id 4

// echo $livre->getTitre();  

// $livres = $manager->getAll(); // Affiche tous les livres
// foreach ($livres as $livre) {
//     echo $livre->getTitre() . PHP_EOL;
// }

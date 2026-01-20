<?php

require_once __DIR__ . '/../modeles/connect.php';
require_once __DIR__ . '/../autoload.php';

$managerLivre = new ManagerLivre($bdd);

$livre = new Livre([
    'titre' => 'HTML pour les nuls',
    'auteur' => 'Jean Dupont',
    'resume' => 'Apprendre le HTML pour les nuls',
    'categorie' => 'Informatique',
    'nb_exemplaires_total' => 10,
    'nb_exemplaires_disponible' => 10,
    'mots_cles' => 'HTML, Informatique',
    'image_couverture' => 'html_pour_les_nuls.jpg',
    'est_disponible' => true,
    'date_publication' => '2022-01-01',
    'isbn' => '978-2-07-041473-3',
    'nb_pages' => 96,
    'type_support' => 'Livre',
    'format' => 'broché',
    'collection' => 'Folio',
    'sudoc' => '123456789',
    'editeur' => 'Gallimard'
]);

$managerLivre->add($livre);



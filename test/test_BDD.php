<?php

// require_once '../class/Manager/ManagerLivre.class.php';
// require_once '../class/Livre.class.php';

require_once '../class/Manager/ManagerUser.class.php';
require_once '../class/User/Utilisateur.class.php';
require_once '../class/User/Etudiant.class.php';

require_once '../modeles/connect.php';

//Test de la classe ManagerUser
$etudiant = new Etudiant([
    'id' => 1,
    'nom' => 'ezgf',
    'prenom' => 'egeg',
    'mail_iut' => 'egeg@mmi',
    'mdp' => 'gegegdrg',
    'num_etudiant' => '123456',
    'formation' => 'MMI',
    'est_admin' => true,
    'peut_emprunter' => true
]);

$manager = new ManagerUtilisateur($bdd);

$manager->add($etudiant); 

// $manager->update($utilisateur);

// Test de la classe ManagerLivre

// $manager = new ManagerLivre($bdd);

// $livre = new Livre([
//     'id' => 1,
//     'titre' => 'Test changé',
//     'auteur' => 'Test',
//     'resume' => 'Test',
//     'isbn' => 'test',
//     'categorie' => 'Test',
//     'nb_exemplaires_total' => 1,
//     'nb_exemplaires_disponible' => 1,
//     'date_publication' => new DateTime(),
//     'est_disponible' => true,
//     'format' => 'Test',
//     'editeur' => 'Test',
//     'mots_cles' => ['Test'],
//     'image_couverture' => 'Test',
//     'type_support' => 'Test',
//     '_collection' => 'Test',
//     'sudoc' => 'Test',
//     'nb_pages' => 1
// ]);


// $manager->add($livre);

// $manager->update($livre);

// $manager->delete($livre);

// echo $manager->getOne(4)->getTitre(); // Affiche le titre du livre avec l'id 4

// echo $livre->getTitre();  

// $livres = $manager->getAll(); // Affiche tous les livres
// foreach ($livres as $livre) {
//     echo $livre->getTitre() . PHP_EOL;
// }

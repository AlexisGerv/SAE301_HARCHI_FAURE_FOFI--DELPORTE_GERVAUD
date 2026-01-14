<?php
require_once '../autoload.php';
require_once '../modeles/connect.php';

//Test de la classe ManagerUser
$etudiant = new Etudiant([
    'id' => 14,
    'nom' => 'frgnef',
    'prenom' => 'zegrgffzefgeg',
    'mail_iut' => 'ezfzbrbefgeg@mmi',
    'mdp' => 'gegegzffzrbdrg',
    'num_etudiant' => '255221234567',
    'formation' => 'MMI',
    'est_admin' => false,
    'peut_emprunter' => true
]);

$professeur = new Utilisateur([
    'id' => 15,
    'nom' => 'prof2',
    'prenom' => 'prof2',
    'mail_iut' => 'prof2@mmi',
    'mdp' => 'prof2',
    'est_admin' => true,
    'peut_emprunter' => true
]);

$manager = new ManagerUtilisateur($bdd);


$manager->delete($etudiant);
$manager->delete($professeur);
// First add the users (this sets their IDs)
// $manager->add($etudiant);
// $manager->add($professeur);

// Now delete works because they have IDs



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
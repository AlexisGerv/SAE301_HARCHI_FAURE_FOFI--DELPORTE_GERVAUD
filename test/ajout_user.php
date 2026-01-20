<?php

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../modeles/connect.php';

$managerUser = new ManagerUtilisateur($bdd);

// $student = new Etudiant([
//     'nom' => 'GERVAUD',
//     'prenom' => 'Alexis',
//     'mail_iut' => 'alexis.gervaud@iut-dijon.u-bourgogne.fr',
//     'mdp' => 'password',
//     'num_etudiant' => '1234656847',
//     'formation' => 'MMI',
//     'est_admin' => false,
//     'peut_emprunter' => true
// ]);

// $prof = new Utilisateur([
//     'nom' => 'Moreira',
//     'prenom' => 'Celine',
//     'mail_iut' => 'celine.moreira@iut-dijon.u-bourgogne.fr',
//     'mdp' => 'password',
//     'est_admin' => false,
//     'peut_emprunter' => true
// ]);

// $biblio = new Utilisateur([
//     'nom' => 'Pierre',
//     'prenom' => 'Hugo',
//     'mail_iut' => 'biblio@iut-dijon.u-bourgogne.fr',
//     'mdp' => 'password',
//     'est_admin' => true,
//     'peut_emprunter' => true
// ]);

// $managerUser->add($student);
// $managerUser->add($prof);
// $managerUser->add($biblio);


// test avec le hachage

//mot de passe de la connexion
$mdp_clair="password";

//hachage du mot de passe
$mdp_hache=password_hash($mdp_clair, PASSWORD_DEFAULT);

// $donnees = [
//     'nom' => 'HARCHI',
//     'prenom' => 'Faure',
//     'mail_iut' => 'faure.harchi@iut-dijon.u-bourgogne.fr',
//     'mdp' => $mdp_hache, 
//     'est_admin' => false,    // 1 pour bibliothécaire
//     'peut_emprunter' => true
// ];

$donnees = [
    'nom' => 'Meme',
    'prenom' => 'Matie',
    'mail_iut' => 'mati.meme@iut-dijon.u-bourgogne.fr',
    'mdp' => $mdp_hache, 
    'est_admin' => true,    // 1 pour bibliothécaire
    'peut_emprunter' => true
];

$biblio2 = new Utilisateur($donnees);
$managerUser->add($biblio2);

echo "Utilisateur créé avec succès avec un mot de passe haché !";




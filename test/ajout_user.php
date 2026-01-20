<?php

require_once __DIR__ . '/../autoload.php';
require_once __DIR__ . '/../modeles/connect.php';

$managerUser = new ManagerUtilisateur($bdd);

$student = new Etudiant([
    'nom' => 'GERVAUD',
    'prenom' => 'Alexis',
    'mail_iut' => 'alexis.gervaud@iut-dijon.u-bourgogne.fr',
    'mdp' => 'password',
    'num_etudiant' => '1234656847',
    'formation' => 'MMI',
    'est_admin' => false,
    'peut_emprunter' => true
]);

$prof = new Utilisateur([
    'nom' => 'Moreira',
    'prenom' => 'Celine',
    'mail_iut' => 'celine.moreira@iut-dijon.u-bourgogne.fr',
    'mdp' => 'password',
    'est_admin' => false,
    'peut_emprunter' => true
]);

$biblio = new Utilisateur([
    'nom' => 'Pierre',
    'prenom' => 'Hugo',
    'mail_iut' => 'biblio@iut-dijon.u-bourgogne.fr',
    'mdp' => 'password',
    'est_admin' => true,
    'peut_emprunter' => true
]);

$managerUser->add($student);
$managerUser->add($prof);
$managerUser->add($biblio);

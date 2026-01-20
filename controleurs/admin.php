<?php
// controleurs/admin.php

require_once __DIR__ . '/../autoload.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';

$rootPath = '../';

// Access Control: Only admins (librarians) allowed
if (!isset($_SESSION['user']) || !$_SESSION['user']->getEstAdmin()) {
    header('Location: ../index.php');
    exit();
}

$managerEmprunt = new ManagerEmprunt($bdd);
$managerLivre = new ManagerLivre($bdd);

$message = "";

// Handle Book Addition
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_book') {
    try {
        $data = [
            'titre' => $_POST['titre'],
            'auteur' => $_POST['auteur'],
            '_resume' => $_POST['resume'],
            'isbn' => $_POST['isbn'],
            'categorie' => $_POST['categorie'],
            'nb_exemplaires_total' => (int) $_POST['nb_exemplaires'],
            'nb_exemplaires_disponible' => (int) $_POST['nb_exemplaires'],
            'date_publication' => $_POST['date_publication'],
            'est_disponible' => 1,
            'format' => $_POST['format'],
            'editeur' => $_POST['editeur'],
            'mots_cles' => $_POST['mots_cles'], // String, handled by setter
            'type_support' => $_POST['type_support'],
            '_collection' => $_POST['_collection'],
            'sudoc' => $_POST['sudoc'],
            'nb_pages' => (int) $_POST['nb_pages'],
            'image_couverture' => '' // Default empty
        ];

        // Handle Image Upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../public/assets/livre/';
            $fileName = basename($_FILES['image']['name']);
            $targetPath = $uploadDir . $fileName;

            // Basic check for image type (optional but recommended)
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($_FILES['image']['type'], $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    $data['image_couverture'] = $fileName;
                } else {
                    $message = "Erreur lors de l'upload de l'image.";
                }
            } else {
                $message = "Type de fichier non autorisé. JPEG, PNG, GIF seulement.";
            }
        }

        $livre = new Livre($data);
        $managerLivre->add($livre);
        $message = "Livre ajouté avec succès !";

    } catch (Exception $e) {
        $message = "Erreur : " . $e->getMessage();
    }
}

// Fetch all loans
$emprunts = $managerEmprunt->getAll();

// Include View
include __DIR__ . '/../vue/VueAdmin.php';

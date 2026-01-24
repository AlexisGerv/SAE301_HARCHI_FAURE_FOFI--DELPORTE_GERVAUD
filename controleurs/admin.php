<?php
// controleurs/admin.php

/**
 * Contrôleur du Tableau de Bord Administrateur (Bibliothécaire).
 * 
 * Fonctionnalités :
 * 1. Vérification des droits d'accès (est_admin = 1).
 * 2. Gestion des emprunts :
 *    - Prolonger un emprunt (+14 jours).
 *    - Supprimer/Terminer un emprunt (retour du livre et remise en stock).
 * 3. Ajout de nouveaux livres :
 *    - Traitement du formulaire.
 *    - Upload de l'image de couverture.
 *    - Insertion en BDD via ManagerLivre.
 * 4. Affichage de la liste des emprunts en cours.
 */

require_once __DIR__ . '/../autoload.php';
// Initialisation session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../modeles/connect.php';

$rootPath = '../';

// -------------------------------------------------------------
// 1. Contrôle d'Accès : Réservé aux administrateurs
// -------------------------------------------------------------
if (!isset($_SESSION['user']) || !$_SESSION['user']->getEstAdmin()) {
    header('Location: ../index.php');
    exit();
}

$managerEmprunt = new ManagerEmprunt($bdd);
$managerLivre = new ManagerLivre($bdd);
$managerReservation = new ManagerReservation($bdd);

$message = "";

// -------------------------------------------------------------
// 2. Traitement des Actions (POST)
// -------------------------------------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // --- Action : Prolonger un emprunt ---
    if ($_POST['action'] === 'prolonger' && isset($_POST['id'])) {
        $empruntId = (int) $_POST['id'];
        $emprunt = $managerEmprunt->getOne($empruntId);
        if ($emprunt) {
            // Ajout de 14 jours à la date prévue
            $newDate = $emprunt->getDateRetourPrevue()->modify('+14 days');
            $emprunt->setDateRetourPrevue($newDate);
            // Incrément du compteur de prolongations
            $emprunt->setNombreProlongations($emprunt->getNombreProlongations() + 1);
            $managerEmprunt->update($emprunt);
            $message = "Emprunt prolongé de 14 jours.";
        }
    }

    // --- Action : Supprimer / Terminer un emprunt ---
    elseif ($_POST['action'] === 'supprimer' && isset($_POST['id'])) {
        $empruntId = (int) $_POST['id'];
        $emprunt = $managerEmprunt->getOne($empruntId);
        if ($emprunt) {
            // Restauration du stock du livre
            $livre = $managerLivre->getOne($emprunt->getLivreId());
            if ($livre) {
                $livre->setNbExemplairesDisponible($livre->getNbExemplairesDisponible() + 1);
                // Si le livre était indisponible, il redevient disponible
                $livre->setEstDisponible(true);
                $managerLivre->update($livre);
            }
            // Suppression de l'emprunt
            $managerEmprunt->delete($emprunt);
            $message = "Emprunt supprimé et livre rendu.";
        }
    }

    // --- Action : Ajouter un livre ---
    elseif ($_POST['action'] === 'add_book') {
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
                'mots_cles' => $_POST['mots_cles'], // Géré par le setter de la classe Livre
                'type_support' => $_POST['type_support'],
                '_collection' => $_POST['_collection'],
                'sudoc' => $_POST['sudoc'],
                'nb_pages' => (int) $_POST['nb_pages'],
                'image_couverture' => '' // Par défaut vide
            ];

            // Traitement de l'upload d'image
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../public/assets/livre/';
                $fileName = basename($_FILES['image']['name']);
                $targetPath = $uploadDir . $fileName;

                // Vérification basique du type MIME
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

            // Création et persistance du livre
            $livre = new Livre($data);
            $managerLivre->add($livre);
            $message = "Livre ajouté avec succès !";

        } catch (Exception $e) {
            $message = "Erreur : " . $e->getMessage();
        }
    }

    // --- Action : Accepter une réservation ---
    elseif ($_POST['action'] === 'accept_reservation' && isset($_POST['id'])) {
        $reservationId = (int) $_POST['id'];
        $reservation = $managerReservation->getOne($reservationId);

        if ($reservation) {
            $livre = $managerLivre->getOne($reservation->getLivreId());

            if ($livre && $livre->getNbExemplairesDisponible() > 0) {
                // Création de l'emprunt
                $emprunt = new Emprunt([
                    'utilisateur_id' => $reservation->getUtilisateurId(),
                    'livre_id' => $reservation->getLivreId(),
                    'date_emprunt' => new DateTime(),
                    'date_retour_prevue' => new DateTime('+21 days'),
                    'est_en_retard' => 0,
                    'nombre_prolongations' => 0
                ]);

                try {
                    $managerEmprunt->add($emprunt);

                    // Décrémentation du stock
                    $livre->setNbExemplairesDisponible($livre->getNbExemplairesDisponible() - 1);
                    if ($livre->getNbExemplairesDisponible() === 0) {
                        $livre->setEstDisponible(false);
                    }
                    $managerLivre->update($livre);

                    // Suppression de la réservation
                    $managerReservation->delete($reservationId);

                    $message = "Réservation acceptée. Le livre est maintenant emprunté.";
                } catch (PDOException $e) {
                    $message = "Erreur : Impossible de créer l'emprunt. L'utilisateur ou le livre n'existe peut-être plus (Erreur SQL).";
                }
            } else {
                $message = "Impossible d'accepter : plus d'exemplaire disponible.";
            }
        } else {
            $message = "Erreur : Réservation introuvable (ID: " . $reservationId . ").";
        }

    }

    // --- Action : Refuser une réservation ---
    elseif ($_POST['action'] === 'refuse_reservation' && isset($_POST['id'])) {
        $reservationId = (int) $_POST['id'];
        $managerReservation->delete($reservationId);
        $message = "Réservation refusée et supprimée.";
    }
}


// -------------------------------------------------------------
// 3. Récupération des données pour l'affichage
// -------------------------------------------------------------
// Récupère tous les emprunts avec les infos utilisateurs et livres jointes
$emprunts = $managerEmprunt->getAll();
$reservations = $managerReservation->getAll();

// Inclusion de la vue
include __DIR__ . '/../vue/VueAdmin.php';

<?php
require_once 'connect.php';
require_once 'Livre.class.php';

declare(strict_types=1);

class ManagerLivre
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }
    public function add(Livre $livre)
    {
        $sql = "INSERT INTO Livre (titre, auteur,_resume, isbn, categorie, nb_exemplaires_total, nb_exemplaires_disponibles, date_publication, est_disponible, format, editeur, mots_cles, image_couverture, type_support, _collection, sudoc, nb_pages) VALUES (:titre, :auteur, :_resume, :isbn, :categorie, :nb_exemplaires_total, :nom_exemplaires_disponibles, :date_publication, :est_disponible, :format, :editeur, :mots_cles, :image_couverture, :type_support, :_collection, :sudoc, :nb_pages)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'titre' => $livre->getTitre(),
            'auteur' => $livre->getAuteur(),
            'resume' => $livre->getResume(),
            'isbn' => $livre->getIsbn(),
            'categorie' => $livre->getCategorie(),
            'nb_exemplaires_total' => $livre->getNbExemplairesTotal(),
            'nb_exemplaires_disponibles' => $livre->getNbExemplairesDisponible(),
            'date_publication' => $livre->getDatePublication(),
            'est_disponible' => $livre->getEstDisponible(),
            'format' => $livre->getFormat(),
            'editeur' => $livre->getEditeur(),
            'mots_cles' => $livre->getMotsCles(),
            'image_couverture' => $livre->getImageCouverture(),
            'type_support' => $livre->getTypeSupport(),
            '_collection' => $livre->getCollection(),
            'sudoc' => $livre->getSudoc(),
            'nb_pages' => $livre->getNbPages()
        ]);
    }

    public function rechercherSimple(string $mot)
    {
        // Préparation de la requête pour éviter les injections SQL
        // On cherche dans le titre OU dans le résumé (le '_' devant resume vient de ton SQL)
        $sql = "SELECT * FROM Livre WHERE titre LIKE :mot OR _resume LIKE :mot";
        $stmt = $this->bdd->prepare($sql);

        // On ajoute les % pour chercher le mot n'importe où dans la phrase
        $stmt->execute(['mot' => '%' . $mot . '%']);

        // Retourne toutes les lignes trouvées sous forme de tableau
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
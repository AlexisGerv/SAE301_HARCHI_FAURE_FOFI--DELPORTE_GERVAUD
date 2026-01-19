<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';



class ManagerLivre
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }
    public function add(Livre $livre)
    {
        $sql = "INSERT INTO Livre (titre, auteur,_resume, isbn, categorie, nb_exemplaires_total, nb_exemplaires_disponible, date_publication, est_disponible, format, editeur, mots_cles, image_couverture, type_support, _collection, sudoc, nb_pages) VALUES (:titre, :auteur, :_resume, :isbn, :categorie, :nb_exemplaires_total, :nb_exemplaires_disponible, :date_publication, :est_disponible, :format, :editeur, :mots_cles, :image_couverture, :type_support, :_collection, :sudoc, :nb_pages)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'titre' => $livre->getTitre(),
            'auteur' => $livre->getAuteur(),
            '_resume' => $livre->getResume(),
            'isbn' => $livre->getIsbn(),
            'categorie' => $livre->getCategorie(),
            'nb_exemplaires_total' => $livre->getNbExemplairesTotal(),
            'nb_exemplaires_disponible' => $livre->getNbExemplairesDisponible(),
            'date_publication' => $livre->getDatePublication()->format('Y-m-d'),
            'est_disponible' => $livre->getEstDisponible(),
            'format' => $livre->getFormat(),
            'editeur' => $livre->getEditeur(),
            'mots_cles' => implode(',', $livre->getMotsCles()),
            'image_couverture' => $livre->getImageCouverture(),
            'type_support' => $livre->getTypeSupport(),
            '_collection' => $livre->getCollection(),
            'sudoc' => $livre->getSudoc(),
            'nb_pages' => $livre->getNbPages()
        ]);

        // Set the auto-generated ID on the Livre object
        $livre->setId((int) $this->bdd->lastInsertId());
    }

    public function update(Livre $livre)
    {
        $sql = "UPDATE Livre SET titre = :titre, auteur = :auteur, _resume = :_resume, isbn = :isbn, categorie = :categorie, nb_exemplaires_total = :nb_exemplaires_total, nb_exemplaires_disponible = :nb_exemplaires_disponible, date_publication = :date_publication, est_disponible = :est_disponible, format = :format, editeur = :editeur, mots_cles = :mots_cles, image_couverture = :image_couverture, type_support = :type_support, _collection = :_collection, sudoc = :sudoc, nb_pages = :nb_pages WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'titre' => $livre->getTitre(),
            'auteur' => $livre->getAuteur(),
            '_resume' => $livre->getResume(),
            'isbn' => $livre->getIsbn(),
            'categorie' => $livre->getCategorie(),
            'nb_exemplaires_total' => $livre->getNbExemplairesTotal(),
            'nb_exemplaires_disponible' => $livre->getNbExemplairesDisponible(),
            'date_publication' => $livre->getDatePublication()->format('Y-m-d'),
            'est_disponible' => $livre->getEstDisponible(),
            'format' => $livre->getFormat(),
            'editeur' => $livre->getEditeur(),
            'mots_cles' => implode(',', $livre->getMotsCles()),
            'image_couverture' => $livre->getImageCouverture(),
            'type_support' => $livre->getTypeSupport(),
            '_collection' => $livre->getCollection(),
            'sudoc' => $livre->getSudoc(),
            'nb_pages' => $livre->getNbPages(),
            'id' => $livre->getId()
        ]);
    }

    public function delete(Livre $livre)
    {
        $sql = "DELETE FROM Livre WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $livre->getId()]);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM Livre";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        $livres = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $livres[] = new Livre($row);
        }
        return $livres;
    }

    public function getOne(int $id): ?Livre
    {
        $sql = "SELECT * FROM Livre WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Livre($row) : null;
    }


}
<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';

/**
 * Manager pour la gestion des Livres en base de données.
 * Permet d'ajouter, modifier, supprimer et récupérer les livres.
 */
class ManagerLivre
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    /**
     * Ajoute un nouveau livre en base de données.
     * 
     * @param Livre $livre L'objet livre à persister.
     */
    public function add(Livre $livre)
    {
        $sql = "INSERT INTO Livre (titre, auteur, _resume, isbn, categorie, nb_exemplaires_total, nb_exemplaires_disponible, date_publication, est_disponible, format, editeur, mots_cles, image_couverture, type_support, _collection, sudoc, nb_pages) 
                VALUES (:titre, :auteur, :_resume, :isbn, :categorie, :nb_exemplaires_total, :nb_exemplaires_disponible, :date_publication, :est_disponible, :format, :editeur, :mots_cles, :image_couverture, :type_support, :_collection, :sudoc, :nb_pages)";

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

        // Mise à jour de l'ID de l'objet avec celui généré par la BDD
        $livre->setId((int) $this->bdd->lastInsertId());
    }

    /**
     * Met à jour les informations d'un livre existant.
     * 
     * @param Livre $livre L'objet livre avec les nouvelles données.
     */
    public function update(Livre $livre)
    {
        $sql = "UPDATE Livre SET 
                titre = :titre, 
                auteur = :auteur, 
                _resume = :_resume, 
                isbn = :isbn, 
                categorie = :categorie, 
                nb_exemplaires_total = :nb_exemplaires_total, 
                nb_exemplaires_disponible = :nb_exemplaires_disponible, 
                date_publication = :date_publication, 
                est_disponible = :est_disponible, 
                format = :format, 
                editeur = :editeur, 
                mots_cles = :mots_cles, 
                image_couverture = :image_couverture, 
                type_support = :type_support, 
                _collection = :_collection, 
                sudoc = :sudoc, 
                nb_pages = :nb_pages 
                WHERE id = :id";

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

    /**
     * Supprime un livre de la base de données.
     * 
     * @param Livre $livre Le livre à supprimer.
     */
    public function delete(Livre $livre)
    {
        $sql = "DELETE FROM Livre WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $livre->getId()]);
    }

    /**
     * Récupère tous les livres de la base de données.
     * 
     * @return Livre[] Un tableau d'objets Livre.
     */
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

    /**
     * Récupère un livre spécifique par son ID.
     * 
     * @param int $id L'identifiant du livre.
     * @return Livre|null L'objet Livre ou null si non trouvé.
     */
    public function getOne(int $id): ?Livre
    {
        $sql = "SELECT * FROM Livre WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Livre($row) : null;
    }
}
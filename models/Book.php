<?php
/**
 * Classe Book - Modèle pour les livres
 */

class Book {
    private $db;
    private $id;
    private $isbn;
    private $titre;
    private $auteur;
    private $editeur;
    private $anneePublication;
    private $categoryId;
    private $nombreExemplaires;
    private $nombreDisponibles;
    private $description;
    private $imageCouverture;
    private $dateAjout;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getIsbn() { return $this->isbn; }
    public function getTitre() { return $this->titre; }
    public function getAuteur() { return $this->auteur; }
    public function getEditeur() { return $this->editeur; }
    public function getAnneePublication() { return $this->anneePublication; }
    public function getCategoryId() { return $this->categoryId; }
    public function getNombreExemplaires() { return $this->nombreExemplaires; }
    public function getNombreDisponibles() { return $this->nombreDisponibles; }
    public function getDescription() { return $this->description; }
    public function getImageCouverture() { return $this->imageCouverture; }
    public function getDateAjout() { return $this->dateAjout; }

    // Setters
    public function setIsbn($isbn) { $this->isbn = $isbn; }
    public function setTitre($titre) { $this->titre = $titre; }
    public function setAuteur($auteur) { $this->auteur = $auteur; }
    public function setEditeur($editeur) { $this->editeur = $editeur; }
    public function setAnneePublication($annee) { $this->anneePublication = $annee; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }
    public function setNombreExemplaires($nombre) { $this->nombreExemplaires = $nombre; }
    public function setNombreDisponibles($nombre) { $this->nombreDisponibles = $nombre; }
    public function setDescription($description) { $this->description = $description; }
    public function setImageCouverture($image) { $this->imageCouverture = $image; }

    /**
     * Créer un nouveau livre
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO books (isbn, titre, auteur, editeur, annee_publication, 
                  category_id, nombre_exemplaires, nombre_disponibles, description, image_couverture) 
                  VALUES (:isbn, :titre, :auteur, :editeur, :annee, :category_id, 
                  :nombre_exemplaires, :nombre_disponibles, :description, :image)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':auteur', $this->auteur);
        $stmt->bindParam(':editeur', $this->editeur);
        $stmt->bindParam(':annee', $this->anneePublication);
        $stmt->bindParam(':category_id', $this->categoryId);
        $stmt->bindParam(':nombre_exemplaires', $this->nombreExemplaires);
        $stmt->bindParam(':nombre_disponibles', $this->nombreDisponibles);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->imageCouverture);

        if ($stmt->execute()) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Lire un livre par ID
     * @param int $id
     * @return bool
     */
    public function read($id) {
        $query = "SELECT b.*, c.nom as category_name 
                  FROM books b 
                  LEFT JOIN categories c ON b.category_id = c.id 
                  WHERE b.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->isbn = $row['isbn'];
            $this->titre = $row['titre'];
            $this->auteur = $row['auteur'];
            $this->editeur = $row['editeur'];
            $this->anneePublication = $row['annee_publication'];
            $this->categoryId = $row['category_id'];
            $this->nombreExemplaires = $row['nombre_exemplaires'];
            $this->nombreDisponibles = $row['nombre_disponibles'];
            $this->description = $row['description'];
            $this->imageCouverture = $row['image_couverture'];
            $this->dateAjout = $row['date_ajout'];
            return true;
        }
        return false;
    }

    /**
     * Mettre à jour un livre
     * @return bool
     */
    public function update() {
        $query = "UPDATE books SET isbn = :isbn, titre = :titre, auteur = :auteur, 
                  editeur = :editeur, annee_publication = :annee, category_id = :category_id,
                  nombre_exemplaires = :nombre_exemplaires, nombre_disponibles = :nombre_disponibles,
                  description = :description, image_couverture = :image 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':isbn', $this->isbn);
        $stmt->bindParam(':titre', $this->titre);
        $stmt->bindParam(':auteur', $this->auteur);
        $stmt->bindParam(':editeur', $this->editeur);
        $stmt->bindParam(':annee', $this->anneePublication);
        $stmt->bindParam(':category_id', $this->categoryId);
        $stmt->bindParam(':nombre_exemplaires', $this->nombreExemplaires);
        $stmt->bindParam(':nombre_disponibles', $this->nombreDisponibles);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':image', $this->imageCouverture);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    /**
     * Supprimer un livre
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM books WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    /**
     * Obtenir tous les livres avec pagination
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function getAll($limit = 20, $offset = 0) {
        $query = "SELECT b.*, c.nom as category_name 
                  FROM books b 
                  LEFT JOIN categories c ON b.category_id = c.id 
                  ORDER BY b.titre 
                  LIMIT :limit OFFSET :offset";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Rechercher des livres
     * @param string $search
     * @return array
     */
    public function search($search) {
        $search = "%{$search}%";
        $query = "SELECT b.*, c.nom as category_name 
                  FROM books b 
                  LEFT JOIN categories c ON b.category_id = c.id 
                  WHERE b.titre LIKE :search 
                  OR b.auteur LIKE :search 
                  OR b.isbn LIKE :search 
                  ORDER BY b.titre";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':search', $search);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Vérifier si le livre est disponible
     * @return bool
     */
    public function isAvailable() {
        return $this->nombreDisponibles > 0;
    }

    /**
     * Décrémenter le nombre de livres disponibles
     * @return bool
     */
    public function decrementAvailable() {
        if ($this->nombreDisponibles > 0) {
            $this->nombreDisponibles--;
            $query = "UPDATE books SET nombre_disponibles = nombre_disponibles - 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        }
        return false;
    }

    /**
     * Incrémenter le nombre de livres disponibles
     * @return bool
     */
    public function incrementAvailable() {
        if ($this->nombreDisponibles < $this->nombreExemplaires) {
            $this->nombreDisponibles++;
            $query = "UPDATE books SET nombre_disponibles = nombre_disponibles + 1 WHERE id = :id";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $this->id);
            return $stmt->execute();
        }
        return false;
    }
}

<?php
/**
 * Classe Category - Modèle pour les catégories de livres
 */

class Category {
    private $db;
    private $id;
    private $nom;
    private $description;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNom() { return $this->nom; }
    public function getDescription() { return $this->description; }

    // Setters
    public function setNom($nom) { $this->nom = $nom; }
    public function setDescription($description) { $this->description = $description; }

    /**
     * Créer une nouvelle catégorie
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO categories (nom, description) VALUES (:nom, :description)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);

        if ($stmt->execute()) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Lire une catégorie par ID
     * @param int $id
     * @return bool
     */
    public function read($id) {
        $query = "SELECT * FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->nom = $row['nom'];
            $this->description = $row['description'];
            return true;
        }
        return false;
    }

    /**
     * Mettre à jour une catégorie
     * @return bool
     */
    public function update() {
        $query = "UPDATE categories SET nom = :nom, description = :description WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    /**
     * Supprimer une catégorie
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    /**
     * Obtenir toutes les catégories
     * @return array
     */
    public function getAll() {
        $query = "SELECT * FROM categories ORDER BY nom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtenir le nombre de livres dans la catégorie
     * @return int
     */
    public function getBookCount() {
        $query = "SELECT COUNT(*) as count FROM books WHERE category_id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch();
        return $row['count'];
    }
}

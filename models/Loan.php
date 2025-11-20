<?php
/**
 * Classe Loan - Modèle pour les emprunts
 */

class Loan {
    private $db;
    private $id;
    private $userId;
    private $bookId;
    private $dateEmprunt;
    private $dateRetourPrevue;
    private $dateRetourEffective;
    private $statut;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUserId() { return $this->userId; }
    public function getBookId() { return $this->bookId; }
    public function getDateEmprunt() { return $this->dateEmprunt; }
    public function getDateRetourPrevue() { return $this->dateRetourPrevue; }
    public function getDateRetourEffective() { return $this->dateRetourEffective; }
    public function getStatut() { return $this->statut; }

    // Setters
    public function setUserId($userId) { $this->userId = $userId; }
    public function setBookId($bookId) { $this->bookId = $bookId; }
    public function setDateRetourPrevue($date) { $this->dateRetourPrevue = $date; }
    public function setDateRetourEffective($date) { $this->dateRetourEffective = $date; }
    public function setStatut($statut) { $this->statut = $statut; }

    /**
     * Créer un nouvel emprunt
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO loans (user_id, book_id, date_retour_prevue, statut) 
                  VALUES (:user_id, :book_id, :date_retour_prevue, :statut)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':user_id', $this->userId);
        $stmt->bindParam(':book_id', $this->bookId);
        $stmt->bindParam(':date_retour_prevue', $this->dateRetourPrevue);
        $stmt->bindParam(':statut', $this->statut);

        if ($stmt->execute()) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Lire un emprunt par ID
     * @param int $id
     * @return bool
     */
    public function read($id) {
        $query = "SELECT l.*, u.nom as user_nom, u.prenom as user_prenom, 
                  b.titre as book_titre, b.auteur as book_auteur
                  FROM loans l
                  JOIN users u ON l.user_id = u.id
                  JOIN books b ON l.book_id = b.id
                  WHERE l.id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->userId = $row['user_id'];
            $this->bookId = $row['book_id'];
            $this->dateEmprunt = $row['date_emprunt'];
            $this->dateRetourPrevue = $row['date_retour_prevue'];
            $this->dateRetourEffective = $row['date_retour_effective'];
            $this->statut = $row['statut'];
            return true;
        }
        return false;
    }

    /**
     * Mettre à jour un emprunt
     * @return bool
     */
    public function update() {
        $query = "UPDATE loans SET date_retour_prevue = :date_retour_prevue, 
                  date_retour_effective = :date_retour_effective, statut = :statut 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':date_retour_prevue', $this->dateRetourPrevue);
        $stmt->bindParam(':date_retour_effective', $this->dateRetourEffective);
        $stmt->bindParam(':statut', $this->statut);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    /**
     * Supprimer un emprunt
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM loans WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    /**
     * Obtenir tous les emprunts avec détails
     * @return array
     */
    public function getAll() {
        $query = "SELECT l.*, u.nom as user_nom, u.prenom as user_prenom, u.email as user_email,
                  b.titre as book_titre, b.auteur as book_auteur, b.isbn as book_isbn
                  FROM loans l
                  JOIN users u ON l.user_id = u.id
                  JOIN books b ON l.book_id = b.id
                  ORDER BY l.date_emprunt DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtenir les emprunts d'un utilisateur
     * @param int $userId
     * @return array
     */
    public function getByUser($userId) {
        $query = "SELECT l.*, b.titre as book_titre, b.auteur as book_auteur, b.isbn as book_isbn
                  FROM loans l
                  JOIN books b ON l.book_id = b.id
                  WHERE l.user_id = :user_id
                  ORDER BY l.date_emprunt DESC";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtenir les emprunts en cours
     * @return array
     */
    public function getActive() {
        $query = "SELECT l.*, u.nom as user_nom, u.prenom as user_prenom, u.email as user_email,
                  b.titre as book_titre, b.auteur as book_auteur
                  FROM loans l
                  JOIN users u ON l.user_id = u.id
                  JOIN books b ON l.book_id = b.id
                  WHERE l.statut = 'en_cours'
                  ORDER BY l.date_retour_prevue";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Obtenir les emprunts en retard
     * @return array
     */
    public function getOverdue() {
        $query = "SELECT l.*, u.nom as user_nom, u.prenom as user_prenom, u.email as user_email,
                  b.titre as book_titre, b.auteur as book_auteur
                  FROM loans l
                  JOIN users u ON l.user_id = u.id
                  JOIN books b ON l.book_id = b.id
                  WHERE l.statut = 'en_cours' AND l.date_retour_prevue < NOW()
                  ORDER BY l.date_retour_prevue";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Retourner un livre
     * @return bool
     */
    public function returnBook() {
        $this->dateRetourEffective = date('Y-m-d H:i:s');
        $this->statut = 'retourne';
        return $this->update();
    }

    /**
     * Vérifier si l'emprunt est en retard
     * @return bool
     */
    public function isOverdue() {
        if ($this->statut === 'en_cours') {
            return strtotime($this->dateRetourPrevue) < time();
        }
        return false;
    }
}

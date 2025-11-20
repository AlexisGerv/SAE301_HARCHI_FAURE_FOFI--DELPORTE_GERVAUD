<?php
/**
 * Classe User - Modèle pour les utilisateurs
 */

class User {
    private $db;
    private $id;
    private $email;
    private $password;
    private $nom;
    private $prenom;
    private $role;
    private $dateInscription;
    private $actif;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    // Getters
    public function getId() { return $this->id; }
    public function getEmail() { return $this->email; }
    public function getNom() { return $this->nom; }
    public function getPrenom() { return $this->prenom; }
    public function getRole() { return $this->role; }
    public function getDateInscription() { return $this->dateInscription; }
    public function isActif() { return $this->actif; }

    // Setters
    public function setEmail($email) { $this->email = $email; }
    public function setPassword($password) { $this->password = password_hash($password, PASSWORD_DEFAULT); }
    public function setNom($nom) { $this->nom = $nom; }
    public function setPrenom($prenom) { $this->prenom = $prenom; }
    public function setRole($role) { $this->role = $role; }
    public function setActif($actif) { $this->actif = $actif; }

    /**
     * Créer un nouvel utilisateur
     * @return bool
     */
    public function create() {
        $query = "INSERT INTO users (email, password, nom, prenom, role, actif) 
                  VALUES (:email, :password, :nom, :prenom, :role, :actif)";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':actif', $this->actif, PDO::PARAM_BOOL);

        if ($stmt->execute()) {
            $this->id = $this->db->lastInsertId();
            return true;
        }
        return false;
    }

    /**
     * Lire un utilisateur par ID
     * @param int $id
     * @return bool
     */
    public function read($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->role = $row['role'];
            $this->dateInscription = $row['date_inscription'];
            $this->actif = $row['actif'];
            return true;
        }
        return false;
    }

    /**
     * Mettre à jour un utilisateur
     * @return bool
     */
    public function update() {
        $query = "UPDATE users SET email = :email, nom = :nom, prenom = :prenom, 
                  role = :role, actif = :actif WHERE id = :id";
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':nom', $this->nom);
        $stmt->bindParam(':prenom', $this->prenom);
        $stmt->bindParam(':role', $this->role);
        $stmt->bindParam(':actif', $this->actif, PDO::PARAM_BOOL);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    /**
     * Supprimer un utilisateur
     * @return bool
     */
    public function delete() {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    /**
     * Obtenir tous les utilisateurs
     * @return array
     */
    public function getAll() {
        $query = "SELECT * FROM users ORDER BY nom, prenom";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Authentifier un utilisateur
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function authenticate($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email AND actif = 1";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        $row = $stmt->fetch();
        if ($row && password_verify($password, $row['password'])) {
            $this->id = $row['id'];
            $this->email = $row['email'];
            $this->password = $row['password'];
            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->role = $row['role'];
            $this->dateInscription = $row['date_inscription'];
            $this->actif = $row['actif'];
            return true;
        }
        return false;
    }

    /**
     * Obtenir le nom complet
     * @return string
     */
    public function getFullName() {
        return $this->prenom . ' ' . $this->nom;
    }
}

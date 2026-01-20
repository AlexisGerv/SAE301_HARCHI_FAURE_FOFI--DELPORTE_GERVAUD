<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';

/**
 * Manager pour la gestion des Utilisateurs (Étudiants, ...) en base de données.
 * Gère l'inscription, l'authentification et les mises à jour de profil.
 */
class ManagerUtilisateur
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    /**
     * Ajoute un nouvel utilisateur (Étudiant ou admin) en base de données.
     * Gère les champs spécifiques aux étudiants si nécessaire.
     * 
     * @param Utilisateur $user L'objet utilisateur à inscrire.
     * @return int L'ID de l'utilisateur inséré.
     */
    public function add(Utilisateur $user): int
    {
        $nom = $user->getNom();
        $prenom = $user->getPrenom();
        $num_etudiant = null;
        $formation = null;

        if ($user instanceof Etudiant) {
            $num_etudiant = $user->getNumEtudiant();
            $formation = $user->getFormation();
        }

        $sql = "INSERT INTO utilisateur (nom, prenom, mail_iut, mdp, num_etudiant, formation, est_admin, peut_emprunter) 
                VALUES (:nom, :prenom, :email, :mdp, :num_etudiant, :formation, :est_admin, :peut_emprunter)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $user->getMailIut(),
            'mdp' => $user->getMdp(), // Le mot de passe doit déjà être haché dans l'objet
            'num_etudiant' => $num_etudiant,
            'formation' => $formation,
            'est_admin' => $user->getEstAdmin(),
            'peut_emprunter' => $user->getPeutEmprunter()
        ]);

        $id = (int) $this->bdd->lastInsertId();
        $user->setId($id);
        return $id;
    }

    /**
     * Met à jour les informations d'un utilisateur.
     */
    public function update(Utilisateur $user)
    {
        $nom = $user->getNom();
        $prenom = $user->getPrenom();
        $num_etudiant = null;
        $formation = null;

        if ($user instanceof Etudiant) {
            $num_etudiant = $user->getNumEtudiant();
            $formation = $user->getFormation();
        }

        $sql = "UPDATE utilisateur SET 
                nom = :nom, 
                prenom = :prenom, 
                mail_iut = :email, 
                mdp = :mdp, 
                num_etudiant = :num_etudiant, 
                formation = :formation, 
                est_admin = :est_admin, 
                peut_emprunter = :peut_emprunter 
                WHERE id = :id";

        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $user->getMailIut(),
            'mdp' => $user->getMdp(),
            'num_etudiant' => $num_etudiant,
            'formation' => $formation,
            'est_admin' => $user->getEstAdmin(),
            'peut_emprunter' => $user->getPeutEmprunter(),
            'id' => $user->getId()
        ]);
    }

    /**
     * Supprime un utilisateur et ses emprunts associés.
     */
    public function delete(Utilisateur $user)
    {
        // Suppression des emprunts en premier (contrainte de clé étrangère potentielle)
        $sqlEmprunt = "DELETE FROM emprunt WHERE utilisateur_id = :id";
        $stmt1 = $this->bdd->prepare($sqlEmprunt);
        $stmt1->execute([':id' => $user->getId()]);

        // Suppression de l'utilisateur
        $sql = "DELETE FROM utilisateur WHERE id = :id";
        $stmt2 = $this->bdd->prepare($sql);
        $stmt2->execute(['id' => $user->getId()]);
    }

    /**
     * Vérifie les identifiants de connexion.
     * Compare l'email et le hash du mot de passe.
     * 
     * @param string $email L'email saisi.
     * @param string $passwordSaisi Le mot de passe saisi en clair.
     * @return Utilisateur|null Retourne l'objet Utilisateur si connexion réussie, sinon null.
     */
    public function verifierConnexion(string $email, string $passwordSaisi): ?Utilisateur
    {
        // 1. On récupère l'utilisateur par son email (unique)
        $sql = "SELECT * FROM utilisateur WHERE mail_iut = :email";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['email' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // 2. On vérifie si l'utilisateur existe
        if ($row) {
            // 3. On vérifie le hash du mot de passe
            if (password_verify($passwordSaisi, $row['mdp'])) {
                // Si correct, on retourne l'objet hydraté
                // (Note: Idéalement il faudrait instancier Etudiant ou Bibliothecaire selon le rôle,
                // ici on instancie Utilisateur générique ou on laisse la classe Utilisateur gérer)
                return new Utilisateur($row);
            }
        }

        return null;
    }
}
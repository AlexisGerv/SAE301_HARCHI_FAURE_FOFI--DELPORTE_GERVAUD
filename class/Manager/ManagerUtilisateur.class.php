<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';



class ManagerUtilisateur
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

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

        $sql = "INSERT INTO utilisateur (nom, prenom, mail_iut, mdp,num_etudiant, formation, est_admin, peut_emprunter) VALUES (:nom, :prenom, :email, :mdp,:num_etudiant, :formation, :est_admin, :peut_emprunter)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $user->getMailIut(),
            'mdp' => $user->getMdp(),
            'num_etudiant' => $num_etudiant,
            'formation' => $formation,
            'est_admin' => $user->getEstAdmin(),
            'peut_emprunter' => $user->getPeutEmprunter()
        ]);
        $id = (int) $this->bdd->lastInsertId();
        $user->setId($id);
        return $id;
    }

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

        $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, mail_iut = :email, mdp = :mdp, num_etudiant = :num_etudiant, formation = :formation, est_admin = :est_admin, peut_emprunter = :peut_emprunter WHERE id = :id";
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

    public function delete(Utilisateur $user)
    {
        $sqlEmprunt = "DELETE FROM emprunt WHERE utilisateur_id = :id";
        $stmt1 = $this->bdd->prepare($sqlEmprunt);
        $stmt1->execute([':id' => $user->getId()]);

        $sql = "DELETE FROM utilisateur WHERE id = :id";
        $stmt2 = $this->bdd->prepare($sql);
        $stmt2->execute(['id' => $user->getId()]);
    }

    public function verifierConnexion(string $email, string $passwordSaisi): ?Utilisateur 
{
    // 1. On récupère l'utilisateur par son email (unique)
    $sql = "SELECT * FROM utilisateur WHERE mail_iut = :email";
    $stmt = $this->bdd->prepare($sql);
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // On vérifie si l'utilisateur existe
    if ($row) {
        // On utilise password_verify pour comparer le mot de passe saisi au hash stocké en BDD
        if (password_verify($passwordSaisi, $row['mdp'])) {
            // Si c'est correct, on retourne un nouvel objet Utilisateur avec les données de la BDD
            return new Utilisateur($row);
        }
    }

    // Si l'email n'existe pas ou si le mot de passe est faux, on retourne null
    return null;
}
}
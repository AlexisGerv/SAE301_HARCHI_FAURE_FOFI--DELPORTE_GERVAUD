<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../class/User/Utilisateur.class.php';
require_once __DIR__ . '/../../class/User/Etudiant.class.php';



class ManagerUtilisateur
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function add(Utilisateur $user)
    {
        $sql = "INSERT INTO utilisateur (nom, prenom, mail_iut, mdp, est_admin, peut_emprunter) VALUES (:nom, :prenom, :email, :mot_de_passe, :est_admin, :peut_emprunter)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getMailIut(),
            'mot_de_passe' => $user->getMdp(),
            'est_admin' => $user->getEstAdmin(),
            'peut_emprunter' => $user->getPeutEmprunter()
        ]);
    }

    public function update(Utilisateur $user)
    {
        $sql = "UPDATE utilisateur SET nom = :nom, prenom = :prenom, mail_iut = :email, mdp = :mot_de_passe, est_admin = :est_admin, peut_emprunter = :peut_emprunter WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getMailIut(),
            'mot_de_passe' => $user->getMdp(),
            'est_admin' => $user->getEstAdmin(),
            'peut_emprunter' => $user->getPeutEmprunter(),
            'id' => $user->getId()
        ]);
    }

    public function delete(Utilisateur $user)
    {
        $sql = "DELETE FROM Utilisateur WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $user->getId()]);
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM Utilisateur";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute();
        $users = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = new Etudiant($row);
        }
        return $users;
    }

    public function getOne(int $id): ?Utilisateur
    {
        $sql = "SELECT * FROM Utilisateur WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? new Etudiant($row) : null;
    }
}
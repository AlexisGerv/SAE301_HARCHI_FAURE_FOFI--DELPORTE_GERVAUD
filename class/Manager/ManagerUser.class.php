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
        $sql = "DELETE FROM utilisateur WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $user->getId()]);
    }

}
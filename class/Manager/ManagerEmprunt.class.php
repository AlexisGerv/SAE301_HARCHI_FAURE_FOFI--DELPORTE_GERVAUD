<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';

/**
 * Manager pour la gestion des emprunts en base de données.
 * Permet d'ajouter, modifier, supprimer et récupérer les emprunts.
 */
class ManagerEmprunt
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    /**
     * Ajoute un nouvel emprunt en base de données.
     * Note: Les champs denormalisés (nom_emprunteur, etc.) ne sont pas insérés ici car non présents en BDD,
     * ils sont reconstitués à la lecture via des JOIN.
     * 
     * @param Emprunt $emprunt L'objet emprunt à persister.
     */
    public function add(Emprunt $emprunt): void
    {
        $sql = "INSERT INTO Emprunt (utilisateur_id, livre_id, date_emprunt, date_retour_prevue, est_en_retard, nombre_prolongations) 
                VALUES (:utilisateur_id, :livre_id, :date_emprunt, :date_retour_prevue, :est_en_retard, :nombre_prolongations)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'utilisateur_id' => $emprunt->getEtudiantId(),
            'livre_id' => $emprunt->getLivreId(),
            'date_emprunt' => $emprunt->getDateEmprunt()->format('Y-m-d'),
            'date_retour_prevue' => $emprunt->getDateRetourPrevue()->format('Y-m-d'),
            'est_en_retard' => (int) $emprunt->isEstEnRetard(),
            'nombre_prolongations' => $emprunt->getNombreProlongations()
        ]);

        $emprunt->setId((int) $this->bdd->lastInsertId());
    }

    /**
     * Met à jour un emprunt existant.
     * Utile pour prolonger une date ou marquer comme en retard.
     */
    public function update(Emprunt $emprunt): void
    {
        $sql = "UPDATE Emprunt SET 
                utilisateur_id = :utilisateur_id, 
                livre_id = :livre_id, 
                date_emprunt = :date_emprunt, 
                date_retour_prevue = :date_retour_prevue, 
                est_en_retard = :est_en_retard, 
                nombre_prolongations = :nombre_prolongations 
                WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'utilisateur_id' => $emprunt->getEtudiantId(),
            'livre_id' => $emprunt->getLivreId(),
            'date_emprunt' => $emprunt->getDateEmprunt()->format('Y-m-d'),
            'date_retour_prevue' => $emprunt->getDateRetourPrevue()->format('Y-m-d'),
            'est_en_retard' => (int) $emprunt->isEstEnRetard(),
            'nombre_prolongations' => $emprunt->getNombreProlongations(),
            'id' => $emprunt->getId()
        ]);
    }

    /**
     * Supprime un emprunt (généralement quand le livre est rendu).
     */
    public function delete(Emprunt $emprunt): void
    {
        $sql = "DELETE FROM Emprunt WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $emprunt->getId()]);
    }

    /**
     * Récupère un emprunt par son ID.
     * Effectue des JOIN avec Utilisateur et Livre pour hydrater les infos associées (noms, titres).
     */
    public function getOne(int $id): ?Emprunt
    {
        $sql = "SELECT e.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM Emprunt e
                JOIN Utilisateur u ON e.utilisateur_id = u.id
                JOIN Livre l ON e.livre_id = l.id
                WHERE e.id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $emprunt = new Emprunt($data);
            $emprunt->setNomEmprunteur($data['nom_emprunteur']);
            $emprunt->setPrenomEmprunteur($data['prenom_emprunteur']);
            $emprunt->setTitreLivre($data['titre_livre']);
            return $emprunt;
        }

        return null;
    }

    /**
     * Récupère tous les emprunts (pour l'admin).
     * Trie par date d'emprunt décroissante.
     */
    public function getAll(): array
    {
        $sql = "SELECT e.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM Emprunt e
                JOIN Utilisateur u ON e.utilisateur_id = u.id
                JOIN Livre l ON e.livre_id = l.id
                ORDER BY e.date_emprunt DESC";
        $stmt = $this->bdd->query($sql);
        $emprunts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emprunt = new Emprunt($row);
            $emprunt->setNomEmprunteur($row['nom_emprunteur']);
            $emprunt->setPrenomEmprunteur($row['prenom_emprunteur']);
            $emprunt->setTitreLivre($row['titre_livre']);
            $emprunts[] = $emprunt;
        }
        return $emprunts;
    }

    /**
     * Récupère les emprunts d'un étudiant spécifique (pour son profil).
     */
    public function getAllByEtudiant(int $etudiantId): array
    {
        $sql = "SELECT e.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM Emprunt e
                JOIN Utilisateur u ON e.utilisateur_id = u.id
                JOIN Livre l ON e.livre_id = l.id
                WHERE e.utilisateur_id = :etudiant_id
                ORDER BY e.date_emprunt DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['etudiant_id' => $etudiantId]);
        $emprunts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emprunt = new Emprunt($row);
            $emprunt->setNomEmprunteur($row['nom_emprunteur']);
            $emprunt->setPrenomEmprunteur($row['prenom_emprunteur']);
            $emprunt->setTitreLivre($row['titre_livre']);
            $emprunts[] = $emprunt;
        }
        return $emprunts;
    }
}
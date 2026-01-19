<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';

class ManagerEmprunt
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function add(Emprunt $emprunt): void
    {
        $sql = "INSERT INTO Emprunt (etudiant_id, livre_id, date_emprunt, date_retour_prevue, est_en_retard, nombre_prolongations) 
                VALUES (:etudiant_id, :livre_id, :date_emprunt, :date_retour_prevue, :est_en_retard, :nombre_prolongations)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'etudiant_id' => $emprunt->getEtudiantId(),
            'livre_id' => $emprunt->getLivreId(),
            'date_emprunt' => $emprunt->getDateEmprunt()->format('Y-m-d'),
            'date_retour_prevue' => $emprunt->getDateRetourPrevue()->format('Y-m-d'),
            'est_en_retard' => (int) $emprunt->isEstEnRetard(), // Cast bool to int for DB if needed, or PDO handles it. usually tinyint.
            'nombre_prolongations' => $emprunt->getNombreProlongations()
        ]);

        $emprunt->setId((int) $this->bdd->lastInsertId()); // Cast int for DB if needed, or PDO handles it. usually tinyint.
    }

    public function update(Emprunt $emprunt): void
    {
        $sql = "UPDATE Emprunt SET 
                etudiant_id = :etudiant_id, 
                livre_id = :livre_id, 
                date_emprunt = :date_emprunt, 
                date_retour_prevue = :date_retour_prevue, 
                est_en_retard = :est_en_retard, 
                nombre_prolongations = :nombre_prolongations 
                WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'etudiant_id' => $emprunt->getEtudiantId(),
            'livre_id' => $emprunt->getLivreId(),
            'date_emprunt' => $emprunt->getDateEmprunt()->format('Y-m-d'),
            'date_retour_prevue' => $emprunt->getDateRetourPrevue()->format('Y-m-d'),
            'est_en_retard' => (int) $emprunt->isEstEnRetard(),
            'nombre_prolongations' => $emprunt->getNombreProlongations(),
            'id' => $emprunt->getId()
        ]);
    }

    public function delete(Emprunt $emprunt): void
    {
        $sql = "DELETE FROM Emprunt WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $emprunt->getId()]);
    }

    public function getOne(int $id): ?Emprunt
    {
        $sql = "SELECT * FROM Emprunt WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        return $data ? new Emprunt($data) : null;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM Emprunt";
        $stmt = $this->bdd->query($sql);
        $emprunts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emprunts[] = new Emprunt($row);
        }
        return $emprunts;
    }

    public function getAllByEtudiant(int $etudiantId): array
    {
        $sql = "SELECT * FROM Emprunt WHERE etudiant_id = :etudiant_id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['etudiant_id' => $etudiantId]);
        $emprunts = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $emprunts[] = new Emprunt($row);
        }
        return $emprunts;
    }
}
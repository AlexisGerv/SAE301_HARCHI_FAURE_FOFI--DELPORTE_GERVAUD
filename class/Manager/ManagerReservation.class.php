<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';

/**
 * Manager pour la gestion des réservations en base de données.
 */
class ManagerReservation
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    /**
     * Ajoute une nouvelle réservation.
     */
    public function add(Reservation $reservation): void
    {
        $sql = "INSERT INTO reservation (utilisateur_id, livre_id, date_demande) 
                VALUES (:utilisateur_id, :livre_id, :date_demande)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'utilisateur_id' => $reservation->getUtilisateurId(),
            'livre_id' => $reservation->getLivreId(),
            'date_demande' => $reservation->getDateDemande()->format('Y-m-d')
        ]);

        $reservation->setId((int) $this->bdd->lastInsertId());
    }

    /**
     * Supprime une réservation par son ID.
     */
    public function delete(int $id): void
    {
        $sql = "DELETE FROM reservation WHERE id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
    }

    /**
     * Récupère toutes les réservations avec les infos jointes.
     */
    public function getAll(): array
    {
        $sql = "SELECT r.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM reservation r
                LEFT JOIN utilisateur u ON r.utilisateur_id = u.id
                LEFT JOIN livre l ON r.livre_id = l.id
                ORDER BY r.date_demande ASC";
        $stmt = $this->bdd->query($sql);
        $reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservation = new Reservation($row);
            $reservation->setNomEmprunteur($row['nom_emprunteur']);
            $reservation->setPrenomEmprunteur($row['prenom_emprunteur']);
            $reservation->setTitreLivre($row['titre_livre']);
            $reservations[] = $reservation;
        }
        return $reservations;
    }

    /**
     * Récupère les réservations d'un utilisateur spécifique.
     */
    public function getAllByUser(int $userId): array
    {
        $sql = "SELECT r.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM reservation r
                LEFT JOIN utilisateur u ON r.utilisateur_id = u.id
                LEFT JOIN livre l ON r.livre_id = l.id
                WHERE r.utilisateur_id = :uid
                ORDER BY r.date_demande DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        $reservations = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $reservation = new Reservation($row);
            $reservation->setNomEmprunteur($row['nom_emprunteur']);
            $reservation->setPrenomEmprunteur($row['prenom_emprunteur']);
            $reservation->setTitreLivre($row['titre_livre']);
            $reservations[] = $reservation;
        }
        return $reservations;
    }

    /**
     * Récupère une réservation par ID.
     */
    public function getOne(int $id): ?Reservation
    {
        $sql = "SELECT r.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM reservation r
                LEFT JOIN utilisateur u ON r.utilisateur_id = u.id
                LEFT JOIN livre l ON r.livre_id = l.id
                WHERE r.id = :id";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            $reservation = new Reservation($data);
            $reservation->setNomEmprunteur($data['nom_emprunteur']);
            $reservation->setPrenomEmprunteur($data['prenom_emprunteur']);
            $reservation->setTitreLivre($data['titre_livre']);
            return $reservation;
        }
        return null;
    }

    /**
     * Vérifie si un utilisateur a déjà réservé ce livre.
     */
    public function userHasReserved(int $userId, int $livreId): bool
    {
        $sql = "SELECT COUNT(*) FROM reservation WHERE utilisateur_id = :uid AND livre_id = :lid";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['uid' => $userId, 'lid' => $livreId]);
        return $stmt->fetchColumn() > 0;
    }
}

<?php
require_once __DIR__ . '/../../modeles/connect.php';
require_once __DIR__ . '/../../autoload.php';

class ManagerHistorique
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function add(Historique $historique): void
    {
        $sql = "INSERT INTO historique_emprunt (utilisateur_id, livre_id, date_emprunt, date_retour_prevue, date_retour_effectif) 
                VALUES (:uid, :lid, :de, :drp, :dre)";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute([
            'uid' => $historique->getUtilisateurId(),
            'lid' => $historique->getLivreId(),
            'de' => $historique->getDateEmprunt()->format('Y-m-d'),
            'drp' => $historique->getDateRetourPrevue()->format('Y-m-d'),
            'dre' => $historique->getDateRetourEffectif()->format('Y-m-d')
        ]);
    }

    public function getAll(): array
    {
        $sql = "SELECT h.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM historique_emprunt h
                LEFT JOIN utilisateur u ON h.utilisateur_id = u.id
                LEFT JOIN livre l ON h.livre_id = l.id
                ORDER BY h.date_retour_effectif DESC";
        $stmt = $this->bdd->query($sql);
        $res = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $h = new Historique($row);
            $h->setNomEmprunteur($row['nom_emprunteur']);
            $h->setPrenomEmprunteur($row['prenom_emprunteur']);
            $h->setTitreLivre($row['titre_livre']);
            $res[] = $h;
        }
        return $res;
    }

    public function getAllByUser(int $userId): array
    {
        $sql = "SELECT h.*, u.nom as nom_emprunteur, u.prenom as prenom_emprunteur, l.titre as titre_livre 
                FROM historique_emprunt h
                LEFT JOIN utilisateur u ON h.utilisateur_id = u.id
                LEFT JOIN livre l ON h.livre_id = l.id
                WHERE h.utilisateur_id = :uid
                ORDER BY h.date_retour_effectif DESC";
        $stmt = $this->bdd->prepare($sql);
        $stmt->execute(['uid' => $userId]);
        $res = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $h = new Historique($row);
            $h->setNomEmprunteur($row['nom_emprunteur']);
            $h->setPrenomEmprunteur($row['prenom_emprunteur']);
            $h->setTitreLivre($row['titre_livre']);
            $res[] = $h;
        }
        return $res;
    }
}

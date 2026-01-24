<?php

/**
 * Class Historique
 * Représente un emprunt terminé (archivé).
 */
class Historique
{
    private int $id;
    private int $utilisateur_id;
    private int $livre_id;
    private DateTime $date_emprunt;
    private DateTime $date_retour_prevue;
    private DateTime $date_retour_effectif;

    // Données jointes
    private ?string $nom_emprunteur = null;
    private ?string $prenom_emprunteur = null;
    private ?string $titre_livre = null;

    public function __construct(array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(array $data): void
    {
        if (isset($data['id'])) {
            $this->id = (int) $data['id'];
        }
        if (isset($data['utilisateur_id'])) {
            $this->utilisateur_id = (int) $data['utilisateur_id'];
        }
        if (isset($data['livre_id'])) {
            $this->livre_id = (int) $data['livre_id'];
        }

        foreach (['date_emprunt', 'date_retour_prevue', 'date_retour_effectif'] as $dateField) {
            if (isset($data[$dateField])) {
                if ($data[$dateField] instanceof DateTime) {
                    $this->$dateField = $data[$dateField];
                } else {
                    $this->$dateField = new DateTime($data[$dateField]);
                }
            }
        }
    }

    // Getters
    public function getId(): int
    {
        return $this->id;
    }
    public function getUtilisateurId(): int
    {
        return $this->utilisateur_id;
    }
    public function getLivreId(): int
    {
        return $this->livre_id;
    }
    public function getDateEmprunt(): DateTime
    {
        return $this->date_emprunt;
    }
    public function getDateRetourPrevue(): DateTime
    {
        return $this->date_retour_prevue;
    }
    public function getDateRetourEffectif(): DateTime
    {
        return $this->date_retour_effectif;
    }

    // Joined Data Setters/Getters
    public function setNomEmprunteur(?string $nom)
    {
        $this->nom_emprunteur = $nom;
    }
    public function getNomEmprunteur(): ?string
    {
        return $this->nom_emprunteur;
    }

    public function setPrenomEmprunteur(?string $prenom)
    {
        $this->prenom_emprunteur = $prenom;
    }
    public function getPrenomEmprunteur(): ?string
    {
        return $this->prenom_emprunteur;
    }

    public function setTitreLivre(?string $titre)
    {
        $this->titre_livre = $titre;
    }
    public function getTitreLivre(): ?string
    {
        return $this->titre_livre;
    }
}

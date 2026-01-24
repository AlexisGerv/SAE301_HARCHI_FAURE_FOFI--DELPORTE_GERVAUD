<?php

/**
 * Class Reservation
 * Represents a book reservation request by a user.
 */
class Reservation
{
    private int $id;
    private int $utilisateur_id;
    private int $livre_id;
    private DateTime $date_demande;

    // Properties for joined data (not in DB table)
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
            $this->setId((int) $data['id']);
        }
        if (isset($data['utilisateur_id'])) {
            $this->setUtilisateurId((int) $data['utilisateur_id']);
        }
        if (isset($data['livre_id'])) {
            $this->setLivreId((int) $data['livre_id']);
        }
        if (isset($data['date_demande'])) {
            // Handle both string date from DB and DateTime object
            if ($data['date_demande'] instanceof DateTime) {
                $this->setDateDemande($data['date_demande']);
            } else {
                $this->setDateDemande(new DateTime($data['date_demande']));
            }
        }
    }

    // Getters and Setters

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUtilisateurId(): int
    {
        return $this->utilisateur_id;
    }

    public function setUtilisateurId(int $utilisateur_id): void
    {
        $this->utilisateur_id = $utilisateur_id;
    }

    public function getLivreId(): int
    {
        return $this->livre_id;
    }

    public function setLivreId(int $livre_id): void
    {
        $this->livre_id = $livre_id;
    }

    public function getDateDemande(): DateTime
    {
        return $this->date_demande;
    }

    public function setDateDemande(DateTime $date_demande): void
    {
        $this->date_demande = $date_demande;
    }

    // Joined Data Getters/Setters

    public function getNomEmprunteur(): ?string
    {
        return $this->nom_emprunteur;
    }

    public function setNomEmprunteur(?string $nom_emprunteur): void
    {
        $this->nom_emprunteur = $nom_emprunteur;
    }

    public function getPrenomEmprunteur(): ?string
    {
        return $this->prenom_emprunteur;
    }

    public function setPrenomEmprunteur(?string $prenom_emprunteur): void
    {
        $this->prenom_emprunteur = $prenom_emprunteur;
    }

    public function getTitreLivre(): ?string
    {
        return $this->titre_livre;
    }

    public function setTitreLivre(?string $titre_livre): void
    {
        $this->titre_livre = $titre_livre;
    }
}

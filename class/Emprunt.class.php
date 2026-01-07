<?php

/**
 * Classe représentant un emprunt d'un livre par un étudiant. 
 */
class Emprunt
{
    private int $id;
    private string $etudiant_id; // Référence à numero_etudiant
    private int $livre_id;
    private DateTime $date_emprunt;
    private DateTime $date_retour_prevue;
    private bool $est_en_retard;
    private int $nombre_prolongations;

    public function __construct(array $donnees = [])
    {
        $this->hydrate($donnees);
    }

    public function hydrate(array $donnees)
    {
        foreach ($donnees as $key => $value) {
            $method = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    // Getters et Setters

    public function getId(): int
    {
        return $this->id;
    }
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getEtudiantId(): string
    {
        return $this->etudiant_id;
    }
    public function setEtudiantId(string $etudiant_id): void
    {
        $this->etudiant_id = $etudiant_id;
    }

    public function getLivreId(): int
    {
        return $this->livre_id;
    }
    public function setLivreId(int $livre_id): void
    {
        $this->livre_id = $livre_id;
    }

    public function getDateEmprunt(): DateTime
    {
        return $this->date_emprunt;
    }
    public function setDateEmprunt($date_emprunt): void
    {
        if (is_string($date_emprunt)) {
            $this->date_emprunt = new DateTime($date_emprunt);
        } else {
            $this->date_emprunt = $date_emprunt;
        }
    }

    public function getDateRetourPrevue(): DateTime
    {
        return $this->date_retour_prevue;
    }
    public function setDateRetourPrevue($date_retour_prevue): void
    {
        if (is_string($date_retour_prevue)) {
            $this->date_retour_prevue = new DateTime($date_retour_prevue);
        } else {
            $this->date_retour_prevue = $date_retour_prevue;
        }
    }

    public function isEstEnRetard(): bool
    {
        return $this->est_en_retard;
    }
    public function setEstEnRetard(bool $est_en_retard): void
    {
        $this->est_en_retard = $est_en_retard;
    }

    public function getNombreProlongations(): int
    {
        return $this->nombre_prolongations;
    }
    public function setNombreProlongations(int $nombre_prolongations): void
    {
        $this->nombre_prolongations = $nombre_prolongations;
    }
}

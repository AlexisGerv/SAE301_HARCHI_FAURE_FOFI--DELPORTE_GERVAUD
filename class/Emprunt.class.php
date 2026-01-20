<?php

declare(strict_types=1);

require_once __DIR__ . '/../autoload.php';

/**
 * Classe représentant un emprunt d'un livre par un étudiant. 
 */
class Emprunt
{
    private int $id;

    /** @var int $etudiant_id ID de l'utilisateur qui emprunte */
    private int $etudiant_id;

    /** @var int $livre_id ID du livre emprunté */
    private int $livre_id;

    /** @var DateTime $date_emprunt Date de début de l'emprunt */
    private DateTime $date_emprunt;

    /** @var DateTime $date_retour_prevue Date limite de retour */
    private DateTime $date_retour_prevue;

    /** @var bool $est_en_retard Indicateur de retard calculé */
    private bool $est_en_retard;

    private int $nombre_prolongations;

    // --- Données dénormalisées (Issues de JOIN) ---
    // Ces propriétés ne sont pas stockées dans la table Emprunt
    // mais sont remplies à la volée par le Manager pour l'affichage.
    private string $nom_emprunteur = '';
    private string $prenom_emprunteur = '';
    private string $titre_livre = '';

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
    public function setId($id): void
    {
        $this->id = (int) $id;
    }

    public function getEtudiantId(): int
    {
        return $this->etudiant_id;
    }

    public function setEtudiantId($etudiant_id): void
    {
        $this->etudiant_id = (int) $etudiant_id;
    }

    // Alias for hydration since DB column is 'utilisateur_id'
    public function setUtilisateurId($id): void
    {
        $this->setEtudiantId($id);
    }

    public function setEtudiant(Utilisateur $etudiant): void
    {
        $this->setEtudiantId($etudiant->getUserId());
    }

    public function getLivreId(): int
    {
        return $this->livre_id;
    }
    public function setLivreId($livre_id): void
    {
        $this->livre_id = (int) $livre_id;
    }

    public function setLivre(Livre $livre): void
    {
        $this->setLivreId($livre->getId());
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
    public function setEstEnRetard($est_en_retard): void
    {
        $this->est_en_retard = (bool) $est_en_retard;
    }

    public function getNombreProlongations(): int
    {
        return $this->nombre_prolongations;
    }
    public function setNombreProlongations($nombre_prolongations): void
    {
        $this->nombre_prolongations = (int) $nombre_prolongations;
    }

    // Getters and Setters for denormalized data

    public function getNomEmprunteur(): string
    {
        return $this->nom_emprunteur;
    }

    public function setNomEmprunteur(string $nom_emprunteur): void
    {
        $this->nom_emprunteur = $nom_emprunteur;
    }

    public function getPrenomEmprunteur(): string
    {
        return $this->prenom_emprunteur;
    }

    public function setPrenomEmprunteur(string $prenom_emprunteur): void
    {
        $this->prenom_emprunteur = $prenom_emprunteur;
    }

    public function getTitreLivre(): string
    {
        return $this->titre_livre;
    }

    public function setTitreLivre(string $titre_livre): void
    {
        $this->titre_livre = $titre_livre;
    }
}

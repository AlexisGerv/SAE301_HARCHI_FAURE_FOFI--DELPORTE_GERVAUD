<?php

/**
 * Classe Livre
 * 
 * Cette classe représente un ouvrage dans le catalogue de la bibliothèque.
 * Elle contient toutes les informations descriptives d'un livre ainsi que son état (disponible, etc.). 
 */
declare(strict_types=1); //cela peremt de forcer le type des variables cdt : (string $acteur = 123;) = crash car pas string
class Livre
{
    private int $id;
    private string $titre;
    private string $auteur;
    private string $resume;
    private string $isbn;
    private string $categorie;
    private int $nb_exemplaires_total;
    private bool $disponible;
    private string $format;
    private string $editeur;
    private DateTime $date_publication;
    private $contributeur;

    private array $mots_cles;

    private string $image_couverture;
    private string $type_support; // 'papier' ou 'numerique'
    private $collection;
    private $sudoc;


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

    public function getTitre(): string
    {
        return $this->titre;
    }
    public function setTitre(string $titre): void
    {
        $this->titre = $titre;
    }

    public function getAuteur(): string
    {
        return $this->auteur;
    }
    public function setAuteur(string $auteur): void
    {
        $this->auteur = $auteur;
    }

    public function getResume(): string
    {
        return $this->resume;
    }
    public function setResume(string $resume): void
    {
        $this->resume = $resume;
    }

    public function getIsbn(): string
    {
        return $this->isbn;
    }
    public function setIsbn(string $isbn): void
    {
        $this->isbn = $isbn;
    }

    public function getCategorie(): string
    {
        return $this->categorie;
    }
    public function setCategorie(string $categorie): void
    {
        $this->categorie = $categorie;
    }

    public function getNbExemplairesTotal(): int
    {
        return $this->nb_exemplaires_total;
    }
    public function setNbExemplairesTotal(int $nb_exemplaires_total): void
    {
        $this->nb_exemplaires_total = $nb_exemplaires_total;
    }

    public function isDisponible(): bool
    {
        return $this->disponible;
    }
    public function setDisponible(bool $disponible): void
    {
        $this->disponible = $disponible;
    }

    public function getFormat(): string
    {
        return $this->format;
    }
    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    public function getEditeur(): string
    {
        return $this->editeur;
    }
    public function setEditeur(string $editeur): void
    {
        $this->editeur = $editeur;
    }

    public function getDatePublication(): DateTime
    {
        return $this->date_publication;
    }
    public function setDatePublication($date_publication): void
    {
        if (is_string($date_publication)) {
            $this->date_publication = new DateTime($date_publication);
        } else {
            $this->date_publication = $date_publication;
        }
    }

    public function getCollection(): string
    {
        return $this->collection;
    }
    public function setCollection(string $collection): void
    {
        $this->collection = $collection;
    }

    public function getSujets(): array
    {
        return $this->sujets;
    }
    public function setSujets(array $sujets): void
    {
        $this->sujets = $sujets;
    }

    public function getMotsCles(): array
    {
        return $this->mots_cles;
    }
    public function setMotsCles(array $mots_cles): void
    {
        $this->mots_cles = $mots_cles;
    }

    public function getCote(): string
    {
        return $this->cote;
    }
    public function setCote(string $cote): void
    {
        $this->cote = $cote;
    }

    public function getConditionsPret(): string
    {
        return $this->conditions_pret;
    }
    public function setConditionsPret(string $conditions_pret): void
    {
        $this->conditions_pret = $conditions_pret;
    }

    public function getImageCouverture(): string
    {
        return $this->image_couverture;
    }
    public function setImageCouverture(string $image_couverture): void
    {
        $this->image_couverture = $image_couverture;
    }

    public function getTypeSupport(): string
    {
        return $this->type_support;
    }
    public function setTypeSupport(string $type_support): void
    {
        $this->type_support = $type_support;
    }
    public function getSudoc(): string
    {
        return $this->sudoc;
    }
    public function setSudoc(string $sudoc): void
    {
        $this->sudoc = $sudoc;
    }
}
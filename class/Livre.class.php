<?php

/**
 * Classe Livre
 * 
 * Cette classe représente un ouvrage dans le catalogue de la bibliothèque.
 * Elle contient toutes les informations descriptives d'un livre ainsi que son état (disponible, etc.). 
 */
declare(strict_types=1); //cela permet de forcer le type des variables cdt : (string $acteur = 123;) = crash car pas string
class Livre
{
    private int $id;
    private string $titre;
    private string $auteur;
    private DateTime $date_publication;
    private string $_resume;
    private string $isbn;
    private string $categorie; // Ex: Informatique, Science...
    private int $nb_exemplaires_total;
    private int $nb_exemplaires_disponible;
    private bool $est_disponible; // Statut global
    private string $format; // Broché, Relié, Ebook
    private string $editeur;
    private string $contributeur;

    /** @var array Liste des mots-clés associés */
    private array $mots_cles;

    private string $image_couverture; // Nom du fichier image
    private string $type_support; // 'Papier' ou 'Numérique'
    private $_collection;
    private $sudoc; // Identifiant SUDOC
    private $nb_pages;

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
        return $this->_resume;
    }
    public function setResume(string $_resume): void
    {
        $this->_resume = $_resume;
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

    public function getNbExemplairesDisponible(): int
    {
        return $this->nb_exemplaires_disponible;
    }
    public function setNbExemplairesDisponible(int $nb_exemplaires_disponible): void
    {
        $this->nb_exemplaires_disponible = $nb_exemplaires_disponible;
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
        return $this->_collection;
    }
    public function setCollection(string $_collection): void
    {
        $this->_collection = $_collection;
    }

    public function getMotsCles(): array
    {
        return $this->mots_cles;
    }
    public function setMotsCles(array|string $mots_cles): void
    {
        if (is_string($mots_cles)) {
            $this->mots_cles = explode(',', $mots_cles);
        } else {
            $this->mots_cles = $mots_cles;
        }
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
    public function getEstDisponible(): bool
    {
        return $this->est_disponible;
    }
    public function setEstDisponible(bool|int $est_disponible): void
    {
        $this->est_disponible = (bool) $est_disponible;
    }
    public function getNbPages(): int
    {
        return $this->nb_pages;
    }
    public function setNbPages(int $nb_pages): void
    {
        $this->nb_pages = $nb_pages;
    }
}
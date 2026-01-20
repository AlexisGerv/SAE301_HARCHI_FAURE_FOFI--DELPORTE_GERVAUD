<?php

/**
 * Classe représentant un avis sur un livre. 
 */
declare(strict_types=1);
class Avis
{
    /** @var int $note Note sur 5 */
    private int $note;

    /** @var string $commentaire Texte de l'avis */
    private string $commentaire;

    /** @var string $etudiant_id ID de l'étudiant (Devrait être un int ?) */
    private string $etudiant_id;

    /** @var int $livre_id ID du livre concerné */
    private int $livre_id;

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

    public function getNote(): int
    {
        return $this->note;
    }
    public function setNote(int $note): void
    {
        $this->note = $note;
    }

    public function getCommentaire(): string
    {
        return $this->commentaire;
    }
    public function setCommentaire(string $commentaire): void
    {
        $this->commentaire = $commentaire;
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
}

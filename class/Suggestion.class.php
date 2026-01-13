<?php

/**
 * Classe représentant une suggestion d'achat de livre. 
 */
declare(strict_types=1);
class Suggestion
{
    private string $titre;
    private string $auteur;
    private int $nombre_votes;
    private string $statut; // ex: 'en_attente', 'validee', 'refusee'

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

    public function getNombreVotes(): int
    {
        return $this->nombre_votes;
    }
    public function setNombreVotes(int $nombre_votes): void
    {
        $this->nombre_votes = $nombre_votes;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }
    public function setStatut(string $statut): void
    {
        $this->statut = $statut;
    }
}

<?php

/**
 * Classe Etudiant
 * 
 * Cette classe représente un utilisateur de type étudiant, connecté via son ENT.
 * Elle stocke les informations personnelles et académiques nécessaires au système. 
 */

class Etudiant extends Utilisateur
{
    /** @var string $num_etudiant Identifiant unique étudiant */
    protected string $num_etudiant;

    /** @var string $formation Code de la formation (MMI, GACO, etc.) */
    protected string $formation;

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

    // --- Getters et Setters ---

    public function getNumEtudiant(): string
    {
        return $this->num_etudiant;
    }
    public function setNumEtudiant(string $num_etudiant): void
    {
        $this->num_etudiant = $num_etudiant;
    }

    public function getMailIut(): string
    {
        return $this->mail_iut;
    }
    public function setMailIut(string $mail_iut): void
    {
        $this->mail_iut = $mail_iut;
    }

    public function getFormation(): string
    {
        return $this->formation;
    }
    public function setFormation(string $formation): void
    {
        $this->formation = $formation;
    }
}

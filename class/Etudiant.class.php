<?php

/**
 * Classe Etudiant
 * 
 * Cette classe représente un utilisateur de type étudiant, connecté via son ENT.
 * Elle stocke les informations personnelles et académiques nécessaires au système.
 */
class Etudiant
{
    /** @var string Identifiant unique (numéro étudiant) */
    private string $numero_etudiant;

    /** @var string Nom de famille */
    private string $nom;

    /** @var string Prénom */
    private string $prenom;

    /** @var string Adresse email IUT de l'étudiant */
    private string $mail_iut;

    /** @var string Formation suivie (département, promotion, groupe) */
    private string $formation;

    /**
     * Constructeur de la classe Etudiant.
     * @param array $donnees Tableau de données pour initialiser l'objet.
     */
    public function __construct(array $donnees = [])
    {
        $this->hydrate($donnees);
    }

    /**
     * Hydrate l'objet avec les données fournies.
     * @param array $donnees
     */
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

    public function getNumeroEtudiant(): string
    {
        return $this->numero_etudiant;
    }
    public function setNumeroEtudiant(string $numero_etudiant): void
    {
        $this->numero_etudiant = $numero_etudiant;
    }

    public function getNom(): string
    {
        return $this->nom;
    }
    public function setNom(string $nom): void
    {
        $this->nom = $nom;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }
    public function setPrenom(string $prenom): void
    {
        $this->prenom = $prenom;
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

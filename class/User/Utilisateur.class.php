<?php

/**
 * Classe représentant un personnel (bibliothécaire ou étudiant). 
 */
declare(strict_types=1);
abstract class utilisateur  
{
    protected string $nom;
    protected string $prenom;
    protected string $mail_iut;
    protected string $password;
    protected bool $est_admin; //si true, l'utilisateur est un bibliothécaire
    protected bool $peut_emprunter; // true si l'utilisateur peut emprunter, false sinon

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

    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    public function getEstAdmin(): bool
    {
        return $this->est_admin;
    }
    public function setEstAdmin(bool $est_admin): void
    {
        $this->est_admin = $est_admin;
    }

    public function getPeutEmprunter(): bool
    {
        return $this->peut_emprunter;
    }
    public function setPeutEmprunter(bool $peut_emprunter): void
    {
        $this->peut_emprunter = $peut_emprunter;
    }
}
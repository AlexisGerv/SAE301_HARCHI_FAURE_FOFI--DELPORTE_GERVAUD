<?php

declare(strict_types=1);

class ManagerLivre
{
    private PDO $bdd;

    public function __construct(PDO $bdd)
    {
        $this->bdd = $bdd;
    }

    public function rechercherSimple(string $mot) {
        // Préparation de la requête pour éviter les injections SQL
        // On cherche dans le titre OU dans le résumé (le '_' devant resume vient de ton SQL)
        $sql = "SELECT * FROM Livre WHERE titre LIKE :mot OR _resume LIKE :mot";
        $stmt = $this->bdd->prepare($sql);
        
        // On ajoute les % pour chercher le mot n'importe où dans la phrase
        $stmt->execute(['mot' => '%' . $mot . '%']);
        
        // Retourne toutes les lignes trouvées sous forme de tableau
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
}
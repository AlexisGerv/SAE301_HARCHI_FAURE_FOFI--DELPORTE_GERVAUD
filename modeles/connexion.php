<?php
// On utilise le manager pour chercher l'utilisateur
function tenterConnexion($bdd, $email, $password) {
    $manager = new ManagerUtilisateur($bdd);
    
    // On cherche l'utilisateur par son mail
    $sql = "SELECT * FROM utilisateur WHERE mail_iut = :email";
    $stmt = $bdd->prepare($sql);
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si on trouve l'user, on vérifie le mot de passe haché
    if ($row && password_verify($password, $row['mdp'])) {
        return new Utilisateur($row);
    }
    
    return null; // Échec
}
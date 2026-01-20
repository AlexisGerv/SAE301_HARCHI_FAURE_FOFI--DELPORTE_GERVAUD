<?php
/**
 * Tente de connecter un utilisateur.
 * 
 * @param PDO $bdd Instance de connexion.
 * @param string $email Email IUT.
 * @param string $password Mot de passe saisi.
 * @return Utilisateur|null L'objet utilisateur si succès, null sinon.
 */
function tenterConnexion($bdd, $email, $password)
{
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
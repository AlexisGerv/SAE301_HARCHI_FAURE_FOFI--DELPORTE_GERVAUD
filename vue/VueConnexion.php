<?php
/**
 * Vue du formulaire de connexion.
 * Affiche les champs Email et Mot de passe.
 * Inclut le Header et le Footer.
 */
require_once('VueHeader.php');
?>

<div style="max-width: 400px; margin: 50px auto; text-align: center;">
    <h1>Connexion</h1>

    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;">Email ou mot de passe incorrect.</p>
    <?php endif; ?>

    <form action="controleurs/connexion.php" method="post">
        <input type="email" name="email" placeholder="Email IUT" required
            style="width:100%; margin-bottom:10px; padding:10px;">
        <input type="password" name="password" placeholder="Mot de passe" required
            style="width:100%; margin-bottom:10px; padding:10px;">

        <button type="submit" style="width:100%; background-color:#a10e2f">Se connecter</button>
    </form>
</div>

<?php
require_once('VueFooter.php');
?>
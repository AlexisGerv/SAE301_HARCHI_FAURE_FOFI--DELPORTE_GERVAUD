<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>site bibliothèque iut</title>
</head>
<body>
    <?php
require_once('./VueHeader.php');
?>
<div class="résultats-recherche">
    <?php
    // On vérifie si le tableau $resultats (rempli par le managerLivre) contient des données
    if (!empty($resultats)):?>

        <p><?= count($resultats) ?> livre(s) trouvé(s) pour "<?= htmlspecialchars($recherche) ?>" :</p>
        
        <?php 
        // On parcourt chaque ligne récupérée dans la table 'Livre'
        foreach ($resultats as $livre): ?>
            <div class="livres_trouves">
                <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                
                <p><?= htmlspecialchars($livre['_resume']) ?></p>
            </div>
        <?php endforeach; ?>

    <?php 
    // Si $resultats est vide mais que $recherche contient quelque chose, 
    // cela signifie que la recherche n'a rien donné
    elseif (!empty($recherche)): ?>
        <p>Aucun résultat pour "<?= htmlspecialchars($recherche) ?>"</p>
    <?php endif; ?>
</div>

<?php
require_once('./VueFooter.php');
?>

  
</body>
</html>


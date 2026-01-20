<?php
/**
 * Vue de la page d'accueil.
 * 
 * Cette vue affiche :
 * 1. Les résultats de recherche si une recherche a été effectuée.
 * 2. Une section "Hero" de bienvenue.
 * 3. La liste des "Nouveautés" (récupérée par ManagerLivre->getAll() dans index.php).
 * 4. Des informations pratiques (Horaires, Accès...).
 */
?>

<div class="résultats-recherche">
    <?php
    // Validation : On vérifie si $resultats est défini et non vide
    if (!empty($resultats)): ?>

        <p><?= count($resultats) ?> livre(s) trouvé(s) pour "<?= htmlspecialchars($recherche) ?>" :</p>

        <?php foreach ($resultats as $livre): ?>
            <div class="livres_trouves">
                <!-- Lien vers le détail du livre : index.php?page=livre&id=... -->
                <a href="<?= $rootPath ?>index.php?page=livre&id=<?= htmlspecialchars($livre['id']) ?>">
                    <h3><?= htmlspecialchars($livre['titre']) ?></h3>
                </a>
                <p><?= htmlspecialchars($livre['_resume']) ?></p>
            </div>
        <?php endforeach; ?>

        <?php
        // Si la recherche ne donne rien
    elseif (!empty($recherche)): ?>
        <p>Aucun résultat pour "<?= htmlspecialchars($recherche) ?>"</p>
    <?php endif; ?>
</div>

<main>
    <!-- Section Hero : Bannière de bienvenue -->
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenue à la Bibliothèque</h1>
            <p>Découvrez notre vaste collection de livres, revues et ressources numériques pour enrichir vos
                connaissances.</p>
            <span>Explorer le catalogue</span>
        </div>
    </section>

    <!-- Section Nouveautés : Grille des livres -->
    <section class="featured">
        <h2>Nouveautés</h2>
        <div class="book-grid">
            <?php foreach ($nouveautes as $livre): ?>
                <!-- Carte Livre cliquable -->
                <a href="<?= $rootPath ?>index.php?page=livre&id=<?= htmlspecialchars($livre->getId()) ?>"
                    class="book-card-link">
                    <div class="book-card">
                        <div class="book-image">
                            <?php if (!empty($livre->getImageCouverture())): ?>
                                <img src="<?= $rootPath ?>public/assets/livre/<?= htmlspecialchars($livre->getImageCouverture()) ?>"
                                    alt="<?= htmlspecialchars($livre->getTitre()) ?>"
                                    style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
                                <!-- Image par défaut si aucune couv -->
                                <i class="fa-solid fa-book" style="font-size: 3rem; color: #ccc;"></i>
                            <?php endif; ?>
                        </div>
                        <div class="book-info">
                            <h3><?= htmlspecialchars($livre->getTitre()) ?></h3>
                            <p><?= htmlspecialchars($livre->getAuteur()) ?></p>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Section Informations Pratiques -->
    <section class="info-section">
        <div class="info-content">
            <div class="info-box">
                <i class="fa-regular fa-clock"></i>
                <h3>Horaires</h3>
                <p>Lundi - Vendredi : 8h - 19h</p>
                <p>Samedi : 9h - 13h</p>
            </div>
            <div class="info-box">
                <i class="fa-solid fa-location-dot"></i>
                <h3>Accès</h3>
                <p>Campus Montmuzard</p>
                <p>Dijon, France</p>
            </div>
            <div class="info-box">
                <i class="fa-solid fa-wifi"></i>
                <h3>Services</h3>
                <p>Wifi Gratuit</p>
                <p>Salles de travail</p>
            </div>
        </div>
    </section>
</main>
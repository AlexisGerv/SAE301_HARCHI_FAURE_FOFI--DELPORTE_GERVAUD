
<div class="résultats-recherche">
    <?php
    // On vérifie si le tableau $resultats (rempli par le managerLivre) contient des données
    if (!empty($resultats)): ?>

        <!-- Affiche le nombre de livres trouvés et le terme de recherche -->
        <p><?= count($resultats) ?> livre(s) trouvé(s) pour "<?= htmlspecialchars($recherche) ?>" :</p>

        <?php
        // On parcourt chaque ligne récupérée dans la table 'Livre'
        foreach ($resultats as $livre): ?>
            <div class="livres_trouves">
                <a href="./controleurs/livre.php?id=<?= htmlspecialchars($livre['id']) ?>"><h3><?= htmlspecialchars($livre['titre']) ?></h3></a>

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

<main>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>Bienvenue à la Bibliothèque</h1>
            <p>Découvrez notre vaste collection de livres, revues et ressources numériques pour enrichir vos connaissances.</p>
            <span>Explorer le catalogue</span>
        </div>
    </section>

    <!-- Nouveautés Section -->
    <section class="featured">
        <h2>Nouveautés</h2>
        <div class="book-grid">
            <?php foreach ($nouveautes as $livre): ?>
                <a href="<?= $rootPath ?>controleurs/livre.php?id=<?= htmlspecialchars($livre->getId()) ?>" class="book-card-link">
                    <div class="book-card">
                        <div class="book-image">
                            <?php if (!empty($livre->getImageCouverture())): ?>
                                <img src="<?= $rootPath ?>public/assets/livre/<?= htmlspecialchars($livre->getImageCouverture()) ?>" alt="<?= htmlspecialchars($livre->getTitre()) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            <?php else: ?>
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

    <!-- Info Section -->
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
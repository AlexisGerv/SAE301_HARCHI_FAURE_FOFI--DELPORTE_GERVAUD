<link rel="stylesheet" href="./public/style/accueil-style.css">
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
                <a href="livre.php?id=<?= htmlspecialchars($livre['id']) ?>"><h3><?= htmlspecialchars($livre['titre']) ?></h3></a>

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
            <!-- Placeholder Card 1 -->
            <div class="book-card">
                <div class="book-image">
                    <i class="fa-solid fa-book"></i>
                </div>
                <div class="book-info">
                    <h3>Le Petit Prince</h3>
                    <p>Antoine de Saint-Exupéry</p>
                </div>
            </div>

            <!-- Placeholder Card 2 -->
            <div class="book-card">
                <div class="book-image">
                    <i class="fa-solid fa-laptop-code"></i>
                </div>
                <div class="book-info">
                    <h3>Apprendre le Web</h3>
                    <p>Sophie Martin</p>
                </div>
            </div>

            <!-- Placeholder Card 3 -->
            <div class="book-card">
                <div class="book-image">
                    <i class="fa-solid fa-dna"></i>
                </div>
                <div class="book-info">
                    <h3>Biologie Cellulaire</h3>
                    <p>Jean Dupont</p>
                </div>
            </div>

            <!-- Placeholder Card 4 -->
            <div class="book-card">
                <div class="book-image">
                    <i class="fa-solid fa-paintbrush"></i>
                </div>
                <div class="book-info">
                    <h3>Design UX/UI</h3>
                    <p>Marie Curie</p>
                </div>
            </div>
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
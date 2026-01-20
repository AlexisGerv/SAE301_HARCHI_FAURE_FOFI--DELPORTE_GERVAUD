<link rel="stylesheet" href="./public/style/livre-style.css">
<div class="container book-details-page">
    <?php if (isset($error)): ?>
        <div class="error-message">
            <h1>Oups !</h1>
            <p>
                <?= htmlspecialchars($error) ?>
            </p>
            <a href="index.php" class="btn-back">Retour à l'accueil</a>
        </div>
    <?php elseif ($livre): ?>
        <div class="book-container">
        <!-- Colonne Gauche : Image -->
        <div class="book-cover-column">
        <?php
        $imagePath = "./public/assets/livre/" . htmlspecialchars($livre->getImageCouverture());
        // Fallback si l'image n'est pas trouvée (optionnel, pour l'UX)
        if (!file_exists($imagePath) && !empty($livre->getImageCouverture())) {
            // On garde le chemin généré même s'il n'existe pas sur le disque pour le moment, 
            // car les images peuvent être sur un CDN ou autre, mais ici on suppose local.
            // On pourrait mettre une image par défaut ici.
        }
        ?>
        <img src="<?= $imagePath ?>" alt="Couverture de <?= htmlspecialchars($livre->getTitre()) ?>" class="cover-image">
        </div>

        <!-- Colonne Droite : Informations -->
        <div class="book-info-column">
        <h1 class="book-title"><?= htmlspecialchars($livre->getTitre()) ?></h1>
        <h2 class="book-author">Par <?= htmlspecialchars($livre->getAuteur()) ?></h2>

        <div class="book-status">
        <?php if ($livre->getEstDisponible()): ?>
            <span class="status-pill status-available">
            <i class="fa-solid fa-check-circle"></i> Disponible
            </span>
        <?php else: ?>
            <span class="status-pill status-unavailable">
            <i class="fa-solid fa-times-circle"></i> Indisponible
            </span>
        <?php endif; ?>
        </div>

        <div class="book-resume">
        <h3>Résumé</h3>
        <p><?= nl2br(htmlspecialchars($livre->getResume())) ?></p>
        </div>

        <div class="book-meta-details">
        <div class="meta-item">
        <strong>Éditeur :</strong> <?= htmlspecialchars($livre->getEditeur()) ?>
        </div>
        <div class="meta-item">
        <strong>Date de publication :</strong> <?= htmlspecialchars($livre->getDatePublication()->format('d/m/Y')) ?>
        </div>
        <div class="meta-item">
        <strong>ISBN :</strong> <?= htmlspecialchars($livre->getIsbn()) ?>
        </div>
        <div class="meta-item">
        <strong>Nombre de pages :</strong> <?= htmlspecialchars((string) $livre->getNbPages()) ?>
        </div>
        <div class="meta-item">
        <strong>Format :</strong> <?= htmlspecialchars($livre->getFormat()) ?>
        </div>
        <div class="meta-item">
        <strong>Collection :</strong> <?= htmlspecialchars($livre->getCollection()) ?>
        </div>
        </div>

        <!-- Bouton d'action (exemple) -->
        <div class="book-actions">
        <!-- Tu pourras ajouter ici le bouton "Emprunter" ou "Réserver" plus tard -->
        </div>
        </div>
        </div>
    <?php endif; ?>
    </div>

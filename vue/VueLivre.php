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
        $imagePath = "./public/images/" . htmlspecialchars($livre->getImageCouverture());
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

    <style>
    /* Styles spécifiques pour la page livre */
    .book-details-page {
    padding: 40px 20px;
    max-width: 1200px;
    margin: 0 auto;
    font-family: 'Poppins', sans-serif;
    }

    .book-container {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }

    /* Colonne Gauche */
    .book-cover-column {
    flex: 1 1 300px;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    }

    .cover-image {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    object-fit: cover;
    max-height: 600px;
    }

    /* Colonne Droite */
    .book-info-column {
    flex: 2 1 400px;
    }

    .book-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 10px;
    line-height: 1.2;
    }

    .book-author {
    font-size: 1.5rem;
    font-weight: 400;
    color: #7f8c8d;
    margin-bottom: 20px;
    }

    .book-status {
    margin-bottom: 25px;
    }

    .status-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 50px;
    font-weight: 600;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    }

    .status-available {
    background-color: #e8f8f5;
    color: #27ae60;
    border: 1px solid #27ae60;
    }

    .status-unavailable {
    background-color: #fdedec;
    color: #c0392b;
    border: 1px solid #c0392b;
    }

    .book-resume h3 {
    font-size: 1.2rem;
    color: #34495e;
    margin-bottom: 10px;
    border-bottom: 2px solid #ecf0f1;
    padding-bottom: 5px;
    display: inline-block;
    }

    .book-resume p {
    font-size: 1rem;
    line-height: 1.6;
    color: #2c3e50;
    margin-bottom: 30px;
    text-align: justify;
    }

    .book-meta-details {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 15px;
    background-color: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
    }

    .meta-item {
    font-size: 0.95rem;
    color: #555;
    }

    .meta-item strong {
    color: #333;
    display: block;
    margin-bottom: 4px;
    }

    .error-message {
    text-align: center;
    padding: 50px;
    color: #721c24;
    background-color: #f8d7da;
    border-color: #f5c6cb;
    border-radius: 8px;
    }

    .btn-back {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #3498db;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
    }

    .btn-back:hover {
    background-color: #2980b9;
    }

    @media (max-width: 768px) {
    .book-container {
    flex-direction: column;
    }

    .book-cover-column {
    width: 100%;
    justify-content: center;
    }

    .cover-image {
    max-width: 200px;
    }
    }
    </style>
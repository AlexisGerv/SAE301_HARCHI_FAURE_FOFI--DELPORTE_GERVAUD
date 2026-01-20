<div class="container book-details-page">
    <?php
    /**
     * Vue affichant le détail d'un livre.
     * Cette vue est incluse par index.php?page=livre
     */
    ?>

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
            <!-- Colonne Gauche : Image de couverture -->
            <div class="book-cover-column">
                <?php
                $imagePath = "./public/assets/livre/" . htmlspecialchars($livre->getImageCouverture());
                ?>
                <img src="<?= $imagePath ?>" alt="Couverture de <?= htmlspecialchars($livre->getTitre()) ?>"
                    class="cover-image">
            </div>

            <!-- Colonne Droite : Informations détaillées -->
            <div class="book-info-column">
                <h1 class="book-title"><?= htmlspecialchars($livre->getTitre()) ?></h1>
                <h2 class="book-author">Par <?= htmlspecialchars($livre->getAuteur()) ?></h2>

                <!-- Statut de disponibilité (Dynamique basé sur le stock) -->
                <div class="book-status">
                    <?php if ($livre->getNbExemplairesDisponible() > 0): ?>
                        <span class="status-pill status-available">
                            <i class="fa-solid fa-check-circle"></i> Disponible
                        </span>
                    <?php else: ?>
                        <span class="status-pill status-unavailable">
                            <i class="fa-solid fa-times-circle"></i> Indisponible
                        </span>
                    <?php endif; ?>
                    <span style="margin-left: 10px; font-weight: bold; color: #555;">
                        (<?= $livre->getNbExemplairesDisponible() ?> exemplaires dispos)
                    </span>
                </div>

                <!-- Section Bouton Emprunter -->
                <?php if (isset($_SESSION['user']) && $_SESSION['user']->getPeutEmprunter()): ?>
                    <?php if ($livre->getNbExemplairesDisponible() > 0): ?>
                        <!-- Formulaire d'emprunt : POST vers controleurs/emprunt.php -->
                        <form action="controleurs/emprunt.php" method="post" style="margin-top: 15px;">
                            <input type="hidden" name="livre_id" value="<?= $livre->getId() ?>">
                            <button type="submit" class="btn-primary" style="width: 100%; max-width: 200px;">Emprunter ce
                                livre</button>
                        </form>
                    <?php else: ?>
                        <p style="color: red; margin-top: 15px;">Ce livre n'est plus disponible pour le moment.</p>
                    <?php endif; ?>
                <?php elseif (!isset($_SESSION['user'])): ?>
                    <p style="margin-top: 15px;"><a href="index.php?page=connexion"
                            style="color: #a10e2f; text-decoration: underline;">Connectez-vous</a> pour emprunter ce livre.</p>
                <?php endif; ?>


                <div class="book-resume">
                    <h3>Résumé</h3>
                    <p><?= nl2br(htmlspecialchars($livre->getResume())) ?></p>
                </div>

                <!-- Métadonnées du livre -->
                <div class="book-meta-details">
                    <div class="meta-item">
                        <strong>Éditeur :</strong> <?= htmlspecialchars($livre->getEditeur()) ?>
                    </div>
                    <div class="meta-item">
                        <strong>Date de publication :</strong>
                        <?= htmlspecialchars($livre->getDatePublication()->format('d/m/Y')) ?>
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
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Script pour gérer les feedbacks (Popups) -->
<script>
    // Vérifie s'il y a un paramètre 'success' ou 'error' dans l'URL
    const urlParams = new URLSearchParams(window.location.search);

    // Cas : Emprunt réussi
    if (urlParams.has('success')) {
        alert("📚 Livre emprunté avec succès ! \n\nVous pouvez le retrouver dans votre espace personnel ou le rendre à la bibliothèque.");

        // Nettoyage de l'URL pour ne pas réafficher le popup au rafraîchissement
        const newUrl = window.location.pathname + window.location.search.replace('&success=1', '').replace('?success=1', '');
        window.history.replaceState({}, document.title, newUrl);
    }

    // Cas : Livre indisponible
    if (urlParams.get('error') === 'unavailable') {
        alert("❌ Désolé, ce livre n'est plus disponible.");
    }
</script>
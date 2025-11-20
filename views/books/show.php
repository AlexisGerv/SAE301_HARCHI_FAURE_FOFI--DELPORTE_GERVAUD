<section class="book-details">
    <div class="book-detail-container">
        <div class="book-image-large">
            <?php if ($book->getImageCouverture()): ?>
                <img src="<?php echo BASE_URL . '/public/images/' . htmlspecialchars($book->getImageCouverture()); ?>" 
                     alt="<?php echo htmlspecialchars($book->getTitre()); ?>">
            <?php else: ?>
                <div class="no-image-large">Pas d'image</div>
            <?php endif; ?>
        </div>
        
        <div class="book-detail-info">
            <h2><?php echo htmlspecialchars($book->getTitre()); ?></h2>
            <p class="author"><strong>Auteur:</strong> <?php echo htmlspecialchars($book->getAuteur()); ?></p>
            
            <?php if ($book->getEditeur()): ?>
                <p><strong>Éditeur:</strong> <?php echo htmlspecialchars($book->getEditeur()); ?></p>
            <?php endif; ?>
            
            <?php if ($book->getAnneePublication()): ?>
                <p><strong>Année de publication:</strong> <?php echo htmlspecialchars($book->getAnneePublication()); ?></p>
            <?php endif; ?>
            
            <?php if ($book->getIsbn()): ?>
                <p><strong>ISBN:</strong> <?php echo htmlspecialchars($book->getIsbn()); ?></p>
            <?php endif; ?>
            
            <div class="availability-status">
                <p><strong>Disponibilité:</strong></p>
                <?php if ($book->getNombreDisponibles() > 0): ?>
                    <span class="available-large">Disponible (<?php echo $book->getNombreDisponibles(); ?> sur <?php echo $book->getNombreExemplaires(); ?> exemplaires)</span>
                <?php else: ?>
                    <span class="unavailable-large">Non disponible actuellement</span>
                <?php endif; ?>
            </div>
            
            <?php if ($book->getDescription()): ?>
                <div class="description">
                    <h3>Description</h3>
                    <p><?php echo nl2br(htmlspecialchars($book->getDescription())); ?></p>
                </div>
            <?php endif; ?>
            
            <div class="actions">
                <?php if (isset($_SESSION['user']) && $book->getNombreDisponibles() > 0): ?>
                    <a href="<?php echo BASE_URL; ?>/public/index.php?page=loan&action=create&book_id=<?php echo $book->getId(); ?>" 
                       class="btn btn-primary" onclick="return confirm('Voulez-vous emprunter ce livre ?')">
                        Emprunter ce livre
                    </a>
                <?php elseif (!isset($_SESSION['user'])): ?>
                    <p class="login-message">Veuillez vous <a href="<?php echo BASE_URL; ?>/public/index.php?page=login">connecter</a> pour emprunter ce livre.</p>
                <?php endif; ?>
                
                <a href="<?php echo BASE_URL; ?>/public/index.php?page=books" class="btn btn-secondary">Retour au catalogue</a>
            </div>
        </div>
    </div>
</section>

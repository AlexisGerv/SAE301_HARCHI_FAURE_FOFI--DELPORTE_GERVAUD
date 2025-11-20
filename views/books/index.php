<section class="books-list">
    <h2>Catalogue des livres</h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Livre ajouté avec succès!</div>
    <?php endif; ?>
    
    <div class="search-box">
        <form action="<?php echo BASE_URL; ?>/public/index.php" method="GET">
            <input type="hidden" name="page" value="books">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Rechercher un livre, un auteur, ISBN..." required>
            <button type="submit">Rechercher</button>
        </form>
    </div>
    
    <div class="books-grid">
        <?php foreach ($books as $book): ?>
            <div class="book-card">
                <div class="book-image">
                    <?php if ($book['image_couverture']): ?>
                        <img src="<?php echo BASE_URL . '/public/images/' . htmlspecialchars($book['image_couverture']); ?>" 
                             alt="<?php echo htmlspecialchars($book['titre']); ?>">
                    <?php else: ?>
                        <div class="no-image">Pas d'image</div>
                    <?php endif; ?>
                </div>
                <div class="book-info">
                    <h4><?php echo htmlspecialchars($book['titre']); ?></h4>
                    <p class="author">Par <?php echo htmlspecialchars($book['auteur']); ?></p>
                    <?php if ($book['category_name']): ?>
                        <p class="category"><?php echo htmlspecialchars($book['category_name']); ?></p>
                    <?php endif; ?>
                    <p class="year"><?php echo htmlspecialchars($book['annee_publication']); ?></p>
                    <div class="availability">
                        <?php if ($book['nombre_disponibles'] > 0): ?>
                            <span class="available">Disponible (<?php echo $book['nombre_disponibles']; ?>/<?php echo $book['nombre_exemplaires']; ?>)</span>
                        <?php else: ?>
                            <span class="unavailable">Non disponible</span>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/public/index.php?page=book&id=<?php echo $book['id']; ?>" class="btn">Voir détails</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

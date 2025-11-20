<section class="search-results">
    <h2>Résultats de recherche pour "<?php echo htmlspecialchars($search); ?>"</h2>
    
    <p><?php echo count($books); ?> résultat(s) trouvé(s)</p>
    
    <div class="search-box">
        <form action="<?php echo BASE_URL; ?>/public/index.php" method="GET">
            <input type="hidden" name="page" value="books">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Rechercher un livre, un auteur, ISBN..." 
                   value="<?php echo htmlspecialchars($search); ?>" required>
            <button type="submit">Rechercher</button>
        </form>
    </div>
    
    <?php if (count($books) > 0): ?>
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
                        <div class="availability">
                            <?php if ($book['nombre_disponibles'] > 0): ?>
                                <span class="available">Disponible (<?php echo $book['nombre_disponibles']; ?>)</span>
                            <?php else: ?>
                                <span class="unavailable">Non disponible</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo BASE_URL; ?>/public/index.php?page=book&id=<?php echo $book['id']; ?>" class="btn">Voir détails</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="no-results">Aucun résultat trouvé pour votre recherche.</p>
        <a href="<?php echo BASE_URL; ?>/public/index.php?page=books" class="btn">Voir tout le catalogue</a>
    <?php endif; ?>
</section>

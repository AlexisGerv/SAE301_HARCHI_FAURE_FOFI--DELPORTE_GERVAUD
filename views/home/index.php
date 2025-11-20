<section class="hero">
    <h2>Bienvenue à la Bibliothèque de l'IUT Dijon</h2>
    <p>Explorez notre catalogue de livres et gérez vos emprunts facilement</p>
    
    <div class="search-box">
        <form action="<?php echo BASE_URL; ?>/public/index.php" method="GET">
            <input type="hidden" name="page" value="books">
            <input type="hidden" name="action" value="search">
            <input type="text" name="q" placeholder="Rechercher un livre, un auteur..." required>
            <button type="submit">Rechercher</button>
        </form>
    </div>
</section>

<section class="categories">
    <h3>Catégories</h3>
    <div class="category-grid">
        <?php foreach ($categories as $category): ?>
            <div class="category-card">
                <h4><?php echo htmlspecialchars($category['nom']); ?></h4>
                <p><?php echo htmlspecialchars($category['description']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="recent-books">
    <h3>Livres récents</h3>
    <div class="books-grid">
        <?php foreach ($recentBooks as $book): ?>
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
                    <p class="author"><?php echo htmlspecialchars($book['auteur']); ?></p>
                    <p class="category"><?php echo htmlspecialchars($book['category_name']); ?></p>
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
</section>

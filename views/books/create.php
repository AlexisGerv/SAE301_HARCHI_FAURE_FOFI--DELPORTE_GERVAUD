<section class="book-create">
    <h2>Ajouter un nouveau livre</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">Erreur lors de l'ajout du livre.</div>
    <?php endif; ?>
    
    <form action="<?php echo BASE_URL; ?>/public/index.php?page=books&action=store" method="POST" class="book-form">
        <div class="form-group">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn" required>
        </div>
        
        <div class="form-group">
            <label for="titre">Titre *</label>
            <input type="text" id="titre" name="titre" required>
        </div>
        
        <div class="form-group">
            <label for="auteur">Auteur *</label>
            <input type="text" id="auteur" name="auteur" required>
        </div>
        
        <div class="form-group">
            <label for="editeur">Éditeur</label>
            <input type="text" id="editeur" name="editeur">
        </div>
        
        <div class="form-group">
            <label for="annee_publication">Année de publication</label>
            <input type="number" id="annee_publication" name="annee_publication" min="1800" max="<?php echo date('Y'); ?>">
        </div>
        
        <div class="form-group">
            <label for="category_id">Catégorie</label>
            <select id="category_id" name="category_id">
                <option value="">Sélectionnez une catégorie</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>">
                        <?php echo htmlspecialchars($category['nom']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="nombre_exemplaires">Nombre d'exemplaires *</label>
            <input type="number" id="nombre_exemplaires" name="nombre_exemplaires" min="1" value="1" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="5"></textarea>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Ajouter le livre</button>
            <a href="<?php echo BASE_URL; ?>/public/index.php?page=books" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</section>

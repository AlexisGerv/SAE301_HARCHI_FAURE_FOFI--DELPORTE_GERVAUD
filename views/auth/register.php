<section class="auth-form">
    <h2>Inscription</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">Erreur lors de l'inscription. L'email existe peut-être déjà.</div>
    <?php endif; ?>
    
    <form action="<?php echo BASE_URL; ?>/public/index.php?page=register&action=store" method="POST">
        <div class="form-group">
            <label for="nom">Nom *</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        
        <div class="form-group">
            <label for="prenom">Prénom *</label>
            <input type="text" id="prenom" name="prenom" required>
        </div>
        
        <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe *</label>
            <input type="password" id="password" name="password" required minlength="6">
            <small>Au moins 6 caractères</small>
        </div>
        
        <div class="form-group">
            <label for="password_confirm">Confirmer le mot de passe *</label>
            <input type="password" id="password_confirm" name="password_confirm" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">S'inscrire</button>
        </div>
    </form>
    
    <p class="auth-link">Vous avez déjà un compte ? <a href="<?php echo BASE_URL; ?>/public/index.php?page=login">Connectez-vous</a></p>
</section>

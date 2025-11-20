<section class="auth-form">
    <h2>Connexion</h2>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">Email ou mot de passe incorrect.</div>
    <?php endif; ?>
    
    <form action="<?php echo BASE_URL; ?>/public/index.php?page=authenticate" method="POST">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </div>
    </form>
    
    <p class="auth-link">Pas encore de compte ? <a href="<?php echo BASE_URL; ?>/public/index.php?page=register">Inscrivez-vous</a></p>
</section>

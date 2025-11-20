<section class="loans-list">
    <h2><?php echo ($_SESSION['user']['role'] === 'etudiant') ? 'Mes emprunts' : 'Tous les emprunts'; ?></h2>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Emprunt créé avec succès!</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['returned'])): ?>
        <div class="alert alert-success">Livre retourné avec succès!</div>
    <?php endif; ?>
    
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-error">Une erreur s'est produite.</div>
    <?php endif; ?>
    
    <?php if (count($loans) > 0): ?>
        <table class="loans-table">
            <thead>
                <tr>
                    <th>Livre</th>
                    <th>Auteur</th>
                    <?php if ($_SESSION['user']['role'] !== 'etudiant'): ?>
                        <th>Emprunteur</th>
                    <?php endif; ?>
                    <th>Date d'emprunt</th>
                    <th>Date de retour prévue</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loans as $loan): ?>
                    <tr class="<?php echo (strtotime($loan['date_retour_prevue']) < time() && $loan['statut'] === 'en_cours') ? 'overdue' : ''; ?>">
                        <td><?php echo htmlspecialchars($loan['book_titre']); ?></td>
                        <td><?php echo htmlspecialchars($loan['book_auteur']); ?></td>
                        <?php if ($_SESSION['user']['role'] !== 'etudiant'): ?>
                            <td><?php echo htmlspecialchars($loan['user_prenom'] . ' ' . $loan['user_nom']); ?></td>
                        <?php endif; ?>
                        <td><?php echo date('d/m/Y', strtotime($loan['date_emprunt'])); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($loan['date_retour_prevue'])); ?></td>
                        <td>
                            <?php if ($loan['statut'] === 'retourne'): ?>
                                <span class="status-returned">Retourné</span>
                            <?php elseif (strtotime($loan['date_retour_prevue']) < time()): ?>
                                <span class="status-overdue">En retard</span>
                            <?php else: ?>
                                <span class="status-active">En cours</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if ($loan['statut'] === 'en_cours'): ?>
                                <a href="<?php echo BASE_URL; ?>/public/index.php?page=loan&action=return&loan_id=<?php echo $loan['id']; ?>" 
                                   class="btn btn-small" 
                                   onclick="return confirm('Confirmer le retour de ce livre ?')">
                                    Retourner
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="no-results">Aucun emprunt trouvé.</p>
        <a href="<?php echo BASE_URL; ?>/public/index.php?page=books" class="btn">Parcourir le catalogue</a>
    <?php endif; ?>
</section>

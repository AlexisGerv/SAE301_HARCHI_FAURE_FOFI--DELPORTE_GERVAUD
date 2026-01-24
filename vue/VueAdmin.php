<main class="admin-dashboard">
    <?php
    /**
     * Vue du Tableau de Bord Administrateur.
     * Cette vue affiche :
     * 1. La liste des emprunts en cours avec options de prolongation et de suppression.
     * 2. Le formulaire d'ajout d'un nouveau livre.
     */
    ?>
    <div class="container">
        <h1>Tableau de bord Bibliothécaire</h1>

        <!-- Affichage des messages flash (succès ou erreur) -->
        <?php if (!empty($message)): ?>
            <div class="alert">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <!-- Section 0 : Demandes de Réservation -->
        <section class="admin-section">
            <h2>Demandes de Réservation en attente</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Demandeur</th>
                            <th>Livre</th>
                            <th>Date Demande</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($reservations)): ?>
                            <tr>
                                <td colspan="4">Aucune demande en attente.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($reservations as $resa): ?>
                                <tr>
                                    <td>
                                        <?php if ($resa->getNomEmprunteur()): ?>
                                            <?= htmlspecialchars($resa->getNomEmprunteur() . ' ' . $resa->getPrenomEmprunteur()) ?>
                                        <?php else: ?>
                                            <span style="color:red; font-style:italic;">Utilisateur Inconnu (ID:
                                                <?= $resa->getUtilisateurId() ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($resa->getTitreLivre()) ?> (ID: <?= $resa->getLivreId() ?>)
                                    </td>
                                    <td>
                                        <?= $resa->getDateDemande()->format('d/m/Y') ?>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <!-- Formulaire ACCEPTER -->
                                            <form action="index.php?page=admin" method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="accept_reservation">
                                                <input type="hidden" name="id" value="<?= $resa->getId() ?>">
                                                <button type="submit"
                                                    style="background:#28a745; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"
                                                    title="Valider l'emprunt">Accepter</button>
                                            </form>

                                            <!-- Formulaire REFUSER -->
                                            <form action="index.php?page=admin" method="POST" style="display:inline;"
                                                onsubmit="return confirm('Refuser cette réservation ?');">
                                                <input type="hidden" name="action" value="refuse_reservation">
                                                <input type="hidden" name="id" value="<?= $resa->getId() ?>">
                                                <button type="submit"
                                                    style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"
                                                    title="Refuser la demande">Refuser</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section 1 : Gestion des Emprunts -->
        <section class="admin-section">
            <h2>Emprunts en cours</h2>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Emprunteur</th>
                            <th>Livre</th>
                            <th>Date d'emprunt</th>
                            <th>Retour prévu</th>
                            <th>État</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($emprunts)): ?>
                            <tr>
                                <td colspan="6">Aucun emprunt en cours.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($emprunts as $emprunt): ?>
                                <tr>
                                    <td>
                                        <?php if ($emprunt->getNomEmprunteur()): ?>
                                            <?= htmlspecialchars($emprunt->getNomEmprunteur() . ' ' . $emprunt->getPrenomEmprunteur()) ?>
                                        <?php else: ?>
                                            <span style="color:red; font-style:italic;">Utilisateur Inconnu (ID:
                                                <?= $emprunt->getEtudiantId() ?>)</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?= htmlspecialchars($emprunt->getTitreLivre()) ?> (ID:
                                        <?= $emprunt->getLivreId() ?>)
                                    </td>
                                    <td>
                                        <?= $emprunt->getDateEmprunt()->format('d/m/Y') ?>
                                    </td>
                                    <td>
                                        <?= $emprunt->getDateRetourPrevue()->format('d/m/Y') ?>
                                    </td>
                                    <td>
                                        <!-- Statut de retard calculé -->
                                        <?php if ($emprunt->isEstEnRetard()): ?>
                                            <span style="color:red; font-weight:bold;">En retard</span>
                                        <?php else: ?>
                                            <span style="color:green;">En cours</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div style="display: flex; gap: 5px;">
                                            <!-- Formulaire pour PROLONGER -->
                                            <form action="index.php?page=admin" method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="prolonger">
                                                <input type="hidden" name="id" value="<?= $emprunt->getId() ?>">
                                                <button type="submit"
                                                    style="background:#007bff; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"
                                                    title="Prolonger de 14 jours">Prolonger</button>
                                            </form>

                                            <!-- Formulaire pour TERMINER (Supprimer) -->
                                            <form action="index.php?page=admin" method="POST" style="display:inline;"
                                                onsubmit="return confirm('Le livre a-t-il été rendu ? Cette action supprimera l\'emprunt et remettra le livre en stock.');">
                                                <input type="hidden" name="action" value="supprimer">
                                                <input type="hidden" name="id" value="<?= $emprunt->getId() ?>">
                                                <button type="submit"
                                                    style="background:#dc3545; color:white; border:none; padding:5px 10px; border-radius:3px; cursor:pointer;"
                                                    title="Marquer comme rendu">Terminer</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Section 2 : Ajout de Livre -->
        <section class="admin-section">
            <h2>Ajouter un nouveau livre</h2>
            <form action="index.php?page=admin" method="post" enctype="multipart/form-data" class="add-book-form">
                <input type="hidden" name="action" value="add_book">

                <div class="form-grid">
                    <div class="form-group">
                        <label>Titre *</label>
                        <input type="text" name="titre" required>
                    </div>
                    <div class="form-group">
                        <label>Auteur *</label>
                        <input type="text" name="auteur" required>
                    </div>
                    <div class="form-group">
                        <label>ISBN *</label>
                        <input type="text" name="isbn" required>
                    </div>
                    <div class="form-group">
                        <label>Éditeur</label>
                        <input type="text" name="editeur">
                    </div>
                    <div class="form-group">
                        <label>Catégorie</label>
                        <select name="categorie">
                            <option value="Informatique">Informatique</option>
                            <option value="Science">Science</option>
                            <option value="Littérature">Littérature</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Format</label>
                        <select name="format">
                            <option value="Broché">Broché</option>
                            <option value="Relié">Relié</option>
                            <option value="Ebook">Ebook</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Type Support</label>
                        <select name="type_support">
                            <option value="Papier">Papier</option>
                            <option value="Numérique">Numérique</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Collection</label>
                        <input type="text" name="_collection">
                    </div>
                    <div class="form-group">
                        <label>Nb Exemplaires</label>
                        <input type="number" name="nb_exemplaires" value="1" min="1">
                    </div>
                    <div class="form-group">
                        <label>Date Publication</label>
                        <input type="date" name="date_publication" required>
                    </div>
                    <div class="form-group">
                        <label>Nb Pages</label>
                        <input type="number" name="nb_pages">
                    </div>
                    <div class="form-group">
                        <label>SUDOC</label>
                        <input type="text" name="sudoc">
                    </div>
                    <div class="form-group full-width">
                        <label>Mots clés (séparés par des virgules)</label>
                        <input type="text" name="mots_cles" placeholder="ex: web, php, guide">
                    </div>
                    <div class="form-group full-width">
                        <label>Résumé</label>
                        <textarea name="resume" rows="4"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label>Image de couverture</label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Ajouter le livre</button>
                </div>
            </form>
        </section>
    </div>
</main>

<style>
    /* Styles spécifiques au Dashboard Admin */
    .admin-dashboard {
        padding: 40px 20px;
    }

    .admin-section {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        margin-bottom: 40px;
    }

    h1 {
        margin-bottom: 30px;
        text-align: center;
        color: #a10e2f;
    }

    h2 {
        color: #333;
        border-bottom: 2px solid #a10e2f;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    /* Table Responsiveness */
    .table-responsive {
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th,
    td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    /* Form Styles */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 5px;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .btn-primary {
        background-color: #a10e2f;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        margin-top: 20px;
    }

    .btn-primary:hover {
        background-color: #850b26;
    }

    .alert {
        padding: 15px;
        background-color: #d4edda;
        color: #155724;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
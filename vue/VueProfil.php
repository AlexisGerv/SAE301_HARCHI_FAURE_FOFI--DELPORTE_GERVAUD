<?php
/**
 * Vue Profil Utilisateur.
 * Affiche : 
 * 1. Informations de l'utilisateur.
 * 2. Réservations en attente.
 * 3. Emprunts en cours.
 * 4. Historique des emprunts retournés.
 */
?>
<main class="profile-page">
    <div class="container">
        <h1>Mon Espace Personnel</h1>
        <h2>Bonjour,
            <?= htmlspecialchars($user->getPrenom() . ' ' . $user->getNom()) ?>
        </h2>

        <!-- SECTION 1: Réservations en attente -->
        <section class="profile-section">
            <h3 class="section-title"><i class="fa-solid fa-hourglass-half"></i> Mes Réservations en attente</h3>
            <?php if (empty($reservations)): ?>
                <p>Aucune réservation en cours.</p>
            <?php else: ?>
                <ul class="book-list">
                    <?php foreach ($reservations as $resa): ?>
                        <li class="book-item">
                            <span class="book-title">
                                <?= htmlspecialchars($resa->getTitreLivre()) ?>
                            </span>
                            <span class="book-date">Demandé le :
                                <?= $resa->getDateDemande()->format('d/m/Y') ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <!-- SECTION 2: Emprunts en cours -->
        <section class="profile-section">
            <h3 class="section-title"><i class="fa-solid fa-book-open"></i> Mes Emprunts en cours</h3>
            <?php if (empty($emprunts)): ?>
                <p>Aucun emprunt actif.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="profile-table">
                        <thead>
                            <tr>
                                <th>Livre</th>
                                <th>Emprunté le</th>
                                <th>A rendre avant le</th>
                                <th>Etat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($emprunts as $emprunt): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($emprunt->getTitreLivre()) ?>
                                    </td>
                                    <td>
                                        <?= $emprunt->getDateEmprunt()->format('d/m/Y') ?>
                                    </td>
                                    <td>
                                        <?= $emprunt->getDateRetourPrevue()->format('d/m/Y') ?>
                                    </td>
                                    <td>
                                        <?php if ($emprunt->isEstEnRetard()): ?>
                                            <span class="badge badge-danger">En retard</span>
                                        <?php else: ?>
                                            <span class="badge badge-success">En cours</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <!-- SECTION 3: Historique -->
        <section class="profile-section history-section">
            <h3 class="section-title"><i class="fa-solid fa-clock-rotate-left"></i> Historique de mes emprunts</h3>
            <?php if (empty($historique)): ?>
                <p>Aucun historique disponible.</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="profile-table history-table">
                        <thead>
                            <tr>
                                <th>Livre</th>
                                <th>Emprunté le</th>
                                <th>Rendu le</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($historique as $h): ?>
                                <tr>
                                    <td>
                                        <?= htmlspecialchars($h->getTitreLivre()) ?>
                                    </td>
                                    <td>
                                        <?= $h->getDateEmprunt()->format('d/m/Y') ?>
                                    </td>
                                    <td>
                                        <?= $h->getDateRetourEffectif()->format('d/m/Y') ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>
    </div>
</main>

<style>
    .profile-page {
        padding: 40px 0;
    }

    .profile-section {
        margin-bottom: 40px;
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .section-title {
        color: #a10e2f;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-size: 1.4rem;
    }

    .book-list {
        list-style: none;
        padding: 0;
    }

    .book-item {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        border-bottom: 1px solid #f0f0f0;
    }

    .book-title {
        font-weight: bold;
    }

    .book-date {
        color: #666;
        font-size: 0.9rem;
    }

    .profile-table {
        width: 100%;
        border-collapse: collapse;
    }

    .profile-table th,
    .profile-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #eee;
    }

    .profile-table th {
        background-color: #f9f9f9;
        font-weight: 600;
    }

    .badge {
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
        color: white;
    }

    .badge-success {
        background-color: #28a745;
    }

    .badge-danger {
        background-color: #dc3545;
    }

    .history-section {
        opacity: 0.8;
    }

    .history-table th {
        background-color: #e9ecef;
    }
</style>
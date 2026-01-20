<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Universitaire - Accueil</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles -->
    <link rel="stylesheet" href="<?= $rootPath ?>public/style/header-style.css">
    <link rel="stylesheet" href="<?= $rootPath ?>public/style/livre-style.css">
    <link rel="stylesheet" href="<?= $rootPath ?>public/style/accueil-style.css">
    <link rel="stylesheet" href="<?= $rootPath ?>public/style/footer-style.css">
    <script src="<?= $rootPath ?>public/script/footer-script.js" defer></script>

</head>

<body>
    <header>
        <div class="header-main">
            <div class="logo-container">
                <a href="<?= $rootPath ?>index.php" class="logo-link">
                    <i class="fa-solid fa-book-open"></i> Bibliothèque
                </a>
            </div>
            
            <nav class="main-nav">
                <a href="<?= $rootPath ?>index.php" class="nav-link <?= !isset($_GET['page']) ? 'active' : '' ?>">
                    <i class="fa-solid fa-house"></i> Accueil
                </a>
            </nav>

            <div class="user-actions">
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="user-greeting">Bonjour, <strong><?= htmlspecialchars($_SESSION['user']->getPrenom()) ?></strong></span>
                    
                    <?php if ($_SESSION['user']->getEstAdmin()): ?>
                        <a href="<?= $rootPath ?>index.php?page=admin" class="btn-admin">
                            <i class="fa-solid fa-shield-halved"></i> Admin
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?= $rootPath ?>controleurs/deconnexion.php" class="btn-logout" title="Déconnexion">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </a>
                <?php else: ?>
                    <a href="<?= $rootPath ?>index.php?page=connexion" class="btn-login">
                        <i class="fa-solid fa-user"></i> Connexion
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="header-search">
            <form action="<?= $rootPath ?>index.php" method="post" class="search-form">
                <div class="search-wrapper">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" name="recherche" placeholder="Rechercher un livre, une revue..."
                        value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" class="search-input">
                    <button type="submit" class="search-submit" hidden>Rechercher</button>
                    
                    <button type="button" id="btn-filters" class="filter-toggle">
                        <i class="fa-solid fa-sliders"></i>
                    </button>
                </div>

                <div id="filters" class="filters-panel <?= (isset($_GET['cat']) || isset($_GET['dispo'])) ? 'show' : '' ?>">
                    <div class="filter-group">
                        <div class="filter-item">
                            <label><i class="fa-solid fa-layer-group"></i> Catégorie</label>
                            <select name="cat">
                                <option value="all">Toutes</option>
                                <option value="1">Informatique</option>
                                <option value="2">MMI</option>
                                <option value="3">Génie Bio</option>
                            </select>
                        </div>

                        <div class="filter-item">
                            <label><i class="fa-solid fa-book"></i> Type</label>
                            <select name="type">
                                <option value="all">Tous</option>
                                <option value="livre">Livre</option>
                                <option value="revue">Revue</option>
                            </select>
                        </div>

                        <div class="filter-item checkbox-item">
                            <label>
                                <input type="checkbox" name="dispo" <?= isset($_GET['dispo']) ? 'checked' : '' ?>>
                                <span>Disponible uniquement</span>
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="apply-filters-btn">Appliquer</button>
                </div>
            </form>
        </div>
    </header>

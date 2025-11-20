<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title . ' - ' : ''; ?><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/style.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1><a href="<?php echo BASE_URL; ?>/public/index.php"><?php echo SITE_NAME; ?></a></h1>
            <nav class="main-nav">
                <ul>
                    <li><a href="<?php echo BASE_URL; ?>/public/index.php">Accueil</a></li>
                    <li><a href="<?php echo BASE_URL; ?>/public/index.php?page=books">Catalogue</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <li><a href="<?php echo BASE_URL; ?>/public/index.php?page=loans">Mes emprunts</a></li>
                        <?php if (in_array($_SESSION['user']['role'], ['admin', 'bibliothecaire'])): ?>
                            <li><a href="<?php echo BASE_URL; ?>/public/index.php?page=books&action=create">Ajouter un livre</a></li>
                        <?php endif; ?>
                        <li><span class="user-name">Bonjour, <?php echo htmlspecialchars($_SESSION['user']['prenom']); ?></span></li>
                        <li><a href="<?php echo BASE_URL; ?>/public/index.php?page=logout">Déconnexion</a></li>
                    <?php else: ?>
                        <li><a href="<?php echo BASE_URL; ?>/public/index.php?page=login">Connexion</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/public/index.php?page=register">Inscription</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main class="container">

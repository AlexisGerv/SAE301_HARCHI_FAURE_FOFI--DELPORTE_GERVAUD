<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Universitaire - Accueil</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />
    
    <!-- Styles -->
    <link rel="stylesheet" href="../public/style/header-style.css">
    <link rel="stylesheet" href="../public/style/footer-style.css">
    <link rel="stylesheet" href="../public/style/accueil-style.css">
</head>

<body>
    <header>
        <div class="logo-container">
            <!-- Placeholder for logo if needed -->
        </div>
        
        <form action="../controleurs/recherche.php" method="post" class="search">
            <div class="search-row">
                <div class="search-box">
                    <input type="text" name="recherche" placeholder="Rechercher un livre, une revue..." value="<?= htmlspecialchars($_GET['q'] ?? '') ?>">
                    <button type="submit" class="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>

                <button type="button" id="btn-filters" class="filter-btn">
                    <i class="fa-solid fa-sliders"></i> Filtres
                </button>
            </div>

            <div id="filters" class="<?= (isset($_GET['cat']) || isset($_GET['dispo'])) ? 'show' : '' ?>">
                <div class="filter-group">
                    <div class="filter">
                        <label>Catégorie :</label>
                        <select name="cat">
                            <option value="all">Toutes</option>
                            <option value="1">Informatique</option>
                            <option value="2">MMI</option>
                            <option value="3">Génie Bio</option>
                        </select>
                    </div>

                    <div class="filter">
                        <label>Type :</label>
                        <select name="type">
                            <option value="all">Tous</option>
                            <option value="livre">Livre</option>
                            <option value="revue">Revue</option>
                        </select>
                    </div>

                    <div class="filter checkbox-filter">
                        <label>
                            <input type="checkbox" name="dispo" <?= isset($_GET['dispo']) ? 'checked' : '' ?>>
                            Disponible uniquement
                        </label>
                    </div>
                </div>
                <button type="submit" class="apply-btn">Appliquer les filtres</button>
            </div>
        </form>
    </header>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAE301</title>
    <link rel="stylesheet" href="style/style.css">
    <script src="script/script.js" defer></script>
</head>

<body>
    <nav style="display: flex; justify-content: space-between; align-items: center; padding: 10px; background-color: #f8f8f8;">
        <ul>
            <li style="display: inline; margin-right: 15px;"><a href="index.php">Accueil</a></li>
            <li style="display: inline;"><a href="livre.php">Catalogue</a></li>
        </ul>
        <form action="/search" method="get">
            <input type="search" name="q" placeholder="Rechercher..." style="padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
            <button type="submit" style="padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 3px; cursor: pointer;">Rechercher</button>
        </form>
    </nav>

    <body>
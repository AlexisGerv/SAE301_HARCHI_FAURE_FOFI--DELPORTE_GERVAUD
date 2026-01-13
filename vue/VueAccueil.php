<?php

require_once('./VueHeader.php');
?>

<main>
    <!-- Section Bannière : Titre principal et barre de recherche -->
    <section class="banniere">
        <div class="contenu-banniere">
            <h1>Bienvenue à la Bibliothèque Universitaire de l'IUT DE DIJON<br></h1>
            <p>Découvrez, apprenez et évadez-vous avec notre vaste collection de livres et ressources.</p>
            
            <form action="#" method="GET" class="conteneur-recherche">
                <input type="text" name="search" placeholder="Rechercher un livre, un auteur..." class="entree-recherche" required>
                <button type="submit" class="bouton-recherche">
                    <i class="fa-solid fa-search"></i> Rechercher </i>
                </button>
            </form>
        </div>
    </section>

    <!-- Section Fonctionnalités : Présentation des services principaux (Emprunter, Réserver, Espaces) -->
    <div class="conteneur-fonctionnalites">
        <!-- Carte Fonctionnalité : Emprunter -->
        <div class="carte-fonctionnalite">
            <div class="icone-fonctionnalite">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <h3 class="titre-fonctionnalite">Emprunter</h3>
            <p class="desc-fonctionnalite">Accédez à des milliers d'ouvrages et empruntez-les facilement avec votre carte étudiant.</p>
        </div>

        <!-- Carte Fonctionnalité : Réserver -->
        <div class="carte-fonctionnalite">
            <div class="icone-fonctionnalite">
                <i class="fa-solid fa-bookmark"></i>
            </div>
            <h3 class="titre-fonctionnalite">Réserver</h3>
            <p class="desc-fonctionnalite">Réservez vos livres préférés en ligne et récupérez-les dès qu'ils sont disponibles.</p>
        </div>

        <!-- Carte Fonctionnalité : Espaces de travail -->
        <div class="carte-fonctionnalite">
            <div class="icone-fonctionnalite">
                <i class="fa-solid fa-laptop-code"></i>
            </div>
            <h3 class="titre-fonctionnalite">Espaces de Travail</h3>
            <p class="desc-fonctionnalite">Profitez de nos salles de travail calmes et équipées pour vos projets étudiants.</p>
        </div>
    </div>

    <!-- Section Nouveautés : Affichage des derniers livres ajoutés -->
    <section class="section-nouveautes">
        <div class="entete-section">
            <h2 class="titre-section">Nouveautés</h2>
            <a href="#" class="lien-section">Voir tout <i class="fa-solid fa-arrow-right"></i></a>
        </div>
        
        <div class="grille-livres">
            <!-- Article Livre : Le Petit Prince -->
            <article class="carte-livre">
                <img src="" alt="couverture" class="couverture-livre">
                <div class="info-livre">
                    <h3 class="titre-livre">Le Petit Prince</h3>
                    <p class="auteur-livre">Antoine de Saint-Exupéry</p>
                </div>
            </article>

            <!-- Article Livre : 1984 -->
            <article class="carte-livre">
                <img src="" alt="couverture" class="couverture-livre">
                <div class="info-livre">
                    <h3 class="titre-livre">1984</h3>
                    <p class="auteur-livre">George Orwell</p>
                </div>
            </article>

            <!-- Article Livre : L'Étranger -->
            <article class="carte-livre">
                <img src="" alt="couverture" class="couverture-livre">
                <div class="info-livre">
                    <h3 class="titre-livre">L'Étranger</h3>
                    <p class="auteur-livre">Albert Camus</p>
                </div>
            </article>

            <!-- Article Livre : Dune -->
            <article class="carte-livre">
                <img src="" alt="couverture" class="couverture-livre">
                <div class="info-livre">
                    <h3 class="titre-livre">Dune</h3>
                    <p class="auteur-livre">Frank Herbert</p>
                </div>
            </article>
        </div>
    </section>

</main>

<?php
require_once('./VueFooter.php');
?>

  

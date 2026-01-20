<footer>
  <!-- Conteneur principal du menu Footer (roue de navigation) -->
  <div class="wheel-container menu-closed">

    <!-- Bouton Burger pour ouvrir/fermer le menu -->
    <button class="burger" aria-label="Menu" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <!-- La roue contenant les icônes -->
    <div class="wheel">
      <!-- Chaque item possède un attribut data-page pointant vers la route correspondante -->

      <div class="item" data-page="<?= $rootPath ?>index.php?page=settings">
        <?php include __DIR__ . '/../public/assets/icons/setting.svg'; ?>
      </div>

      <div class="item" data-page="<?= $rootPath ?>index.php?page=profil">
        <?php include __DIR__ . '/../public/assets/icons/profile.svg'; ?>
      </div>

      <div class="item" data-page="<?= $rootPath ?>index.php?page=accueil">
        <?php include __DIR__ . '/../public/assets/icons/house.svg'; ?>
      </div>

      <div class="item" data-page="<?= $rootPath ?>index.php?page=panier">
        <?php include __DIR__ . '/../public/assets/icons/cart.svg'; ?>
      </div>

      <div class="item" data-page="<?= $rootPath ?>index.php?page=contact">
        <?php include __DIR__ . '/../public/assets/icons/pin.svg'; ?>
      </div>

    </div>
  </div>


</footer>
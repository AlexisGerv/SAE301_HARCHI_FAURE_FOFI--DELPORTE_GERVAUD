<footer>
  <div class="wheel-container menu-closed">

    <button class="burger" aria-label="Menu" aria-expanded="false">
      <span></span>
      <span></span>
      <span></span>
    </button>

    <div class="wheel">

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
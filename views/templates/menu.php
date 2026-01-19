<nav class="app-menu">
  <a href="<?php echo PATH ?>" class="logo-box">
    <div class="logo-light">
      <img src="<?php echo PATH ?>src/images/logo.jpeg" class="logo-lg  h-6" alt="Light logo">
      <img src="<?php echo PATH ?>src/images/logo.jpeg" class="logo-sm" alt="Small logo">
    </div>

    <div class="logo-dark">
      <img src="<?php echo PATH ?>src/images/logo.jpeg" class="logo-lg h-6" alt="Dark logo">
      <img src="<?php echo PATH ?>src/images/logo.jpeg" class="logo-sm" alt="Small logo">
    </div>
  </a>

  <button id="button-hover-toggle" class="absolute top-5 end-2 rounded-full p-1.5">
    <span class="sr-only">Menu Toggle Button</span>
    <i class="mgc_round_line text-xl"></i>
  </button>

  <div class="srcollbar" data-simplebar>
    <ul class="menu" data-fc-type="accordion">
      <li class="menu-item">
        <span class="menu-text"></span>
      </li>
      <li class="menu-item ">
        <a href="<?php echo PATH ?>" class="menu-link">
          <span class="menu-icon"><i class="mgc_home_3_line"></i></span>
          <span class="menu-text">Inicio</span>
        </a>
      </li>
      <?php require_once "./views/templates/subMenu/usersMenu.php" ?>
      <?php require_once "./views/templates/subMenu/estudiantesMenu.php" ?>
      <?php require_once "./views/templates/subMenu/profesoresMenu.php" ?>
      <?php require_once "./views/templates/subMenu/clasesMenu.php" ?>
      <li class="menu-item">
        <a href="<?php echo PATH ?>logout" data-fc-type="collapse" class="menu-link ">
          <span class="menu-icon"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
              <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7v2H5v14h7v2zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5z" />
            </svg></span>
          <span class="menu-text"> Cerrar Sesión </span>
        </a>
      </li>
    </ul>

  </div>
</nav>
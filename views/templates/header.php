<header class="app-header flex items-center px-4 gap-3">
  <button id="button-toggle-menu" class="nav-link p-2">
    <span class="sr-only">Menu Toggle Button</span>
    <span class="flex items-center justify-center h-6 w-6">
      <i class="mgc_menu_line text-xl"></i>
    </span>
  </button>


  <span class=" me-auto">
  </span>

  <div class="relative">

  </div>


  <div class="md:flex">
    <button data-toggle="fullscreen" type="button" class="nav-link p-2">
      <span class="sr-only">Pantalla Completa</span>
      <span class="flex items-center justify-center h-6 w-6">
        <i class="mgc_fullscreen_line text-2xl"></i>
      </span>
    </button>
  </div>


  <div class="flex">
    <button id="light-dark-mode" type="button" class="nav-link p-2">
      <span class="sr-only">Light/Dark Mode</span>
      <span class="flex items-center justify-center h-6 w-6">
        <i class="mgc_moon_line text-2xl"></i>
      </span>
    </button>
  </div>
  <div class="relative">
    <button data-fc-type="dropdown" data-fc-placement="bottom-end" type="button" class="nav-link p-2 fc-dropdown">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="text-2xl">
        <path fill="currentColor" d="M15.71 12.71a6 6 0 1 0-7.42 0a10 10 0 0 0-6.22 8.18a1 1 0 0 0 2 .22a8 8 0 0 1 15.9 0a1 1 0 0 0 1 .89h.11a1 1 0 0 0 .88-1.1a10 10 0 0 0-6.25-8.19M12 12a4 4 0 1 1 4-4a4 4 0 0 1-4 4" /></svg>
      </span>
    </button>
    <div class="fc-dropdown fc-dropdown-open:opacity-100 opacity-0 w-44 z-50 transition-[margin,opacity] duration-300 mt-2 bg-white shadow-lg border rounded-lg p-2 border-gray-200 dark:border-gray-700 dark:bg-gray-800 absolute hidden" style="left: -136px; top: 44px;">
      <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><rect width="24" height="24" fill="none"/><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 0 0-16 0"/></g></svg>
        <span><?php echo $_SESSION['usuario'] ?> </span>
      </a>
      <a class="flex items-center py-2 px-3 rounded-md text-sm text-gray-800 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-300">
        <i class="mgc_lock_line  me-2"></i>
        <span class="menu-text userChange" id="userChange">Cambiar Clave</span>
      </a>
    </div>
  </div>

</header>
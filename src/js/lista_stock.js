function toggleMenu(target, button) {
  // Buscar todos los elementos con esta clase (para menús principales)
  const menus = target.includes('-sub-') 
    ? [document.getElementById(target)] // Submenús por ID
    : document.querySelectorAll(`.${target}`); // Menús principales por clase

  if (!menus || menus.length === 0) {
    console.error('Elemento no encontrado:', target);
    return;
  }

  // Toggle para la flecha
  const arrow = button?.querySelector('.toggle-arrow');
  if (arrow) arrow.classList.toggle('rotate-45');

  // Alternar visibilidad de todos los elementos encontrados
  menus.forEach(menu => {
    if (menu) {
      const wasHidden = menu.classList.contains('hidden');
      menu.classList.toggle('hidden');

      // Si es menú principal y lo estamos cerrando, cerrar sus submenús
      if (!target.includes('-sub-') && !wasHidden) {
        const menuIndex = target.split('-')[1];
        document.querySelectorAll(`[id^="menu--${menuIndex}-sub-"]`).forEach(submenu => {
          submenu.classList.add('hidden');
        });
      }
    }
  });

  // Cerrar otros submenús del mismo grupo si es un submenú
  if (target.includes('-sub-')) {
    const parentTarget = target.split('-sub-')[0];
    document.querySelectorAll(`[id^="${parentTarget}-sub-"]`).forEach(otherMenu => {
      if (otherMenu.id !== target && !otherMenu.classList.contains('hidden')) {
        otherMenu.classList.add('hidden');
      }
    });
  }
}

// Cerrar menús al hacer clic fuera de ellos
document.addEventListener("click", function (event) {
  if (
    !event.target.closest('[class^="menu--"]') && // Cambiado para clases
    !event.target.closest('[id^="menu--"]') && // Mantenemos para submenús
    !event.target.closest(".toggle-row")
  ) {
    document.querySelectorAll('.toggle-arrow').forEach((arrow) => {
      arrow.classList.remove('rotate-45');
    });
    document.querySelectorAll('[class^="menu--"], [id^="menu--"]').forEach((menu) => {
      menu.classList.add('hidden');
    });
  }
});
// El resto del código permanece EXACTAMENTE igual
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll(".toggle-row").forEach(function (row) {
    row.addEventListener("click", function () {
      const target = row.getAttribute("data-target");
      if (target) {
        toggleMenu(target, row);
      }
    });
  });
});

document.getElementById("search-filter")?.addEventListener(
  "change",
  function (e) {
    const params = new URLSearchParams(window.location.search);
    (e.target.value == "all")
      ? params.delete("opcion")
      : params.set("opcion", e.target.value);
    console.log(params.toString());
    let nuevaURL = window.location.pathname;
    if (params.size > 0) {
      nuevaURL += "?" + params.toString();
    }
    window.location.href = nuevaURL;
  },
);

document.getElementById("searchInput").addEventListener(
  "keyup",
  function (e) {
    e.preventDefault();
    if (e.key == "Enter") {
      const params = new URLSearchParams(window.location.search);
      (e.target.value == "")
        ? params.delete("search")
        : params.set("search", e.target.value);
      let option = document.getElementById("searchOpcion")
        ? document.getElementById("searchOpcion").value
        : null;
      (option == null || option == "")
        ? params.delete("opcion")
        : params.set("opcion", option);
      let nuevaURL = window.location.pathname;
      if (params.size > 0) {
        nuevaURL += "?" + params.toString();
      }
      console.log(nuevaURL);
      window.location.href = nuevaURL;
    }
  },
);
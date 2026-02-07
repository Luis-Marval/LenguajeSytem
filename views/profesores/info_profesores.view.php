<?php
$title = "Ficha Profesor";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6  main-scroll">
  <div class="w-full flex justify-between mb-2">
    <h1 class="text-2xl mb-2 text-primary w-50 i"> Datos del profesor</h1>
    <div class="flex items-center gap-4">
      <button class="btn cursor-pointer bg-red-600" title="Eliminar Docente" data-cedula="<?php echo $profesor['cedula'] ?>">
        <svg xmlns="http://www.w3.org/2000/svg" class="text-white" width="24" height="24" viewBox="0 0 24 24">
          <path fill="currentColor" d="M7.616 20q-.691 0-1.153-.462T6 18.384V6H5V5h4v-.77h6V5h4v1h-1v12.385q0 .69-.462 1.153T16.384 20zm2.192-3h1V8h-1zm3.384 0h1V8h-1z" />
        </svg>
      </button>
      <a href="<?php echo PATH . 'profesor/actualizar?cedula=' . $profesor['cedula']; ?>" class="btn bg-primary text-white">Actualizar Datos</a>
    </div>
  </div>
  <div class="alertContainer">
    <?php require_once "./views/templates/message/success.php" ?>
    <?php require_once "./views/templates/message/error.php" ?>
  </div>
  <div class="card">
    <div class="p-6">
      <div class="overflow-x-auto">
        <section class="mb-4">
          <div class="grid grid-cols-1 md:grid-cols-1">
            <div class="card bg-white shadow-md rounded-lg p-4 round border border-secondary">
              <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                  <p><strong>Cedula:</strong>
                  </p>
                  <div class="border-solid border-2 p-2 bd-secondary flex justify-between">
                    <span id="cedula"><?php echo $profesor["nacionalidad"] . $profesor["cedula"] ?></span>
                  </div>
                </div>
                <div>
                  <p><strong>Nombre:</strong>
                  <div class="border-solid border-2 p-2 bd-secondary"><?php echo $profesor["nombre"] ?></div>
                  </p>
                </div>
                <div>
                  <p><strong>Apellido:</strong>
                  <div class="border-solid border-2 p-2 bd-secondary"><?php echo $profesor["apellido"] ?></div>
                  </p>
                </div>
              </div>
              <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                  <p><strong>correo:</strong>
                  <div class="border-solid border-2 p-2  bd-secondary"><?php echo $profesor["email"] ?></div>
                  </p>
                </div>
                <div>
                  <p><strong>Teléfono:</strong>
                  <div class="border-solid border-2 p-2  bd-secondary"><?php echo $profesor["telefono"] ?></div>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
  <div id="confirmModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg max-w-md w-full p-6">
      <h3 class="text-lg font-medium mb-4 text-gray-900 dark:text-gray-100">Confirmar eliminación</h3>
      <p id="confirmMessage" class="text-sm text-gray-700 dark:text-gray-300 mb-6">¿Seguro que desea eliminar este docente?</p>
      <div class="flex justify-end gap-3">
        <button id="cancelDelete" class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600">Cancelar</button>
        <button id="confirmDelete" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Eliminar</button>
      </div>
    </div>
  </div>
</main>
<script>
  (function() {
    const modal = document.getElementById('confirmModal');
    const confirmBtn = document.getElementById('confirmDelete');
    const cancelBtn = document.getElementById('cancelDelete');
    const confirmMessage = document.getElementById('confirmMessage');

    let targetUrl = null;
    let cedula = null

    function showModal(message, url) {
      targetUrl = url;
      confirmMessage.textContent = message;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function hideModal() {
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      targetUrl = null;
    }

    // Attach click handlers to all delete buttons
    document.querySelectorAll('button[title="Eliminar Docente"]').forEach(btn => {
      btn.addEventListener('click', (e) => {
        cedula = btn.dataset.cedula;
        const url = '<?php echo PATH . 'profesor/eliminar' ?>';
        // try to find row to remove visually after delete
        showModal('¿Desea eliminar al docente con cédula ' + cedula + '?', url);
      });
    });

    cancelBtn.addEventListener('click', hideModal);

    // Confirm deletion: send POST
    confirmBtn.addEventListener('click', async () => {
      if (!targetUrl) return hideModal();
      try {
        const response = await fetch(targetUrl, {
          method: 'POST',
          body: JSON.stringify({
            cedula: cedula
          }),
        });

        if (response.ok) {
          const data = await response.json();
          if (data.success == true) {
            window.location.href = '<?php echo PATH . 'profesor/listado' ?> '
          } else {
            new notificationsMessage('error', 'Profesor no se pudo eliminar');
            hideModal();
          }
        } else {
          hideModal();
          new notificationsMessage('error', 'Error al comunicarse con el servidor.');
        }
      } catch (err) {
        hideModal();
        new notificationsMessage('error', err.message)
      }
    });
  })();
  const cedula = document.getElementById("cedula");
  const btn = document.getElementById("eBtn");
  if (btn) {
    btn.addEventListener("click", function(e) {
      e.preventDefault();
      // Crear el fondo oscuro
      const overlay = document.createElement("div");
      overlay.style.position = "fixed";
      overlay.style.top = 0;
      overlay.style.left = 0;
      overlay.style.width = "100vw";
      overlay.style.height = "100vh";
      overlay.style.background = "rgba(0,0,0,0.5)";
      overlay.style.display = "flex";
      overlay.style.alignItems = "center";
      overlay.style.justifyContent = "center";
      overlay.style.zIndex = 9999;

      // Crear la ventana modal
      const modal = document.createElement("div");
      modal.style.background = "#fff";
      modal.style.padding = "2rem";
      modal.style.borderRadius = "8px";
      modal.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
      modal.style.minWidth = "300px";
      modal.innerHTML = `
        <h2 style="margin-bottom:1rem; font-size:1.2rem;">Editar Cédula</h2>
        <form id="cedulaForm">
          <input type="number" name="nueva_cedula" id="nuevaCedulaInput" class="form-input" placeholder="Nueva cédula" required style="width:100%;margin-bottom:1rem;" autofocus>
          <div style="display:flex; gap:1rem; justify-content:flex-end;">
            <button type="button" id="cancelarBtn" class="btn bg-gray-400 text-white">Cancelar</button>
            <button type="submit" class="btn bg-primary text-white">Guardar</button>
          </div>
        </form>
      `;

      overlay.appendChild(modal);
      document.body.appendChild(overlay);

      // Cerrar modal
      document.getElementById("cancelarBtn").onclick = function() {
        document.body.removeChild(overlay);

      };

      // Manejar submit
      document.getElementById("cedulaForm").onsubmit = async function(ev) {
        ev.preventDefault();
        const nuevaCedula = document.getElementById("nuevaCedulaInput").value;
        const fetcl = await fetch('<?php echo PATH . "profesor/info_profesor" ?>', {
          method: "POST",
          body: JSON.stringify({
            "cedulaAntigua": cedula.innerHTML.toLowerCase(),
            "cedulaNueva": nuevaCedula
          })
        });
        const datos = await fetcl.json();
        console.log(datos);
        if (!datos.hasOwnProperty("error")) {
          alert("cedula actualizada correctamente");
          window.location.href = `<?php echo PATH . "profesor/info_profesor?cedula=" ?>${nuevaCedula}`
        } else {
          alert(datos.error);
        }
        // Aquí puedes hacer un fetch/ajax para enviar la nueva cédula al backend o actualizar en el DOM

        // Por ahora solo actualizamos el span en pantalla:
        // Opcional: podrías mostrar un mensaje de éxito o recargar la página
      };
    });
  }
</script>
<?php echo $parte2; ?>
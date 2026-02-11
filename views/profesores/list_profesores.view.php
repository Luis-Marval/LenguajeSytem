<?php
$title = "lista de Profesores";
require_once "./views/view.struct.php";
echo $parte1;
?>
<main class="flex-grow p-6">

  <?php
  $titulo = 'Listado de profesores';
  $url = 'profesor/registro';
  $buttonTitle = 'Registrar Profesor';
  require_once "./views/templates/busqueda.php";
  ?>
  <div class="alertContainer">
    <?php require_once "./views/templates/message/success.php";
    require_once "./views/templates/message/error.php"; ?>
  </div>
  <div class="card">
    <div>
      <div class="overflow-x-auto p-3">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-200">
          <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-300 text-center border-b">
            <tr>
              <th scope="col" class="px-6 py-3">Cedula</th>
              <th scope="col" class="px-6 py-3">Nombres y Apellidos</th>
              <th scope="col" class="px-6 py-3">Teléfono</th>
              <th scope="col" class="px-6 py-3">correo</th>
              <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php foreach ($lista as $lista): ?>
              <tr class="border-b border-black filas-row" id='<?php echo $lista['cedula'] ?>'>
                <td scope="col" class="px-6 py-3"><?php echo $lista["tipoDocumento"] . $lista["cedula"] ?></td>
                <td scope="col" class="px-6 py-3"><?php echo $lista["nombre"] . " " . $lista["apellido"]; ?></td>
                <td scope="col" class="px-6 py-3"><?php echo $lista["telefono"]; ?></td>
                <td scope="col" class="px-6 py-3 truncate"><?php echo $lista["email"]; ?></td>
                <td scope="col" class="px-6 py-3 flex justify-center">
                  <?php $model = 'profesor'; ?>
                  <a href="<?php echo PATH . $model . '/info?cedula=' . $lista['cedula'] ?>" class="p-2 bg-blue-100 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors" title="Informacion del Docente">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M11.5 16.5h1V11h-1zm.5-6.923q.262 0 .439-.177t.176-.439t-.177-.438T12 8.346t-.438.177t-.177.439t.177.438t.438.177M12.003 21q-1.867 0-3.51-.708q-1.643-.709-2.859-1.924t-1.925-2.856T3 12.003t.709-3.51Q4.417 6.85 5.63 5.634t2.857-1.925T11.997 3t3.51.709q1.643.708 2.859 1.922t1.925 2.857t.709 3.509t-.708 3.51t-1.924 2.859t-2.856 1.925t-3.509.709" />
                    </svg>
                  </a>
                  <a href="<?php echo PATH . $model . '/actualizar?cedula=' . $lista['cedula'] ?>" class="p-2 text-amber-600 hover:bg-amber-100 dark:text-amber-400 dark:hover:bg-amber-900/30 rounded-lg transition-colors" title="Actualizar Datos">
                    <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M4 20v-2.52L17.18 4.288q.155-.137.34-.212T17.907 4t.39.064q.19.063.35.228l1.067 1.074q.165.159.226.35q.06.19.06.38q0 .204-.068.39q-.069.185-.218.339L6.519 20zM17.504 7.589L19 6.111L17.889 5l-1.477 1.496z" />
                    </svg>
                  </a>
                  <button class="p-2 text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/30 rounded-lg transition-colors" title="Eliminar Docente" data-cedula="<?php echo $lista['cedula'] ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M7.616 20q-.691 0-1.153-.462T6 18.384V6H5V5h4v-.77h6V5h4v1h-1v12.385q0 .69-.462 1.153T16.384 20zm2.192-3h1V8h-1zm3.384 0h1V8h-1z" />
                    </svg>
                  </button>
                </td>
              </tr>
            <?php endforeach;  ?>
          </tbody>
        </table>
          <div class="w-full text-sm text-left text-gray-500 dark:text-gray-200 flex justify-between align-center mt-2">
            <div>
              <form action="<?php echo CompleteURL ?>" method="get" class="flex  line0">
                <label for="rowForPage">Filas Por Pagina:</label>
                <div class="relative">
                  <select id="rowForPage" name="porPaginas" class="">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                  </select>
                </div>
              </form>
            </div>
            <div class="flex gap-25px">
              <p><?php echo ($cantidadActual ?? '0'); ?>-<?php echo ($cantidadFinal ?? '0'); ?> de <?php echo ($total ?? '0'); ?></p>
              <div class="">
                <button class="" id="before" tabindex="-1" type="button" <?php if (!empty($page) && $page == 1) {
                                                                            echo 'disabled';
                                                                          } ?> aria-label="Pagina Anterior" title="Pagina Anterior">
                  <svg class="" focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"></path>
                  </svg>
                </button>
                <button class="" id="after" tabindex="0" type="button" <?php if (!empty($page) && $page == $pages) {
                                                                          echo 'disabled';
                                                                        } ?> aria-label="Siguiente Pagina" title="Siguiente Pagina">
                  <svg class="" focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
      </div>
    </div>
  </div>
  <!-- Modal de confirmación -->
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
  const pages = <?php echo $pages ?>;
  const page = <?php echo $page ?>;

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
            new notificationsMessage('success', 'Profesor eliminado correctamente');
            const tr = document.getElementById(cedula);
            tr.remove();
            hideModal();
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
</script>
<?php echo $parte2 ?>
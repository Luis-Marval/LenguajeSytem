<?php
$title = "Inscripciones";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 main-scroll">
  <div class="mb-2 flex items-center">
    <h1 class="text-2xl text-primary w-50 i"> Inscripciones </h1>

    <form class='w-50'>
      <input type='search' class='block w-search p-3 pl-5 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 form-input' id='searchInput' name='search' placeholder='Busqueda...' />

    </form>
  </div>
  <!-- Contenedor de notificaciones -->
  <div class="alertContainer">
    <?php require_once "./views/templates/message/error.php";
    require_once "./views/templates/message/success.php"; ?>
  </div>

  <div class="flex flex-col gap-6">
  </div>
  <div class="flex flex-col">
    <div class="card w-full">
      <div class="p-3 w-full overflow-x-auto">
        <table class="w-full table-fixed text-sm text-gray-500 dark:text-gray-500 text-center">
          <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-300py-3">
            <tr class="">
              <th scope="col" class="px-2 py-3">Idioma</th>
              <th scope="col" class="px-2 py-3 w-12 text-center">Nivel</th>
              <th scope="col" class="px-2 py-3">Tipo</th>
              <th scope="col" class="px-2 py-3" >Horario</th>

              <th scope="col" class="px-2 py-3">Modalidad</th>
              <th scope="col" class="px-2 py-3">Inicio</th>
              <th scope="col" class="px-2 py-3">Fin</th>
              <th scope="col" class="px-2 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody id="tabla-resultados" class="text-xs text-gray-600 dark:text-gray-300">
            <?php if (isset($lista)): ?>
              <?php foreach ($lista as $lista): ?>
                <tr class="border-b border-black filas-row py-3">
                  <td scope="col" class="px-2"><?php echo $lista["name"] ?></td>
                  <td scope="col" class="px-2 w-12 text-center"><?php echo $lista["nivel"] ?></td>
                  <td scope="col" class="px-2"><?php echo $lista["horario"] ?></td>
                  <td scope="col" class="px-2"><?php echo $lista["tipo"] ?></td>
                  <td scope="col" class="px-2"><?php echo $lista["modalidad"] ?></td>
                  <td scope="col" class="px-2 noellipsis"><?php echo (new DateTime($lista["horaInicio"]))->format('h:i:s a')
                                                    ?></td>
                  <td scope="col" class="px-2"><?php echo (new DateTime($lista["horaFin"]))->format('h:i:s a') ?></td>
                  <td scope="col" class=" flex justify-center">
                    <form method="get" action="<?php echo PATH . 'clases/periodo' ?>" class="p-2 bg-blue-100 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                      <button value="<?php echo $lista['id'] ?>" name="idClass" title="Inscribir Alumnos">
<svg xmlns="http://www.w3.org/2000/svg" class="list-accion"  width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"><path d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12m10-8a8 8 0 1 0 0 16a8 8 0 0 0 0-16"/><path d="M13 7a1 1 0 1 0-2 0v4H7a1 1 0 1 0 0 2h4v4a1 1 0 1 0 2 0v-4h4a1 1 0 1 0 0-2h-4z"/></g></svg>
                      </button>
                    </form>
                    <?php
                    if (!empty($lista['idPeriodo']) && $lista['ultimoPeriodo'] == 1 && $lista['idProfesor'] != null && ($estudiate->countEstudiantes($lista['idPeriodo'])) > 0): ?>
                      <form method="post" action="<?php echo PATH . 'clases/listadoClase' ?>" class="p-2 bg-blue-100 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                        <button value="<?php echo $lista['idPeriodo'] ?>" name="idPeriodo" title="Generar Listado">
                          <svg xmlns="http://www.w3.org/2000/svg" class="list-accion" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M18 3H6v4h12m1 5a1 1 0 0 1-1-1a1 1 0 0 1 1-1a1 1 0 0 1 1 1a1 1 0 0 1-1 1m-3 7H8v-5h8m3-6H5a3 3 0 0 0-3 3v6h4v4h12v-4h4v-6a3 3 0 0 0-3-3"></path>
                          </svg>
                        </button>
                      </form>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
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
</main>

<script>
  const pages = <?php echo isset($pages) ? $pages : 1; ?>;
  const page = <?php echo isset($page) ? $page : 1; ?>;

  document.addEventListener('DOMContentLoaded', function() {
    const filas = document.querySelectorAll('.estudiante-row');

    filas.forEach(fila => {
      fila.addEventListener('click', function(e) {
        // Evitar que se active si se hace click en un botón/enlace dentro de la fila
        if (e.target.tagName === 'BUTTON' || e.target.tagName === 'A') {
          return;
        }

        const cedula = this.getAttribute('data-cedula');
        window.location.href = `/estudiantes/info_estudiante?cedula=${encodeURIComponent(cedula)}`;
      });

      // Efecto visual al pasar el mouse
      fila.addEventListener('mouseenter', function() {
        this.style.backgroundColor = '#f3f4f6'; // gray-100
      });

      fila.addEventListener('mouseleave', function() {
        this.style.backgroundColor = '';
      });
    });
  });
</script>
<?php echo $parte2; ?>
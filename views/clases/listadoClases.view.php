<?php
$title = "Lista de Clases";
require_once "./views/view.struct.php";
echo $parte1; ?>

<main class="flex-grow p-6 main-scroll">
  <?php
  $titulo = 'Lista de clases';
  $url = 'clases/crear';
  $buttonTitle = 'Crear Clase';
  require_once "./views/templates/busqueda.php";
  ?>
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
        <table class="w-full text-sm text-gray-500 dark:text-gray-500 text-center">
          <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
            <tr class="">
              <th scope="col" class="px-2 py-3">Idioma</th>
              <th scope="col" class="px-2 py-3  w-12 text-center">Nivel</th>
              <th scope="col" class="px-2 py-3">Tipo</th>
              <th scope="col" class="px-2 py-3">Horario</th>

              <th scope="col" class="px-2 py-3">Modalidad</th>
              <th scope="col" class="px-2 py-3">Inicio</th>
              <th scope="col" class="px-2 py-3">Fin</th>
              <th scope="col" class="px-2 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody id="tabla-resultados" class="text-xs text-gray-700 border-b border-black filas-row  dark:text-white">
            <?php if (isset($lista)): ?>
              <?php foreach ($lista as $lista): ?>
                <tr class="border-b border-black filas-row">
                  <td scope="col" class="px-2 "><?php echo $lista["name"] ?></td>
                  <td scope="col" class="px-2  w-12 text-center"><?php echo $lista["Nivel"] ?></td>
                  <td scope="col" class="px-2 "><?php echo $lista["horario"] ?></td>
                  <td scope="col" class="px-2"><?php echo $lista["tipo"] ?></td>

                  <td scope="col" class="px-2"><?php echo $lista["modalidad"] ?></td>
                  <td scope="col" class="px-2"><?php echo (new DateTime($lista["horaInicio"]))->format('h:i:s a')
                                                    ?></td>
                  <td scope="col" class="px-2"><?php echo (new DateTime($lista["horaFin"]))->format('h:i:s a') ?></td>
                  <td scope="col" class="px-2 flex justify-center">
                    <form method="get" action="<?php echo PATH . 'clases/listado' ?>" class="p-2 bg-blue-100 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors group">
                      <button value="<?php echo $lista['id'] ?>" name="idClase" title="Generar Listado">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1024" height="1024" viewBox="0 0 1024 1024">
                          <path fill="currentColor" d="M704 192h160v736H160V192h160v64h384zM288 512h448v-64H288zm0 256h448v-64H288zm96-576V96h256v96z"></path>
                        </svg>
                      </button>
                    </form>

                    <a href="<?php echo PATH . 'clases/actualizar?id=' . $lista['id'] ?>" class="p-2 text-amber-600 hover:bg-amber-100 dark:text-amber-400 dark:hover:bg-amber-900/30 rounded-lg transition-colors group relative"" title="Actualizar Datos">
                      <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4 20v-2.52L17.18 4.288q.155-.137.34-.212T17.907 4t.39.064q.19.063.35.228l1.067 1.074q.165.159.226.35q.06.19.06.38q0 .204-.068.39q-.069.185-.218.339L6.519 20zM17.504 7.589L19 6.111L17.889 5l-1.477 1.496z" />
                      </svg>
                    </a>
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
  const pages = <?php echo $pages ?>;
  const page = <?php echo $page ?>;
</script>
<?php echo $parte2; ?>
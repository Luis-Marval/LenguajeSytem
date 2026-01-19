<?php
$title = "lista de Estudiantes";
require_once "./views/view.struct.php";
echo $parte1;
?>
<main class="flex-grow p-6">
  <?php 
    $titulo = 'Listado de Estudiantes';
    $url = 'estudiantes/registro';
    $buttonTitle = 'Registrar Alumno';
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
          <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-white text-center border-b">
            <tr>
              <th scope="col" class="px-6 py-3">Cedula</th>
              <th scope="col" class="px-6 py-3">Nombres</th>
              <th scope="col" class="px-6 py-3">Fecha de Nacimiento</th>
              <th scope="col" class="px-6 py-3">Telefono</th>
              <th scope="col" class="px-6 py-3">Correo</th>
              <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
          </thead>
          <tbody class="text-center dark:text-white text-black">
            <?php foreach ($lista as $lista): ?>
              <tr class="border-b border-black dark:border-black filas-row" data-cedula=<?php echo $lista["cedula"] ?>>
                <td scope="col" class="px-6 py-3"><?php echo $lista["nacionalidad"] . $lista["cedula"] ?></td>
                <td scope="col" class="px-6 py-3"><?php echo $lista["nombre"] . " " . $lista["apellido"]; ?></td>
                <td scope="col" class="px-6 py-3"><?php echo (new DateTime($lista["fecha_nacimiento"]))->format('d/m/Y'); ?></td>
                <td scope="col" class="px-6 py-3"><?php echo $lista["telefono"]; ?></td>
                <td scope="col" class="px-6 py-3"><?php echo $lista["email"]; ?></td>
                <td scope="col" class="px-6 py-3">
                  <?php $model = 'estudiantes'; ?>
                  <a href="<?php echo PATH . $model . '/info?cedula=' . $lista['cedula'] ?>" class="btn cursor-pointer p-0 out-0" title="Informacion del Docente">
                    <svg xmlns="http://www.w3.org/2000/svg" class="list-accion" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M11.5 16.5h1V11h-1zm.5-6.923q.262 0 .439-.177t.176-.439t-.177-.438T12 8.346t-.438.177t-.177.439t.177.438t.438.177M12.003 21q-1.867 0-3.51-.708q-1.643-.709-2.859-1.924t-1.925-2.856T3 12.003t.709-3.51Q4.417 6.85 5.63 5.634t2.857-1.925T11.997 3t3.51.709q1.643.708 2.859 1.922t1.925 2.857t.709 3.509t-.708 3.51t-1.924 2.859t-2.856 1.925t-3.509.709" />
                    </svg>
                  </a>
                  <a href="<?php echo PATH . $model . '/actualizar?cedula=' . $lista['cedula'] ?>" class="btn cursor-pointer p-0 out-0" title="Actualizar Datos">
                    <svg xmlns="http://www.w3.org/2000/svg" class="list-accion" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M4 20v-2.52L17.18 4.288q.155-.137.34-.212T17.907 4t.39.064q.19.063.35.228l1.067 1.074q.165.159.226.35q.06.19.06.38q0 .204-.068.39q-.069.185-.218.339L6.519 20zM17.504 7.589L19 6.111L17.889 5l-1.477 1.496z" />
                    </svg>
                  </a>
                </td>
              </tr>
            <?php endforeach;  ?>
          </tbody>
        </table>
        <div class="w-full text-sm text-left text-gray-500 dark:text-white flex justify-end align-center line0 gap40 mt-2">
          <form action="<?php echo CompleteURL ?>" method="get" class="flex line0">
            <label for="rowForPage">Filas Por Pagina:</label>
            <div class="relative">
              <select id="rowForPage" name="porPaginas" class="">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="20">20</option>
                <option value="50">50</option>
              </select>
            </div>
          </form>
          <p><?php echo ($cantidadActual ?? '0'); ?>-<?php echo ($cantidadFinal ?? '0'); ?> de <?php echo ($total ?? '0'); ?></p>
          <div class="">
            <button class="" id="before" tabindex="-1" type="button" <?php if ($page == 1) {
                                                                        echo 'disabled';
                                                                      } ?> aria-label="Pagina Anterior" title="Pagina Anterior">
              <svg class="" focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"></path>
              </svg>
            </button>
            <button class="" id="after" tabindex="0" type="button" <?php if ($page == $pages) {
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
  <script>
    const pages = <?php echo $pages ?>;
    const page = <?php echo $page ?>;
  </script>
</main>
<?php echo $parte2 ?>
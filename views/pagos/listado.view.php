<?php
$title = "Pagos";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 relative main-scroll">
  <div class="alertContainer">
    <?php require_once "./views/templates/message/error.php";
    require_once "./views/templates/message/success.php"; ?>
  </div>

  <?php if (!empty($pendientes)) : ?>
    <h2 class="text-2xl text-primary dark:text-primary align-middle ">Pagos pendientes</h2>
    <div class="card w-full mt-2  mb-6 p-3">
      <table  class="w-full text-sm text-gray-500 dark:text-gray-500 text-center table-auto min-w-full">
        <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-white">
          <tr class="text-sm font-semibold font-sans py-1">
            <th class="px-6 py-3">Cédula</th>
            <th class="px-6 py-3">Nombre</th>
            <th class="px-6 py-3">Idioma / Nivel</th>
            <th class="px-6 py-3">Registrar Abono</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php foreach ($pendientes as $est) : ?>
            <tr class="text-black font-semibold font-sans dark:text-white">
              <td class="px-6 py-3"><?php echo htmlspecialchars($est['cedula'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="px-6 py-3"><?php echo htmlspecialchars(($est['nombre'] ?? '') . ' ' . ($est['apellido'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
              <td class="px-6 py-3"><?php echo $est['nombre_idioma'] . " / " . $est['nivel'] ?></td>
              <td class="px-6 py-3">
                <a
                  href="<?= PATH ?>pagos/abono?epi=<?= htmlspecialchars($est['estudiante_periodo_id'] ?? '') ?>"
                  class="btn bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded flex items-center gap-2 justify-center inline-flex">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 6C7.03 6 2 7.546 2 10.5v4C2 17.454 7.03 19 12 19s10-1.546 10-4.5v-4C22 7.546 16.97 6 12 6m-8 8.5v-1.197a10 10 0 0 0 2 .86v1.881c-1.312-.514-2-1.126-2-1.544m12 .148v1.971c-.867.179-1.867.31-3 .358v-2a22 22 0 0 0 3-.329m-5 2.33a19 19 0 0 1-3-.358v-1.971c.959.174 1.972.287 3 .33zm7-.934v-1.881a10 10 0 0 0 2-.86V14.5c0 .418-.687 1.03-2 1.544" />
                  </svg>
                   Ver / Registrar
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>


  <div class="flex justify-between w-full items-center px-2 mb-2">
    <h2 class="text-2xl text-primary dark:text-primary align-middle">Listado de Pagos</h2>
    <button type="button" class="text-xs text-gray-500" onclick="
      const el = document.getElementById('tabla-pagos-realizados');
      if (el) el.classList.toggle('hidden');
    ">
      Mostrar / ocultar
    </button>
  </div>
  <div class="card w-full mt-2 mb-4">


    <?php if (empty($pagos)) : ?>
      <p class="py-4 text-center">No hay pagos registrados.</p>
    <?php else : ?>
      <?php
      // Ocultar por defecto si hay pendientes
      $hiddenClass = !empty($pendientes) ? 'hidden' : '';
      ?>
      <div id="tabla-pagos-realizados" class="mt-2 p-3 w-full overflow-x-auto <?php echo $hiddenClass; ?>">
        <table class="w-full text-sm text-gray-500 dark:text-gray-500 text-center">
          <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-300">
            <tr class="text-sm font-semibold font-sans py-1">
              <th class="px-6 py-3">Fecha</th>
              <th class="px-6 py-3">Cédula</th>
              <th class="px-6 py-3">Nombre</th>
              <th class="px-6 py-3">Idioma / Nivel</th>
              <th class="px-6 py-3">Monto</th>
              <th class="px-6 py-3">Tipo</th>
            </tr>
          </thead>
          <tbody class="text-xs text-gray-600 dark:text-gray-300">
            <?php foreach ($pagos as $pago) : ?>
              <tr class="border-b border-black filas-row">
                <td class="px-6 py-3"><?php echo htmlspecialchars($pago['fecha_pago'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="px-6 py-3"><?php echo htmlspecialchars($pago['cedula'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="px-6 py-3"><?php echo htmlspecialchars(($pago['nombre'] ?? '') . ' ' . ($pago['apellido'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                <td class="px-6 py-3"><?php echo htmlspecialchars($pago['nombre_idioma'] ?? '', ENT_QUOTES, 'UTF-8') . ' / ' . $pago['nivel']; ?></td>
                <td class="px-6 py-3"><?php echo $pago['monto'];
                                      echo $pago['moneda'] == 'Dolar' ? '$' : 'Bs' ?></td>
                <td><?php echo htmlspecialchars($pago['tipo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
        <div class="w-full text-sm text-left text-gray-500 dark:text-white flex justify-end items-center gap-4 mt-2">
          <form action="<?php echo CompleteURL ?>" method="get" class="flex items-center gap-2">
            <label for="rowForPage" class="text-xs">Filas por página:</label>
            <select id="rowForPage" name="PorPagina" class="text-xs border rounded px-1 py-0.5" onchange="this.form.submit()">
              <option value="5" <?php echo ($porPagina == 5 ? 'selected' : ''); ?>>5</option>
              <option value="10" <?php echo ($porPagina == 10 ? 'selected' : ''); ?>>10</option>
              <option value="20" <?php echo ($porPagina == 20 ? 'selected' : ''); ?>>20</option>
              <option value="50" <?php echo ($porPagina == 50 ? 'selected' : ''); ?>>50</option>
            </select>
          </form>
          <p class="text-xs"><?php echo ($cantidadActual ?? 0); ?>-<?php echo ($cantidadFinal ?? 0); ?> de <?php echo ($total ?? 0); ?></p>
          <div class="flex justify-end text-lg gap-1">
            <?php if ($numeroPaginas > 1): ?>
              <?php if ($pagina > 1): ?>
                <a href="<?php echo $PATH . 'pagos/listado?pagina=' . "1" ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
                  inicio
                </a>
                <a href="<?php echo  $PATH . 'pagos/listado?pagina=' . $anterior ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
                  anterior
                </a>
              <?php endif ?>
              <?php foreach ($nums as $num): ?>
                <a href="<?php echo $PATH . 'pagos/listado?pagina=' . $num ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
                  <?php echo $num ?>
                </a>
              <?php endforeach ?>
              <?php if ($pagina < $numeroPaginas): ?>
                <a href="<?php echo  $PATH . 'pagos/listado?pagina=' . $siguiente ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
                  siguiente
                </a>
                <a href="<?php echo  $PATH . 'pagos/listado?pagina=' . $numeroPaginas ?>" class="btn bg-primary text-white mt-2  font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-" style='  '>
                  fin
                </a>
              <?php endif ?>
            <?php endif ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>


</main>
<?php echo $parte2; ?>
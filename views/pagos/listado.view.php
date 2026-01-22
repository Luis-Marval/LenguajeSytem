<?php
$title = "Pagos";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 relative main-scroll">
  <div class="alertContainer">
    <?php require_once "./views/templates/message/error.php";
    require_once "./views/templates/message/success.php"; ?>
  </div>
  <div class="card w-full mt-2 mb-4">
    <div class="flex justify-between w-full items-center px-2 mb-2">
      <h2 class="text-primary dark:text-primary align-middle">Pagos realizados</h2>
      <button type="button" class="text-xs text-gray-500" onclick="
        const el = document.getElementById('tabla-pagos-realizados');
        if (el) el.classList.toggle('hidden');
      ">
        Mostrar / ocultar
      </button>
    </div>

    <?php if (empty($pagos)) : ?>
      <p class="py-4 text-center">No hay pagos registrados.</p>
    <?php else : ?>
      <?php
        // Ocultar por defecto si hay pendientes
        $hiddenClass = !empty($pendientes) ? 'hidden' : '';
      ?>
      <div id="tabla-pagos-realizados" class="mt-2 <?php echo $hiddenClass; ?>">
        <table class="table-auto min-w-full w-full mt-2 mb-2">
          <thead class="text-xs text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-400 mb-2">
            <tr class="text-sm font-semibold font-sans py-1">
              <th>Fecha</th>
              <th>Cédula</th>
              <th>Nombre</th>
              <th>Idioma / Clase</th>
              <th>Monto</th>
              <th>Moneda</th>
              <th>Estado</th>
              <th>Tipo</th>
              <th>Comentario</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php foreach ($pagos as $pago) : ?>
              <tr class="text-black font-semibold font-sans">
                <td><?php echo htmlspecialchars($pago['fecha_pago'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pago['cedula'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars(($pago['nombre'] ?? '') . ' ' . ($pago['apellido'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pago['nombre_idioma'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo number_format((float)($pago['monto'] ?? 0), 2, ',', '.'); ?></td>
                <td><?php echo htmlspecialchars($pago['moneda'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pago['estado_pago'] ?? '', ENT_QUOTES, 'UTF-8'); ?>%</td>
                <td><?php echo htmlspecialchars($pago['tipo'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($pago['comentario'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
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
          <?php
            $reference = PATH . 'pagos/listado?pagina=';
            require './views/templates/paginacion.php';
          ?>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <div class="card w-full mt-2">
    <div class="flex justify-between w-full items-center px-2 mb-2">
      <h2 class="text-primary dark:text-primary align-middle">Estudiantes pendientes / 60%</h2>
    </div>
    <table class="table-auto min-w-full w-full mt-4 mb-2">
      <thead class="text-xs text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-400 mb-2">
        <tr class="text-sm font-semibold font-sans py-1">
          <th>Cédula</th>
          <th>Nombre</th>
          <th>Idioma / Clase</th>
          <th>Estado pago</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php if (empty($pendientes)) : ?>
          <tr>
            <td colspan="4" class="py-4">No hay estudiantes pendientes ni con 60%.</td>
          </tr>
        <?php else : ?>
          <?php foreach ($pendientes as $est) : ?>
            <tr class="text-black font-semibold font-sans">
              <td><?php echo htmlspecialchars($est['cedula'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars(($est['nombre'] ?? '') . ' ' . ($est['apellido'] ?? ''), ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($est['nombre_idioma'] ?? '', ENT_QUOTES, 'UTF-8'); ?></td>
              <td><?php echo htmlspecialchars($est['estado_pago'] ?? 'pendiente', ENT_QUOTES, 'UTF-8'); ?>%</td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>
<?php echo $parte2; ?>

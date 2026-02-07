<?php
$title = "Registrar Abono";
require_once "./views/view.struct.php";
echo $parte1;
?>

<main class="flex-grow p-6 relative main-scroll">
  <div class="alertContainer">
    <?php require_once "./views/templates/message/error.php";
    require_once "./views/templates/message/success.php"; ?>
  </div>

  <div class="p-5 border-b dark:border-gray-700 pt-0">
    <h2 class="text-2xl font-bold text-primary">
      Registrar Abono - <?= htmlspecialchars($inscripcion['nombre'] . ' ' . $inscripcion['apellido']) ?>
    </h2>
    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
      <?= htmlspecialchars($inscripcion['idioma']) ?> - Nivel <?= htmlspecialchars($inscripcion['nivel']) ?>
    </p>
  </div>
  <div class="card w-full max-w-5xl mx-auto">

    <!-- Formulario -->
    <div class="p-6">
      <form method="POST" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <input type="hidden" value="<?php echo $epi ?>" name="epi">
          <div>
            <label class="block text-sm font-medium mb-1">Monto *</label>
            <input type="number" name="monto" step="0.01" min="0.01" required
              class="w-full border rounded px-4 py-2 dark:bg-gray-700">
          </div>
          <div>
            <label class="block text-sm font-medium mb-1">Moneda</label>
            <select name="moneda" class="w-full border rounded px-4 py-2 dark:bg-gray-700">
              <option value="Dolar" selected>Dólar (USD)</option>
              <option value="Bolivar">Bolívar</option>
            </select>
          </div>
        </div>

        <div class="flex justify-end gap-4">
          <a href="<?= PATH ?>pagos/listado"
            class="px-6 py-2 border rounded hover:bg-gray-100 dark:hover:bg-gray-700">
            Cancelar
          </a>
          <button type="submit"
            class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
            Guardar Abono
          </button>
        </div>
      </form>
    </div>

    <!-- Historial -->
    <div class="p-6 border-t dark:border-gray-700">
      <h3 class="text-xl font-semibold mb-4">Historial de pagos en esta session</h3>

      <?php if (empty($historial)): ?>
        <p class="text-center py-8 text-gray-500">No hay pagos registrados aún.</p>
      <?php else: ?>
        <div class="overflow-x-auto">
          <table class="min-w-full">
            <thead class="bg-gray-100 dark:bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium">Fecha</th>
                <th class="px-6 py-3 text-left text-xs font-medium">Monto</th>
                <th class="px-6 py-3 text-left text-xs font-medium">Tipo</th>
              </tr>
            </thead>
            <tbody class="">
              <?php foreach ($historial as $pago): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-600">
                  <td class="px-6 py-4 whitespace-nowrap"><?php $fecha = new DateTime($pago['fecha_pago']); 
  echo $fecha->format('Y-m-d h:i:s A'); ?></td>
                  <td class="px-6 py-4"><?php echo $pago['monto'].$pago['moneda'] === 'Dolar' ? 'USD' : 'Bs' ?></td>
                  <td class="px-6 py-4"><?= htmlspecialchars($pago['tipo']) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <!-- Totales pagados + Botón Completar -->
        <div class="p-6 border-t dark:border-gray-700 bg-gray-50 dark:bg-gray-600">
          <h3 class="text-lg font-semibold mb-4">Resumen de pagos realizados</h3>

          <div class="grid grid-cols-1 sm:grid-cols-3">
            <div class="w-full grid grid-cols-2 gap-2">
              <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow-sm border dark:border-gray-600">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total en Dólares</p>
                <p class="text-2xl font-bold text-green-600">
                  $ <?= number_format($totales['Dolar'] ?? 0, 2) ?>
                </p>
              </div>

              <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow-sm border dark:border-gray-600">
                <p class="text-sm text-gray-600 dark:text-gray-400">Total en Bolívares</p>
                <p class="text-2xl font-bold text-green-600">
                  Bs <?= number_format($totales['Bolivar'] ?? 0, 2) ?>
                </p>
              </div>
            </div>

            <form method="POST" class="text-center">
              <input type="hidden" name="action" value="completar_pago">
              <input type="hidden" name="epi"  value="<?php echo $epi ?>">

              <button type="submit"
                onclick="return confirm('¿Realmente desea marcar este session como COMPLETADO?');"
                class="mt-3 px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded font-medium shadow">
                Completar Pago
              </button>
            </form>
          </div>
        </div>

        <!-- Luego continúa con el historial de pagos -->
      <?php endif; ?>
    </div>
  </div>
</main>

<?php echo $parte2; ?>
<?php if (isset($prolongados) && $prolongados !== false): ?>
  <?php require_once "./views/templates/message/error.php"; ?>
  <div class="mt-6">
    <div class="overflow-x-auto">
      <section class="mb-4">
        <div class="grid grid-cols-1 md:grid-cols-1">
          <div class="text-xl font-semibold titulo-datos">
            <h2 class="select">Lista de Prolongados</h2>
          </div>
          <div class="data p-6">
            <?php if ($status): ?>
              <span>
                <strong>Fecha de Vencimiento:</strong><?php echo $fecha_vencimiento ?>
              </span><br>
            <?php endif; ?>
            <?php foreach ($prolongados as $prolongado): ?>
              <span>
                <?php echo $prolongado['patologia'] ?>
                <div class="men-table">
                  <table class="offBorder">
                    <?php foreach ($prolongado['medicamentos'] as $medicamento): ?>

                      <tr class="text-center">
                        <td><?php echo $medicamento['principio_activo'] ?></td>
                        <td><?php echo $medicamento['presentacion'] ?></td>
                        <td><?php echo $medicamento['cantidad_presentacion'] . " Unidades" ?></td>
                        <td><?php echo $medicamento['concentracion'] ?></td>
                        <td><?php echo $medicamento['nombre_prestador'] ?></td>
                        <?php if (!$status): ?>
                          <td><button class="delete_informe btn bg-red-500 text-white px-3 py-1 rounded" value="<?php echo $medicamento['id'] ?>">X</button></td>
                        <?php endif; ?>

                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
              </span>
            <?php endforeach; ?>
          </div>
        </div>
        <?php if (!$status): ?>
          <form action="<?php echo PATH . "paciente/cerrar_informe?cedula=" . $cedula ?>" method="POST" class="col-span-3 text-center"> <button class="btn bg-primary text-white hover:bg-blue-700 mt-2" name="cedula" value="<?php echo $cedula ?>">Cerrar Informe</button></form>
        <?php endif; ?>
      </section>
    </div>
  </div>
  <script>
    const buttons = document.querySelectorAll(".delete_informe");
    buttons.forEach(function(button) {
      button.addEventListener("click", async function(e) {
        const result = await fetch(`<?php echo PATH ?>paciente/eliminar_informe?value=${this.value}`)
        if (!result.ok) {
          alert("error al eliminar el informe")
        } else {
          window.location.reload()
        }
      })
    })
  </script>
<?php endif; ?>
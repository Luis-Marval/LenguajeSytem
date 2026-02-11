<?php
$title = "Ficha Estudiante";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 main-scroll">

  <div class="w-full flex justify-between mb-2 items-center">
    <h1 class="text-2xl mb-2 text-primary w-50 i"> Datos del estudiante</h1>
    <a href="<?php echo PATH . 'estudiantes/actualizar?cedula=' . $estudiante['cedula']; ?>" class="btn bg-primary text-white">Actualizar Datos</a>
  </div>
  <?php require_once "./views/templates/message/success.php" ?>
  <?php require_once "./views/templates/message/error.php" ?>
  <div class="card bg-white shadow-md rounded-lg ">
    <div class="p-6">
      <div class="overflow-x-auto">
        <section class="">
          <div class="grid grid-cols-1 md:grid-cols-1">
            <div class="grid grid-cols-3 gap-4">
              <div>
                <p><strong>Cedula:</strong>
                </p>
                <div class="border-solid border-2 p-2 bd-secondary flex justify-between">
                  <span id="cedula"><?php echo $estudiante["tipoDocumento"] . $estudiante["cedula"] ?></span>
                </div>
              </div>
              <div>
                <p><strong>Nombre:</strong>
                <div class="border-solid border-2 p-2 bd-secondary"><?php echo $estudiante["nombre"] ?></div>
                </p>
              </div>
              <div>
                <p><strong>Apellido:</strong>
                <div class="border-solid border-2 p-2 bd-secondary"><?php echo $estudiante["apellido"] ?></div>
                </p>
              </div>
            </div>
            <div class="grid grid-cols-3 gap-4 mb-4">
              <div>
                <p>
                  <strong>Fecha de Nacimiento:</strong>
                <div class="border-solid border-2 p-2  bd-secondary"><?php echo date("d/m/Y", strtotime($estudiante["fecha_nacimiento"])) ?></div>
                </p>
              </div>

              <div>
                <p><strong>correo:</strong>
                <div class="border-solid border-2 p-2  bd-secondary"><?php echo $estudiante["email"] ?></div>
                </p>
              </div>
              <div>
                <p><strong>Teléfono:</strong>
                <div class="border-solid border-2 p-2  bd-secondary"><?php echo $estudiante["telefono"] ?></div>
                </p>
              </div>
            </div>
            <div class="grid grid-cols-4 gap-4 mb-4">
              <div class="">
                <p><strong>Nacionalidad:</strong></p>
                <div class="border-solid border-2 p-2  bd-secondary col-end-1">
                  <?php 
                      if($estudiante["nacionalidad"] == 'V')echo 'Venezolano';
                      if($estudiante["nacionalidad"] == 'E')echo 'Extranjero';
                  ?></div>
              </div>
              <div class="col-start-2 col-end-5">
                <p><strong>Direccion:</strong></p>
                <div class="border-solid border-2 p-2  bd-secondary "><?php echo $estudiante["residencia"] ?></div>
              </div>
            </div>
          </div>
          <?php //if ((is_array($informe) && $informe['status'] != 1)): 
          ?>
          <?php require_once "./controller/estudiantes/list_class.php" ?>
          <?php //endif; 
          ?>
        </section>
        <?php //endif; 
        ?>
      </div>
    </div>
  </div>
</main>
<script>
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
        const fetcl = await fetch('<?php echo PATH . "Estudiante/info_Estudiante" ?>', {
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
          window.location.href = `<?php echo PATH . "Estudiante/info_Estudiante?cedula=" ?>${nuevaCedula}`
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
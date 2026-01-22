<?php
$title = "Datos de la Clase";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 main-scroll">

  <div class="w-full flex justify-between mb-2">
    <h1 class="text-4xl mb-2 text-primary w-50 i"> Datos de la clase</h1>
  </div>
  <?php require_once "./views/templates/message/success.php" ?>
  <?php require_once "./views/templates/message/error.php" ?>
  <div class="card bg-white shadow-md rounded-lg ">
    <div class="p-6">
      <div class="overflow-x-auto">
        <section class="">
          <div class="grid grid-cols-3 gap-4 mb-4">
            <div>
              <p><strong>Idioma:</strong>
              </p>
              <div class="border-solid border-2 p-2 bd-secondary flex justify-between">
                <span id="cedula"><?php echo $datos["name"]  ?></span>
              </div>
            </div>
            <div>
              <p><strong>horario:</strong>
              <div class="border-solid border-2 p-2 bd-secondary"><?php echo $datos["tipo"] ?></div>
              </p>
            </div>
            <div>
              <p><strong>tipo:</strong>
              <div class="border-solid border-2 p-2 bd-secondary"><?php echo $datos["horario"] ?></div>
              </p>
            </div>
          </div>
          <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
              <p>
                <strong>Nivel:</strong>
              <div class="border-solid border-2 p-2  bd-secondary"><?php echo $datos["Nivel"] ?></div>
              </p>
            </div>
            <div>
              <p><strong>Costo:</strong>
              <div class="border-solid border-2 p-2  bd-secondary"><?php echo $datos["monto"] ?></div>
              </p>
            </div>
            <div>
              <p>
                <strong>Hora de Inicio:</strong>
              <div class="border-solid border-2 p-2  bd-secondary"><?php echo $datos["horaInicio"] ?></div>
              </p>
            </div>

            <div>
              <p>
                <strong>Hora de Finalizacion:</strong>
              <div class="border-solid border-2 p-2  bd-secondary"><?php echo $datos["horaFin"] ?></div>
              </p>
            </div>
          </div>
      </div>
      </section>
    </div>
  </div>
  </div>
</main><?php echo $parte2; ?>
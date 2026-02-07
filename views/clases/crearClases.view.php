<?php
$title = "Crear Clases";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="p-6">
  <div class="min-h-min mb-4">
    <h1 class="text-2xl text-primary">Crear Clase</h1>
  </div>
  <div class="flex flex-col gap-6">
    <div class="card">
      <div class="p-6">
        <form method="POST" action="<?php echo CompleteURL ?>" class="" id="form-medicamento">
          <div class="w-full grid grid-cols-3 gap-4">
            <div class="">
              <label for="idioma" class="text-gray-800 text-sm font-medium inline-block mb-2">Idioma:</label>
              <select type="text" id="horario" class="form-select" title="Seleccione el idioma" name="idioma" d="idioma" autocomplete="off" required>
                <?php foreach ($idiomas as $idioma): ?>
                  <option value=<?php echo $idioma['id'] ?>><?php echo ucfirst($idioma['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="mb-2">
              <label for="horario" class="text-gray-800 text-sm font-medium inline-block mb-2">Tipo:</label>
              <select type="text" id="horario" class="form-select" name="horario" title="Seleccione el Tipo de la clase" required>
                <option value="1">Intensivo</option>
                <option value="2">Semi-Intensivo</option>
                <option value="5">Sabatino</option>
                <option value="3">Regular</option>
                <option value="4">Semi-Regular</option>
              </select>
            </div>
            <div class="">
              <label for="tipo" class="text-gray-800 text-sm font-medium inline-block mb-2">Horario:</label>
              <select id="tipo" class="form-select" name="tipo" title="Seleccione el Tipo de la clase" required>
                <option value="matutino">Matutino</option>
                <option value="vespertino">Vespertino</option>
                <option value="nocturno">Nocturno</option>
              </select>
            </div>
          </div>
          <div class="w-full grid grid-cols-3 gap-4">
            <div>
              <label for="modalidad" class="text-gray-800 text-sm font-medium inline-block mb-2">Modalidad:</label>
              <select id="modalidad" class="form-select" name="modalidad" title="Seleccione la modalidad de la clase" required>
                <option value="presencial">Presencial</option>
                <option value="online">Online</option>
                <option value="mixto">Mixto</option>
              </select>
            </div>
            <div>
              <label for="nivel" class="text-gray-800 text-sm font-medium inline-block mb-2">Nivel:</label>
              <input type="number" step="1" class="form-input" name="nivel" id="nivel" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required>
            </div>
            <div>
              <label for="costo" class="text-gray-800 text-sm font-medium inline-block mb-2">Costo:</label>
              <input type="number" step="1" class="form-input" name="costo" id="costo" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required>
            </div>
          </div>
          <div class="w-full grid grid-cols-2 gap-4">
            <div>
              <label for="horaInicio" class="text-gray-800 text-sm font-medium inline-block mb-2">Hora de Inicio:</label>
              <input type="time" step="1" class="form-input" name="horaInicio" id="horaInicio" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required>
            </div>
            <div>
              <label for="horaFin" class="text-gray-800 text-sm font-medium inline-block mb-2">Hora de Finalizacion:</label>
              <input type="time" step="1" class="form-input" name="horaFin" id="horaFin" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required>
            </div>
          </div>
      </div>
    </div>
    <div class="my-2 text-center">
      <button type="submit" class="btn bg-primary text-white hover:bg-blue-700" id="sweetalert-success"> Crear Clase </button>
    </div>

    </form>
  </div>
  </div>
  <div class="alertContainer">
    <?php require_once "./views/templates/message/error.php"; ?>
  </div>
  </div>
</main>
<?php echo $parte2; ?>
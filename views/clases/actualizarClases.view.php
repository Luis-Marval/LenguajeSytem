<?php
$title = "Actualizar Estudiante";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6">
  <div class="min-h-min mb-8">
    <h1 class="text-2xl text-primary">
      Actualizar Estudiante
    </h1>
  </div>
  <div class='alertContainer'>

    <?php require_once "./views/templates/message/error.php"; ?>
  </div>
  <div class="flex flex-col gap-6">
    <div class="card">
      <div class="p-6">
        <form method="POST" action="<?php echo CompleteURL ?>" class="" id="form-medicamento">
          <div class="w-full grid grid-cols-3 gap-4">
            <div class="">
              <label for="idioma" class="text-gray-800 text-sm font-medium inline-block mb-2">Idioma:</label>
              <select type="text" id="idioma" class="form-select" title="Seleccione el idioma" name="idioma" d="idioma" autocomplete="off" required>
                <?php foreach ($idiomas as $idioma): ?>
                  <option value=<?php echo $idioma['id']; if($idioma['name'] == $res['name']) echo ' selected' ?> ><?php echo ucfirst($idioma['name']) ?></option>
                <?php endforeach; ?>
              </select>
              <input type="hidden" name="id" id="id" value=" <?php echo $res['id']; ?> ">
            </div>
            <div class="mb-2">
              <label for="horario" class="text-gray-800 text-sm font-medium inline-block mb-2">Tipo:</label>
              <select type="text" id="horario" class="form-select" name="horario" title="Seleccione el Tipo de la clase" required>
                <option value="1" <?php if($res['horario'] == 'intensivo')echo 'selected'; ?> >Intensivo</option>
                <option value="2" <?php if($res['horario'] == 'semi-intensivo')echo 'selected'; ?> >Semi-Intensivo</option>
                <option value="5" <?php if($res['horario'] == 'sabatino')echo 'selected'; ?> >Sabatino</option>
                <option value="3" <?php if($res['horario'] == 'regular')echo 'selected'; ?> >Regular</option>
                <option value="4" <?php if($res['horario'] == 'semi-regular')echo 'selected'; ?> >Semi-Regular</option>
              </select>
            </div>
            <div class="">
              <label for="tipo" class="text-gray-800 text-sm font-medium inline-block mb-2">Horario:</label>
              <select id="tipo" class="form-select" name="tipo" title="Seleccione el Tipo de la clase" required>
                <option value="matutino" <?php if($res['tipo'] == 'matutino')echo 'selected'; ?> >Matutino</option>
                <option value="vespertino" <?php if($res['tipo'] == 'vespertino')echo 'selected'; ?> >Vespertino</option>
                <option value="nocturno" <?php if($res['tipo'] == 'nocturno')echo 'selected'; ?> >Nocturno</option>
              </select>
            </div>
          </div>
          <div class="w-full grid grid-cols-3 gap-4">
            <div>
              <label for="modalidad" class="text-gray-800 text-sm font-medium inline-block mb-2">Madalidad:</label>
              <select id="modalidad" class="form-select" name="modalidad" title="Seleccione la modalidad de la clase" required>
                <option value="presencial" <?php if($res['modalidad'] == 'presencial')echo 'selected'; ?> >Presencial</option>
                <option value="online" <?php if($res['modalidad'] == 'online')echo 'selected'; ?> >Online</option>
                <option value="mixto" <?php if($res['modalidad'] == 'mixto')echo 'selected'; ?> >Mixto</option>
              </select>
            </div>
            <div>
              <label for="nivel" class="text-gray-800 text-sm font-medium inline-block mb-2">Nivel:</label>
              <input type="number" step="1" class="form-input" name="nivel" id="nivel" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" value="<?php echo $res['Nivel']?>" required>
            </div>
            <div>
              <label for="costo" class="text-gray-800 text-sm font-medium inline-block mb-2">Costo:</label>
              <input type="number" step="1" class="form-input" name="costo" id="costo" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" value="<?php echo $res['monto']?>"  required>
            </div>
          </div>
          <div class="w-full grid grid-cols-2 gap-4">
            <div>
              <label for="horaInicio" class="text-gray-800 text-sm font-medium inline-block mb-2">Hora de Inicio:</label>
              <input type="time" step="1" class="form-input" name="horaInicio" id="horaInicio" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" value="<?php echo (new DateTime($res['horaInicio']))->format('H:i')?>"  required>
            </div>
            <div>
              <label for="horaFin" class="text-gray-800 text-sm font-medium inline-block mb-2">Hora de Finalizacion:</label>
              <input type="time" step="1" class="form-input" name="horaFin" id="horaInicio" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" value="<?php echo (new DateTime($res['horaFin']))->format('H:i') ?>"  required>
            </div>
          </div>
      </div>
    </div>
    <div class="my-2 text-center">
      <button type="submit" class="btn bg-primary text-white hover:bg-blue-700" id="sweetalert-success"> Actualizar Datos </button>
    </div>

    </form>
  </div>
</main>
<?php echo $parte2; ?>
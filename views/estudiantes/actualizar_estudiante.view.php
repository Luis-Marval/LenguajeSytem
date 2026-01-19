<?php
$title = "Actualizar Estudiante";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6">
  <div class="min-h-min mb-8">
    <h1 class="text-4xl text-primary text-center">
      Actualizar Estudiante
    </h1>
  </div>
  <div class='alertContainer'>

    <?php require_once "./views/templates/message/error.php"; ?>
  </div>
  <div class="flex flex-col gap-6">
    <div class="card">
      <div class="p-6">
        <form method="POST" enctype="multipart/form-data" action="<?php echo CompleteURL ?>" class="grid lg:grid-cols-3 gap-6">
          <div>
            <label for="cedula" class="text-gray-800 text-sm font-medium inline-block mb-2">Cedula:</label>
            <input type="number" step="1" class="form-input" id="cedula" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cedula" disabled aria-disabled="true" value="<?php echo $res['cedula'] ?>">
            <input type="hidden" value="<?php echo $res['cedula'] ?>" name="cedula">
          </div>
          <div>
            <label for="input-nombre" class="text-gray-800 text-sm font-medium inline-block mb-2">Nombre:</label>
            <input type="text" id="input-nombre" class="form-input" name="nombre" pattern="[a-zA-Z0-9._%+-]" title="Ingresa el nombre del paciente." required value="<?php echo trim($res['nombre']) ?>">
          </div>
          <div>
            <label for="input-apellido" class="text-gray-800 text-sm font-medium inline-block mb-2">Apellido:</label>
            <input type="text" step="1" id="input-apellido" class="form-input" name="apellido" pattern="[a-zA-Z0-9._%+-]" required value="<?php echo trim($res['apellido']) ?>">
          </div>
          <div>
            <label for="input-nacimiento" class="text-gray-800 text-sm font-medium inline-block mb-2">Fecha de Nacimiento:</label>
            <input type="date" id="input-nacimiento" class="form-input" name="fecha_nacimiento" title="Ingresa la fecha de nacimiento del paciente" required value="<?php echo ($res['fecha_nacimiento']) ?>">
          </div>
          <div>
            <label for="input-telefono" class="text-gray-800 text-sm font-medium inline-block mb-2">Telefono:</label>
            <input type="number" id="input-telefono" class="form-input" name="telefono" required value="<?php echo trim($res['telefono']) ?>">
          </div>
          <div>
            <label for="input-correo" class="text-gray-800 text-sm font-medium inline-block mb-2">Correo:</label>
            <input id="input-correo" class="form-input" name="correo" required autofocus type="email" value="<?php echo trim($res['email']) ?>">
          </div>
          <div>
            <label for="input-nacionalidad" class="text-gray-800 text-sm font-medium inline-block mb-2">Nacionalidad:</label>
            <select id="input-nacionalidad" class="form-input" name="nacionalidad" required autofocus>
              <option value='V' <?php if ($res['nacionalidad'] == "V") echo 'selected'; ?>>Venezolano</option>
              <option value='E' <?php if ($res['nacionalidad'] == "E")  echo 'selected'; ?>>Extranjero</option>
            </select>
          </div>
          <div>
            <label for="input-parentesco" class="text-gray-800 text-sm font-medium inline-block mb-2">Residencia:</label>
            <textarea class="form-input" id="input-parentesco" name="Residencia" title="Ingresa el parentesco con el militar"  required><?php echo trim($res['residencia']) ?></textarea>
          </div>
          <div>
            <label for="input-file" class="text-gray-800 text-sm font-medium inline-block mb-2">Imagen de la cedula:</label>
            <input id="input-file" class="form-input" name="file" title="" type="file" accept="image/*">
          </div>
          <div class="col-span-3 text-center mb-5">
            <button type="submit" class="btn bg-primary text-white hover:bg-blue-700">Actualizar</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</main>
<?php echo $parte2; ?>
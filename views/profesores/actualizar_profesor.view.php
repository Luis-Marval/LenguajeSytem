<?php
$title = "Actualizar Profesor";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6">
  <div class="min-h-min mb-8">
    <h1 class="text-2xl text-primary text-center">
      Actualizar Profesor
    </h1>
  </div>
  <div class='alertContainer'>

    <?php require_once "./views/templates/message/error.php"; ?>
  </div>
  <div class="flex flex-col gap-6">
    <div class="card">
      <div class="p-6">
        <form method="POST" action="<?php echo CompleteURL ?>" class="grid lg:grid-cols-3 gap-6">
          <div>
            <div>
              <label for="cedula" class="text-gray-800 text-sm font-medium inline-block mb-2">Cedula:</label>
              <div class="grid grid-cols-2 grid-40-full">
                <div class="short-select">
                  <select id="input-tipoDocumento" class="form-input w-40" name="tipoDocumento" required autofocus title="Tipo de Documento">
                    <option value='V' <?php if ($res['tipoDocumento'] == "V") echo 'selected'; ?> >V - Venezolano </option>
                    <option value='E' <?php if ($res['tipoDocumento'] == "E") echo 'selected'; ?> >E - Extranjero</option>
                    <option value='P' <?php if ($res['tipoDocumento'] == "P") echo 'selected'; ?> >P - Pasaporte</option>
                  </select>
                </div>
                <input type="text" class="form-input" id="cedula" title="Ingresa la cedula" disabled aria-disabled="true" value="<?php echo ($res['TipoDocumento'] ?? "V") . $res['cedula'] ?>">
                <input type="hidden" value="<?php echo $res['cedula'] ?>" name="cedula">
              </div>
            </div>
          </div>
          <div>
            <label for="input-nombre" class="text-gray-800 text-sm font-medium inline-block mb-2">Nombre:</label>
            <input type="text" id="input-nombre" class="form-input" name="nombre" pattern="[a-zA-Z0-9._%+-]" title="Ingresa el nombre del paciente." required  value="<?php echo trim($res['nombre'])?>">
          </div>
          <div>
            <label for="input-apellido" class="text-gray-800 text-sm font-medium inline-block mb-2">Apellido:</label>
            <input type="text" step="1" id="input-apellido" class="form-input" name="apellido" pattern="[a-zA-Z0-9._%+-]" required value="<?php echo trim($res['apellido'])?>">
          </div>
          <div>
            <label for="input-telefono" class="text-gray-800 text-sm font-medium inline-block mb-2">Teléfono:</label>
            <input type="number" id="input-telefono" class="form-input" name="telefono" required value="<?php echo trim($res['telefono'])?>"> 
          </div>
          <div>
            <label for="input-correo" class="text-gray-800 text-sm font-medium inline-block mb-2">Correo:</label>
            <input id="input-correo" class="form-input" name="correo" required autofocus type="email" value="<?php echo trim($res['email'])?>">
          </div>
          <div>
            <label for="input-nacionalidad" class="text-gray-800 text-sm font-medium inline-block mb-2">Nacionalidad:</label>
            <select id="input-nacionalidad" class="form-input" name="nacionalidad" required autofocus>
              <option value='V' <?php if($res['nacionalidad'] == "V" ) echo 'selected';?> >Venezolano</option>
              <option value='E' <?php if($res['nacionalidad'] == "E" )  echo 'selected';?> >Extranjero</option>
            </select>
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
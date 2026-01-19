<?php
$title = "Medicamentos Prolongados";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 main-scroll">
  <div class="min-h-min mb-4">
    <div>
      <h1 class="text-4xl text-primary w-50 inBlock">Medicamentos</h1>
    </div>
  </div>
  <?php require_once "./views/templates/message/success.php" ?>
  <div class="card">
    <div class="p-6">
      <div class="overflow-x-auto">
        <section class="mb-4">
          <div class="grid grid-cols-1 md:grid-cols-1">
            <div class="text-xl font-semibold titulo-datos">
              <form method="GET" class="btn" action="<?php echo PATH . "paciente/info_paciente"?>"><button class="w-full">Datos del Paciente</button>
              <input type="hidden" name="cedula" value="<?php echo $cedula?>">
            </form>
              <h2 class="btn select" >Medicamentos Prolongados</h2>
            </div>
            <div class="card bg-white shadow-md rounded-lg p-4 data">
              <form method="POST" action="<?php echo CompleteURL ?>" class="grid lg:grid-cols-3 gap-6">
              <div>
                  <label for="tipo-select" class="text-gray-800 text-sm font-medium inline-block mb-2">Patologia</label>
                  <select class="form-select" id="patologia-select" name="patologia">
                    <option>Elige la patologia</option>
                    <?php foreach ($patologias as $prestador): ?>
                      <option value="<?php echo $prestador['id_patologia'] ?>"><?php echo $prestador['descripcion_patologia'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div>
                  <label for="input-principio" class="text-gray-800 text-sm font-medium inline-block mb-2">Principio Activo:</label>
                  <select class="form-select" id="input-principio" name="principio_activo" title="Ingresa el principio activo." required  focus>
                      <option value="null">Elige un Principio Activo</option>
                      <?php foreach ($principios as $principio): ?>
                        <option value="<?php echo $principio['codigo_medicamento']; ?>"><?php echo $principio['principio_activo']; ?></option>
                      <?php endforeach; ?>
                  </select>
                </div>

                <div>
                  <label for="input-cantidad" class="text-gray-800 text-sm font-medium inline-block mb-2">Presentacion:</label>
                  <select type="text" id="input-cantidad" class="form-input" name="presentacion" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la presentacion" required>
                    <option value="tabletas">Tabletas</option>

                    <option value="comprimidos">Comprimidos</option>
                    <option value="cápsulas">Cápsulas</option>
                    <option value="grageas">Grageas</option>
                    <option value="pastillas masticables">Pastillas masticables</option>
                    <option value="polvos">Polvos</option>
                    <option value="granulados">Granulados</option>
                    <option value="supositorios">Supositorios</option>
                    <option value="óvulos">Óvulos</option>
                    <option value="jarabes">Jarabes</option>
                    <option value="suspensiones">Suspensiones</option>
                    <option value="gotas orales">Gotas orales</option>
                    <option value="soluciones inyectables">Soluciones inyectables</option>
                    <option value="tónicos">Tónicos</option>
                    <option value="colirios">Colirios</option>
                    <option value="gotas nasales/otológicas">Gotas nasales/otológicas</option>
                    <option value="pomadas">Pomadas</option>
                    <option value="cremas">Cremas</option>
                    <option value="geles">Geles</option>
                    <option value="parches transdérmicos">Parches transdérmicos</option>
                    <option value="aerosoles">Aerosoles</option>
                    <option value="inhaladores">Inhaladores</option>
                    <option value="implantes">Implantes</option>
                    <option value="chicles medicados">Chicles medicados</option>
                  </select>
                </div>

                <div>
                  <label for="input-presentacion" class="text-gray-800 text-sm font-medium inline-block mb-2">cantidad de presentacion:</label>
                  <input type="number" step="1" id="input-presentacion" class="form-input" name="cantidadXpresentacion" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required >
                </div>
                <div>
                  <label for="input-concentracion" class="text-gray-800 text-sm font-medium inline-block mb-2">Concentracion:</label>
                  <input type="text" step="1" id="input-concentracion" class="form-input" name="concentracion" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la concentracion" required >
                </div>
                <div>
                  <label for="tipo-select" class="text-gray-800 text-sm font-medium inline-block mb-2">Prestador</label>
                  <select class="form-select" id="tipo-select" name="tipoMedicamento">
                    <?php foreach ($prestadores as $prestador): ?>
                      <option value="<?php echo $prestador['id_prestador'] ?>"><?php echo $prestador['nombre_prestador'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>

                <?php require_once "./views/templates/message/error.php"; ?>
                <div class="col-span-3 text-center">
                  <button type="submit" class="btn bg-primary text-white hover:bg-blue-700" id="sweetalert-success" name="cedula" value="<?php echo $cedula?>">Cargar Medicamento</button>
                </div>
              </form>
            </div>
          </div>
        </section>
      </div>
    </div>
      <div class="px-6"> 
        <?php require_once "./controller/estudiantes/informe.php"?>
      </div>
  </div>
</main>
<?php echo $parte2; ?>
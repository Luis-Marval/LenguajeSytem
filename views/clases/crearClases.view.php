<?php
$title = "Crear Clases";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="p-6">
  <div class="min-h-min mb-8">
    <h1 class="text-4xl text-primary text-center"> Clase</h1>
  </div>
  <div class="flex flex-col gap-6">
    <div class="card">
      <div class="p-6">
        <form method="POST" action="<?php echo CompleteURL ?>" class="" id="form-medicamento">
          <div class="w-full grid grid-cols-2 gap-4">
            <div class="">
              <label for="idioma" class="text-gray-800 text-sm font-medium inline-block mb-2">Idioma:</label>
              <select type="text" id="horario" class="form-select" title="Seleccione el idioma" name="idioma" d="idioma" autocomplete="off" required>
                <?php foreach ($idiomas as $idioma): ?>
                  <option value=<?php echo $idioma['id'] ?>><?php echo ucfirst($idioma['name']) ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label for="nivel" class="text-gray-800 text-sm font-medium inline-block mb-2">Nivel</label>
              <input type="number" step="1" class="form-input" name="nivel" id="nivel" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required>
            </div>

            <div class="mb-2">
              <label for="horario" class="text-gray-800 text-sm font-medium inline-block mb-2">tipo:</label>
              <select type="text" id="horario" class="form-input" name="horario" title="Seleccione el Tipo de la clase" required>
                <option value="1">Intensivo</option>
                <option value="2">Semi-Intensivo</option>
                <option value="5">Sabatino</option>
                <option value="3">Regular</option>
                <option value="4">Semi-Regular</option>
              </select>
            </div>

            <div class="">
              <label for="tipo" class="text-gray-800 text-sm font-medium inline-block mb-2">horario:</label>
              <select type="text" id="tipo" class="form-input" name="tipo" title="Seleccione el Tipo de la clase" required>
                <option value="matutino">Matutino</option>
                <option value="vespertino">Vespertino</option>
                <option value="nocturno">Nocturno</option>
              </select>
            </div>
            <div>
              <label for="horaInicio" class="text-gray-800 text-sm font-medium inline-block mb-2">Hora de Inicio:</label>
              <input type="time" step="1" class="form-input" name="horaInicio" id="horaInicio" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required>
            </div>
            <div>
              <label for="horaFin" class="text-gray-800 text-sm font-medium inline-block mb-2">Hora de Finalizacion</label>
              <input type="time" step="1" class="form-input" name="horaFin" id="horaFin" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad que posee la presentacion" required>
            </div>
            <div>
                <label for="clasesXnivel" class="text-gray-800 text-sm font-medium inline-block mb-2">Clases Por Nivel:</label>
                <input type="number" step="1" class="form-input" name="clasesXnivel" id="clasesXnivel" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad de clases de este nivel" required>
              </div>
              <div>
                <label for="dias" class="text-gray-800 text-sm font-medium inline-block mb-2">Dias Trabajados</label>
                <input type="number" step="1" class="form-input" name="dias" id="dias" pattern="[a-zA-Z0-9._%+-]" title="Ingresa la cantidad de dias trabajados a la semana" required>
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
<script>
  // Opciones disponibles (pueden venir de una API, JSON, etc.)
  const optionsFromPHP = <?php echo $principios_json = json_encode($principios); ?>;
  localStorage.setItem('autocompleteOptions', JSON.stringify(optionsFromPHP));

  const savedOptions = localStorage.getItem('autocompleteOptions');
  const optios = savedOptions ? JSON.parse(savedOptions) : [];
  const val = document.getElementById("real-value")
  const input = document.getElementById("input-principio");
  const dropdown = document.getElementById("dropdown-options");
  const btnNuevoPrincipio = document.getElementById("btn-nuevo-principio");
  const modalNuevoPrincipio = document.getElementById("modal-nuevo-principio");
  const cerrarModalPrincipio = document.getElementById("cerrar-modal-principio");
  const formNuevoPrincipio = document.getElementById("form-nuevo-principio");
  const errorNuevoPrincipio = document.getElementById("error-nuevo-principio");

  // Detectar si el principio activo existe
  function existePrincipio(nombre) {
    return optios.some(opt => opt.principio_activo.toLowerCase() === nombre.toLowerCase());
  }
  input.addEventListener("click", function() {
    if (!input.value) {
      showDropdown(optios);
    }
  });

  input.addEventListener("input", function() {
    const encontrado = optios.find(opt => opt.principio_activo.toLowerCase() === input.value.toLowerCase());
    if (encontrado) {
      val.value = encontrado.codigo_medicamento;
      btnNuevoPrincipio.style.display = "none";
    } else {
      val.value = "";
      // Mostrar/ocultar botón de nuevo principio
      if (input.value && !existePrincipio(input.value)) {
        btnNuevoPrincipio.style.display = "inline-block";
      } else {
        btnNuevoPrincipio.style.display = "none";
      }
    }
    // Filtrar y mostrar opciones del dropdown
    filterOptions(this.value.toLowerCase());
  });

  btnNuevoPrincipio.addEventListener("click", function() {
    document.getElementById("nuevo-principio").value = input.value;
    modalNuevoPrincipio.style.display = "flex";
  });

  cerrarModalPrincipio.addEventListener("click", function() {
    modalNuevoPrincipio.style.display = "none";
    errorNuevoPrincipio.textContent = '';
  });

  formNuevoPrincipio.addEventListener("submit", function(e) {
    e.preventDefault();
    errorNuevoPrincipio.textContent = '';
    const data = new FormData(formNuevoPrincipio);
    fetch('/IPSFANB/inventario/registar_principio', {
        method: 'POST',
        body: data
      })
      .then(resp => resp.text())
      .then(resp => {
        try {
          const json = JSON.parse(resp);
          if (json.success) {
            optios.push({
              principio_activo: data.get('principio_activo'),
              codigo_medicamento: data.get('codigo_medicamento')
            });
            localStorage.setItem('autocompleteOptions', JSON.stringify(optios));
            input.value = data.get('principio_activo');
            val.value = data.get('codigo_medicamento');
            modalNuevoPrincipio.style.display = "none";
            btnNuevoPrincipio.style.display = "none";
          } else {
            errorNuevoPrincipio.textContent = json.error;
          }
        } catch {
          errorNuevoPrincipio.textContent = 'Error inesperado.';
        }
      })
      .catch(() => {
        errorNuevoPrincipio.textContent = 'Error de conexión.';
      });
  });

  // Función para filtrar y mostrar opciones
  function filterOptions(searchTerm) {
    if (!searchTerm) {
      dropdown.style.display = "none";
      return;
    }
    const filteredOptions = optios.filter(opt =>
      opt.principio_activo.toLowerCase().includes(searchTerm)
    );

    showDropdown(filteredOptions);
  }

  // Función para renderizar opciones en el dropdown
  function showDropdown(optionsToShow) {
    dropdown.innerHTML = "";

    if (optionsToShow.length === 0) {
      dropdown.style.display = "none";
      return;
    }

    optionsToShow.forEach(optios => {
      const optionElement = document.createElement("div");
      optionElement.textContent = optios.principio_activo;
      optionElement.dataset.value = optios.codigo_medicamento;
      optionElement.classList.add("dropdown-item");
      optionElement.addEventListener("click", () => {
        input.value = optios.principio_activo;
        input.dataset.selectedValue = optios.codigo_medicamento;
        dropdown.style.display = "none";
        val.value = optios.codigo_medicamento;
        btnNuevoPrincipio.style.display = "none";
      });
      dropdown.appendChild(optionElement);
    });

    dropdown.style.display = "block";
  }

  // Ocultar dropdown al hacer clic fuera
  document.addEventListener("click", (e) => {
    if (e.target !== input) {
      dropdown.style.display = "none";
    }
  });
  window.addEventListener('beforeunload', function() {
    if (window.location.href.includes('/inventario/registro')) {
      localStorage.removeItem('autocompleteOptions');
    }
  });

  function getParam(name) {
    const url = new URL(window.location.href);
    return url.searchParams.get(name);
  }

  window.addEventListener('DOMContentLoaded', function() {
    const id = getParam('id');
    if (id) {
      // Busca el principio activo por código_medicamento
      const encontrado = optios.find(opt => String(opt.codigo_medicamento) === String(id));
      if (encontrado) {
        input.value = encontrado.principio_activo;
        val.value = encontrado.codigo_medicamento;
        btnNuevoPrincipio.style.display = "none";
      }
    }
  });
</script>
<?php echo $parte2; ?>
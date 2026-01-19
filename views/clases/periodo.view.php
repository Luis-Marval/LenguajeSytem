<?php
$title = "Inscripciones";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 relative">
  <!-- Contenedor de notificaciones -->
  <div class="alertContainer">
    <?php require_once "./views/templates/message/error.php";
    require_once "./views/templates/message/success.php"; ?>
  </div>
  <div class="flex flex-col gap-6">
    <div class="flex flex-col">
      <div class="card w-full mb-4">
        <div class="p-3 w-full overflow-x-auto" style="position: relative; overflow: visible;">
          <div id="form-medicamento">
            <h1>Datos de la Clase</h1>
            <div class="w-full grid grid-cols-4 gap-4">
              <div class="">
                <label for="idioma" class="text-gray-800 text-sm font-medium inline-block mb-2">Idioma:</label>
                <input type="text" id="horario" class="form-input" id="idioma" value="<?php echo $clase["name"] ?>" disabled>
              </div>
              <div>
                <label for="nivel" class="text-gray-800 text-sm font-medium inline-block mb-2">Nivel</label>
                <input type="number" class="form-input" id="nivel" value="<?php echo $clase["nivel"] ?>" disabled>
              </div>
              <div class="mb-2">
                <label for="horario" class="text-gray-800 text-sm font-medium inline-block mb-2">horario:</label>
                <input type="text" id="horario" class="form-input" value="<?php echo $clase["horario"] ?>" disabled>
                </input>
              </div>
              <div class="mb-2">
                <label for="tipo" class="text-gray-800 text-sm font-medium inline-block mb-2">tipo:</label>
                <input type="text" id="tipo" class="form-input" value="<?php echo $clase["tipo"] ?>" disabled>
                </input>
              </div>
            </div>
          </div>
          <div>
            <div class="grid grid-cols-1">
              <div class="autocomplete-container">
                <label for="input-principio" class="text-gray-800 text-sm font-medium inline-block mb-2">Profesor</label>
                <input type="text" class="form-select" id="input-principio" title="Ingresa el profesor" required name="principio" autocomplete="off" value="">
                <div id="dropdown-options" class="dropdown-options"></div>
                <input type="hidden" id="periodo" value="<?php echo $periodo[0]['id'] ?>" name="periodo">
              </div>
            </div>

          </div>
        </div>
      </div>
      <div class="card w-full mt-2">
        <div class="flex justify-between w-full items-center px-2">
          <h2 class="text-black align-middle"> Alumnos Inscritos</h2>
          <button type="button" id="agregar"
            class="btn mt-2 mb-2 bg-primary text-white disabled:bg-gray-400 disabled:cursor-not-allowed">
            +
          </button>
        </div>
        <table class="table-auto min-w-full w-full mt-4 mb-2">
          <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-400  mb-2">
            <tr class="text-black text-sm font-semibold font-sans">
              <th>Cedula</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody id="tabla-resultados" class="text-center">
          </tbody>
        </table>
      </div>
    </div>
  </div>
  </div>
  <div id="modal-producto" class="hidden absolute inset-0 bg-black bg-opacity-50 flex justify-end items-center ">
    <div class="bg-white p-6 rounded-xl product-list ">
      <div class="flex justify-between items-start mb-4">
        <h2 class="text-xl text-black font-bold" style="font-size: 24px;">Listado de estudiantes</h2>
        <button onclick="toggleModal()" style="background-color: #dc2626; color: white; padding: 6px 12px; font-size: 14px; font-weight: bold; border-radius: 4px; border: none; cursor: pointer; font-weight: 700"> X
        </button>
      </div>

      <div>
        <input type="text" id="buscar-alumno-input" placeholder="Buscar..." class="form-control w-auto rounded-md text-black font-bold" name="productoPrincipio">
        <button class="btn bg-primary text-white font-bold hover:bg-blue-900" type="submit" id="buscar-alumno-btn">Buscar estudiante particular</button>
      </div>

      <div class="card w-full">
        <table class="table-auto min-w-full w-full mt-4">
          <thead class="text-xs text-gray-700 bg-gray-200 dark:bg-gray-700 dark:text-gray-400 mb-2">
            <tr class="text-black text-sm font-semibold font-sans">
              <th>Cedula</th>
              <th>Nombre</th>
              <th>Apellido</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody id="tabla-alumnos" class="text-center">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</main>
<div id="confirm-change-modal" class="hidden absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center ">
  <div class="bg-white p-6 rounded-xl" style="max-width:520px; width:90%;">
    <div class="flex justify-between items-start mb-4">
      <h2 class="text-xl text-black font-bold">Estudiante ya inscrito</h2>
      <button onclick="hideChangeModal()" style="background-color: #dc2626; color: white; padding: 6px 12px; font-size: 14px; font-weight: bold; border-radius: 4px; border: none; cursor: pointer;">X</button>
    </div>
    <p id="confirm-change-message" class="text-black">El estudiante ya está inscrito en otra clase. ¿Desea permitir el cambio de clase?</p>
    <div class="mt-4 flex justify-end gap-2">
      <button id="confirm-change-no" onclick="hideChangeModal()" class="btn bg-gray-300">Cancelar</button>
      <button id="confirm-change-yes" class="btn bg-primary text-white">Permitir cambio</button>
    </div>
  </div>
</div>
<script>
  // Opciones disponibles (pueden venir de una API, JSON, etc.)
  const periodo_id = <?php echo $periodoId_json = json_encode($periodoId); ?>;
  const periodoData = <?php echo json_encode($periodoData ?? null); ?>;
  const lastProfesor = <?php echo json_encode($lastProfesor ?? null); ?>;
  const optios = <?php echo $profesores_json = json_encode($profesores); ?>;
  const val = document.getElementById("real-value")
  const input = document.getElementById("input-principio");
  const dropdown = document.getElementById("dropdown-options");
  const classData = <?php echo json_encode($claseData); ?>;

  document.addEventListener('DOMContentLoaded', () => {
    try {
      const idProf = periodoData[0]['idProfesor'] || lastProfesor;
      if (idProf) {
        const encontrado = optios.find(p => (p.cedula == idProf));
        if (encontrado) {
          const text = (encontrado.nacionalidad || '') + (encontrado.cedula || '') + ' ' + (encontrado.nombre || '') + ' ' + (encontrado.apellido || '') + ' ' + (encontrado.email || '');
          input.value = text;
          input.dataset.selectedValue = encontrado.cedula;
          actualizarEstadoBotonAgregar();
        }
      }
    } catch (e) {
      console.error('Error prefijando profesor:', e);
    }
  });

  input.addEventListener("click", function() {
    showDropdown(optios);
  });

  input.addEventListener("input", function() {
    filterOptions(this.value.toLowerCase());
  });


  // Función para filtrar y mostrar opciones
  function filterOptions(searchTerm) {
    if (!searchTerm) {
      dropdown.style.display = "none";
      return;
    }
    const filteredOptions = optios.filter(opt =>
      opt.text.toLowerCase().includes(searchTerm)
    );

    showDropdown(filteredOptions);
  }

  function toggleModal() {
    document.getElementById("modal-producto").classList.toggle("hidden");
  }

  function hasProfesorSeleccionado() {
    const input = document.getElementById("input-principio");
    return input && input.dataset.selectedValue && input.dataset.selectedValue.trim() !== "";
  }

  function actualizarEstadoBotonAgregar() {
    const btn = document.getElementById("agregar");
    if (!btn) return;

    if (hasProfesorSeleccionado()) {
      btn.disabled = false;
      btn.classList.remove('bg-gray-400', 'cursor-not-allowed');
      btn.classList.add('bg-primary');
    } else {
      btn.disabled = true;
      btn.classList.add('bg-gray-400', 'cursor-not-allowed');
      btn.classList.remove('bg-primary');
    }
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
      const text = optios.nacionalidad + optios.cedula + ' ' + optios.nombre + " " + optios.apellido + " " + optios.email;
      optionElement.textContent = text;
      optionElement.dataset.value = optios.cedula;
      optionElement.classList.add("dropdown-item");
      optionElement.addEventListener("click", () => {
        input.value = text;
        input.dataset.selectedValue = optios.cedula;
        dropdown.style.display = "none";
        // Enviar petición para asignar profesor al periodo
        fetch('<?php echo CompletePath ?>', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              action: 'set_profesor',
              periodo_id: periodo_id,
              profesor_cedula: optios.cedula
            })
          })
          .then(r => r.json())
          .then(resp => {
            if (resp && resp.success) {
              // feedback mínimo: deshabilitar input y mostrar mensaje
              input.classList.add('bg-green-50');
              actualizarEstadoBotonAgregar();
              new notificationsMessage('success', 'Profesor asignado correctamente');

            } else {
              new notificationsMessage('error', resp.error || 'No se pudo asignar el profesor');
            }
          })
          .catch(err => {
            console.error(err);
            new notificationsMessage('error', 'Error al asignar profesor');
          });
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

  // Añade los datos del estudiante inscrito a la lista de inscritos

  function addTable(item) {
    const tr = document.createElement('tr');
    tr.className = 'text-black font-semibold font-sans ';
    const cedula = item.cedula || item.cedula_estudiante || '';
    const nombre = item.nombre || '';
    const apellido = item.apellido || '';
    const correo = item.email || '';
    const telefono = item.telefono || '';
    tr.innerHTML = `
            <th id="cedula+${cedula}">${cedula}</th>
            <th id="nombre+${cedula}">${nombre}</th>
            <th id="apellido+${cedula}">${apellido}</th>
            <th id="correo+${cedula}">${correo}</th>
            <th id="telefono+${cedula}">${telefono}</th>
            <th><button class="btn-inscripcion bg-primary text-white px-2 py-1 rounded" data-inscrito="0" onclick="toggleInscripcion('${cedula}', this)">Inscribir</button></th>
          `;
    tr.classList.add('mb-2');
    return tr
  }

  // Agregar handler para el boton agregar: pedir lista de alumnos aptos y poblar #tabla-alumnos
  document.getElementById('agregar').addEventListener('click', function(e) {
    e.preventDefault();
    if (!hasProfesorSeleccionado()) {
      new notificationsMessage('error', 'Primero debe seleccionar un profesor para esta clase');
      return;
    }
    if (classData == null) {
      return
    }
    fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'lista',
          data: classData,
          periodo_id: periodo_id,
        })
      })
      .then(res => res.json())
      .then(res => {

        let lista = res.data;
        // const lista = Array.isArray(res?.data) ? res.data : (res?.data ? [res.data] : []);

        const tbody = document.getElementById('tabla-alumnos');
        tbody.innerHTML = '';
        if (lista.length === 0) {
          const tr = document.createElement('tr');
          tr.className = 'text-black font-semibold font-sans';
          tr.innerHTML = '<th colspan="6">No hay alumnos aptos</th>';
          tbody.appendChild(tr);
          return;
        }
        lista.forEach(item => {
          console.log(item)
          tr = addTable(item)
          tbody.appendChild(tr);
        });
        // abrir modal para mostrar alumnos
        document.getElementById('modal-producto').classList.remove('hidden');
      })
      .catch(err => {
        console.error(err);
        new notificationsMessage('error', err);
      });
  });

  // Buscar alumno particular desde el modal: enviar petición y poblar #tabla-alumnos
  document.getElementById('buscar-alumno-btn').addEventListener('click', function(e) {
    e.preventDefault();
    const inputBuscar = document.getElementById('buscar-alumno-input');
    const query = inputBuscar ? inputBuscar.value.trim() : '';
    if (!query) {
      new notificationsMessage('error', 'Ingrese un término de búsqueda');
      return;
    }
    fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'buscar_alumno',
          buscar: query
        })
      })
      .then(r => r.json())
      .then(res => {
        const lista = res.data || [];
        const tbody = document.getElementById('tabla-alumnos');
        tbody.innerHTML = '';
        if (lista.length === 0) {
          const tr = document.createElement('tr');
          tr.className = 'text-black font-semibold font-sans';
          tr.innerHTML = '<th colspan="6">No se encontraron alumnos</th>';
          tbody.appendChild(tr);
          return;
        }
        lista.forEach(item => {
          tr = addTable(item)
          tbody.appendChild(tr);
        });
      })
      .catch(err => {
        new notificationsMessage('error', 'Error en la búsqueda');
      });
  });
  // Toggle desde botones en modal
  function toggleInscripcion(cedula, btn) {
    const estado = btn.dataset.inscrito === '1';
    if (!estado) {
      inscribirAlumno(cedula, periodo_id, btn);
    } else {
      quitarAlumno(cedula, periodo_id, btn);
    }
  }

  // Alumnos
  function inscribirAlumno(cedula, periodoId, btn = null) {
    fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'inscribir',
          estudiante_id: cedula,
          periodo_id: periodoId
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log(data.success)
        if (data.success == 'process') {
          // El estudiante ya está inscrito en otra clase: preguntar permiso para cambiarlo

          showChangeModal(cedula, btn, data.data);
          return;
        }
        if (data.success == 'no_periodo') {
          new notificationsMessage('error', 'Para poder inscribir a los alumnos primero debe seleccionar a un docente');
          return;
        }
        if (data.success == 'block') {
          new notificationsMessage('error', 'el estudiante no cumple con los reqisitos para poder cambiarlo de clase');
          return;
        }
        if (data.success) {
          if (btn) {
            btn.textContent = 'Inscrito';
            btn.disabled = true;
            btn.dataset.inscrito = '1';
            btn.classList.remove('bg-primary');
            btn.classList.add('bg-green-600');
          }
          refrescarLista();
        } else {
          new notificationsMessage('error', data.message || 'Error al inscribir');
        }
      })
      .catch(err => {
        console.error(err);
        new notificationsMessage('error', 'Error en la inscripción');
      });
  }


  function quitarAlumno(cedula, periodoId, btn = null) {
    fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'quitar',
          estudiante_id: cedula,
          periodo_id: periodoId
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          if (btn) {
            const row = btn.closest('tr');
            if (row) row.remove();
          }
          refrescarLista();
        } else {
          new notificationsMessage('error', data.message || 'Error al quitar');
        }
      })
      .catch(err => {
        console.error(err);
        new notificationsMessage('error', 'Error al quitar al alumno inscripción');
      });
  }

  // Función similar para quitarAlumno(cedula, periodoId)

  // Modal y funciones para confirmar cambio cuando el estudiante ya está inscrito en otra clase
  let pendingChange = {
    cedula: null,
    btn: null,
    data: null
  };

  function showChangeModal(cedula, btn, data) {
    pendingChange = {
      cedula: cedula,
      btn: btn,
      data: data
    };
    const modal = document.getElementById('confirm-change-modal');
    if (modal) modal.classList.remove('hidden');
  }

  function hideChangeModal() {
    const modal = document.getElementById('confirm-change-modal');
    if (modal) modal.classList.add('hidden');
    pendingChange = {
      cedula: null,
      btn: null
    };
  }

  async function confirmChangeInscripcion() {
    const cedula = pendingChange.cedula;
    const id = pendingChange.data;
    const btn = pendingChange.btn;
    if (!cedula) {
      hideChangeModal();
      return;
    }
    try {
      const resp = await fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'cambio',
          estudiante_id: cedula,
          periodo_id: periodo_id,
          anterior_id: id
        })
      });
      const data = await resp.json();
      if (data && data.success) {
        if (btn) {
          btn.textContent = 'Inscrito';
          btn.disabled = true;
          btn.dataset.inscrito = '1';
          btn.classList.remove('bg-primary');
          btn.classList.add('bg-green-600');
        }
        refrescarLista();
      } else {
        new notificationsMessage('error', data.message || data.error || 'No se pudo cambiar la inscripción');
      }
    } catch (err) {
      new notificationsMessage('error', 'Error al procesar el cambio de clase');
    } finally {
      hideChangeModal();
    }
  }

  // Asociar botones del modal
  document.addEventListener('click', function(e) {
    if (e.target && e.target.id === 'confirm-change-yes') {
      confirmChangeInscripcion();
    }
  });

  // Refrescar lista
  function refrescarLista() {
    fetch(`<?php echo CompletePath ?>&get=${periodo_id}`, {
        method: 'GET'
      })
      .then(response => response.json())
      .then(resp => {
        const lista = resp.data || resp || [];
        const tbody = document.getElementById('tabla-resultados');
        tbody.innerHTML = '';
        if (!lista || lista.length === 0) {
          const tr = document.createElement('tr');
          tr.innerHTML = '<th colspan="6">Ningun Alumno inscrito</th>';
          tbody.appendChild(tr);
          return;
        }
        lista.forEach(alumno => {
          const tr = document.createElement('tr');
          const ced = alumno.cedula || '';
          const nombre = alumno.nombre || '';
          const apellido = alumno.apellido || '';
          const correo = alumno.email || '';
          const telefono = alumno.telefono || '';
          tr.className = 'text-black font-semibold font-sans';
          tr.innerHTML = `
            <th>${ced}</th>
            <th>${nombre}</th>
            <th>${apellido}</th>
            <th>${correo}</th>
            <th>${telefono}</th>
            <th><button class="btn bg-red-600 text-white px-2 py-1 rounded" onclick="quitarAlumno('${ced}', ${periodo_id}, this)">Quitar</button></th>
          `;
          tr.classList.add('mb-2')
          tbody.appendChild(tr);
        });
      })
      .catch(err => {
        const tbody = document.getElementById('tabla-resultados');
        tbody.innerHTML = ''; // Limpia
        const tr = document.createElement('tr');
        tr.innerHTML = `<th>Ningun Alumno inscrito</th>`;
        tbody.appendChild(tr);
      });
  };

  // Al cambiar checkbox
  function manejarCheckbox(checkbox, cedula) {
    const periodoId = periodo_id;
    if (checkbox.checked) {
      inscribirAlumno(cedula, periodoId);
    } else {
      quitarAlumno(cedula, periodoId);
    }
  }

  // Carga inicial al abrir modal/página
  document.addEventListener('DOMContentLoaded', refrescarLista);
</script>
<?php echo $parte2; ?>
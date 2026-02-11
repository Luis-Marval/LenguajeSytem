<?php
$title = "Inscripciones";
require_once "./views/view.struct.php";
echo $parte1; ?>
<main class="flex-grow p-6 relative  main-scroll">
  <h1 class="text-2xl text-primary">Gestion de Inscripcion</h1>
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
            <h1 class=" text-primary dark:text-primary">Datos de la Clase</h1>
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
            <div class="grid grid-cols-4 gap-3">
              <div class="autocomplete-container col-start-1 col-end-4">
                <label for="input-principio" class="text-gray-800 text-sm font-medium inline-block mb-2">Profesor</label>
                <input type="text" class="form-select" id="input-principio" title="Ingresa el profesor" required name="principio" autocomplete="off" value="">
                <div id="dropdown-options" class="dropdown-options"></div>
              </div>
              <div class="col-start-4">
                <label for="input-date" class="text-gray-800 text-sm font-medium inline-block mb-2">Fecha de Finalizacion</label>
                <input type="date" class="form-input" id="input-date" title="Ingresa la fecha de finalizacion" required autocomplete="off" value="<?php if (!empty($periodoData[0]['finalizacion'])) echo $periodoData[0]['finalizacion'] ?>" onchange="setDate()">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="card w-full mt-2">
        <div class="flex justify-between w-full items-center px-2 pt-2">
          <h2 class=" text-primary dark:text-primary align-middle"> Alumnos Inscritos</h2>
          <button type="button" id="agregar"
            class="btn text-xl bg-primary text-white disabled:bg-gray-400 disabled:cursor-not-allowed">
            +
          </button>
        </div>
        <table class="table-auto min-w-full w-full mt-4 mb-2">
          <thead class="text-xs text-gray-600 bg-gray-100 dark:bg-gray-700 dark:text-gray-400  mb-2">
            <tr class="text-sm font-semibold font-sans  py-1" style="    border-top-width: 5px;
    border-bottom-width: 5px;
    border-color: rgb(243 244 246);">
              <th>Cedula</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
              <th>Pago</th>
              <th>#</th>
            </tr>
          </thead>
          <tbody id="tabla-resultados" class="text-center">
          </tbody>
        </table>
        <div class="w-full flex justify-end px-4 pb-3"> <button class="flex items-center gap-2 px-8 py-3 bg-primary hover:bg-blue-800 text-white font-semibold rounded-lg shadow-lg shadow-blue-900/20 transition-all hover:-translate-y-0.5 active:translate-y-0">Finalizar Inscripción</button></div>
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
            <tr class=" text-sm font-semibold font-sans">
              <th>Cedula</th>
              <th>Nombre</th>
              <th>Correo</th>
              <th>Teléfono</th>
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

<!-- Modal para registrar pago inicial -->
<div id="modal-pago" class="hidden absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center ">
  <div class="bg-white p-6 rounded-xl" style="max-width:420px; width:90%;">
    <div class="flex justify-between items-start mb-4">
      <h2 class="text-xl text-black font-bold">Registrar pago inicial</h2>
      <button onclick="cerrarModalPago()" style="background-color: #dc2626; color: white; padding: 6px 12px; font-size: 14px; font-weight: bold; border-radius: 4px; border: none; cursor: pointer;">X</button>
    </div>
    <form onsubmit="enviarPagoInicial(event)">
      <p class="mb-2 text-black"><span id="pago-cedula-label"></span></p>
      <div class="mb-3">
        <label class="block text-gray-700 text-sm font-bold mb-1" for="pago-porcentaje">Porcentaje</label>
        <select id="pago-porcentaje" class="form-select w-full" required>
          <option value="">Seleccione...</option>
          <option value="60">60% (pendiente)</option>
          <option value="100">100% (completo)</option>
        </select>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-1" for="pago-comentario">Comentario (opcional)</label>
        <textarea id="pago-comentario" class="form-input w-full" rows="2"></textarea>
      </div>
      <div class="mt-4 flex justify-end gap-2">
        <button type="button" onclick="cerrarModalPago()" class="btn bg-gray-300">Cancelar</button>
        <button type="submit" class="btn bg-primary text-white">Guardar pago</button>
      </div>
    </form>
  </div>
</div>

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

<!-- Modal Confirmar Finalizar Inscripción -->
<div id="modal-finalizar" class="hidden absolute inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50">
  <div class="bg-white p-8 rounded-xl shadow-2xl max-w-md w-11/12">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold text-gray-800">Finalizar Inscripción</h2>
      <button onclick="cerrarModalFinalizar()" class="text-red-600 hover:text-red-800 text-2xl font-bold">&times;</button>
    </div>

    <p class="text-gray-700 mb-8 text-lg">
      ¿Está seguro que desea <strong>finalizar la inscripción</strong> de esta clase?<br>
      <span class="text-sm text-gray-500 mt-2 block">
        Una vez finalizada no se podrán agregar ni quitar alumnos.
      </span>
    </p>

    <div class="flex justify-end gap-4">
      <button onclick="cerrarModalFinalizar()"
        class="px-6 py-3 bg-red-600 text-white font-semibold rounded-lg transition">
        No, cancelar
      </button>
      <button id="btn-confirmar-finalizar"
        class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition">
        Sí, finalizar
      </button>
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

  // Función vacía que se ejecuta al cambiar la fecha de finalización
  function setDate() {
    const inputDate = document.getElementById('input-date');
    fechaFin = inputDate ? inputDate.value : null;
    if (fechaFin == null) {
      return
    }
    fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'set_Date',
          periodo_id: periodo_id,
          fecha_fin: fechaFin,
        })
      })
      .then(r => r.json())
      .then(resp => {
        console.log(resp)
        if (resp && resp.success) {
          // feedback mínimo: deshabilitar input y mostrar mensaje
          input.classList.add('bg-green-50');
          actualizarEstadoBotonAgregar();
          new notificationsMessage('success', 'Fecha asignada correctamente');

        } else {
          new notificationsMessage('error', resp.error || 'No se pudo asignar la Fecha');
        }
      })
      .catch(err => {
        console.error(err);
        new notificationsMessage('error', 'Error al asignar Fecha');
      });
  }

  document.addEventListener('DOMContentLoaded', () => {
    try {
      const idProf = periodoData[0]['idProfesor'] || lastProfesor;
      if (idProf) {
        const encontrado = optios.find(p => (p.cedula == idProf));
        if (encontrado) {
          const text = (encontrado.tipoDocumento || '') + (encontrado.cedula || '') + ' ' + (encontrado.nombre || '') + ' ' + (encontrado.apellido || '') + ' ' + (encontrado.email || '');
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
      const text = optios.tipoDocumento + optios.cedula + ' ' + optios.nombre + " " + optios.apellido + " " + optios.email;
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
    const tipoDocumento = item.tipoDocumento || '';
    const cedula = item.cedula || item.cedula_estudiante || '';
    const nombre = item.nombre || '';
    const apellido = item.apellido || '';
    const correo = item.email || '';
    const telefono = item.telefono || '';
    tr.innerHTML = `
            <th id="cedula+${cedula}">${tipoDocumento}${cedula}</th>
            <th id="nombre+${cedula}">${nombre} ${apellido}</th>
            <th id="correo+${cedula}">${correo}</th>
            <th id="teléfono+${cedula}">${telefono}</th>
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
        console.log(res)
        // const lista = Array.isArray(res?.data) ? res.data : (res?.data ? [res.data] : []);

        const tbody = document.getElementById('tabla-alumnos');
        tbody.innerHTML = '';
        if (lista.length === 0) {
          console.log(lista);
          const tr = document.createElement('tr');
          tr.className = 'text-black font-semibold font-sans';
          tr.innerHTML = '<th colspan="6">No hay alumnos aptos</th>';
          tbody.appendChild(tr);
        } else {

          lista.forEach(item => {
            tr = addTable(item)
            tbody.appendChild(tr);
          });
        }
        // abrir modal para mostrar alumnos
        document.getElementById('modal-producto').classList.remove('hidden');

        return;
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
          buscar: query,
          periodo_id: periodo_id,
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


  function quitarAlumnoConValidacion(cedula, periodoId, btn = null) {
    const celdaPago = document.getElementById(`pago-${cedula}`);
    if (celdaPago && celdaPago.textContent && celdaPago.textContent.trim() !== 'Pendiente') {
      new notificationsMessage('error', 'No se puede quitar al estudiante porque ya tiene un pago registrado');
      return;
    }
    quitarAlumno(cedula, periodoId, btn);
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
          const cedula = alumno.cedula || '';
          const nombre = alumno.nombre || '';
          const apellido = alumno.apellido || '';
          const correo = alumno.email || '';
          const telefono = alumno.telefono || '';
          const txt = (alumno.estado_pago == 60) ? '60% (pendiente)' : '100% (Completo)';

          const pagoTag = (alumno.estado_pago !== null) ? `<span class="bg-success/25 text-success" style=" padding: 7.5px; border-radius: 25px;">${txt}</span>` : `<span class="bg-warning/25 text-warning" style=" padding: 7.5px; border-radius: 25px;">Pendiente</span>`;
          tr.className = 'text-black font-semibold font-sans';
          const botonPago = (alumno.estado_pago === null || alumno.estado_pago === undefined) ?
            `<button class="btn bg-green-600 text-white hover:text-white px-2 py-1 rounded col-start-2" onclick="abrirModalPago('${cedula}')"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M12 6C7.03 6 2 7.546 2 10.5v4C2 17.454 7.03 19 12 19s10-1.546 10-4.5v-4C22 7.546 16.97 6 12 6m-8 8.5v-1.197a10 10 0 0 0 2 .86v1.881c-1.312-.514-2-1.126-2-1.544m12 .148v1.971c-.867.179-1.867.31-3 .358v-2a22 22 0 0 0 3-.329m-5 2.33a19 19 0 0 1-3-.358v-1.971c.959.174 1.972.287 3 .33zm7-.934v-1.881a10 10 0 0 0 2-.86V14.5c0 .418-.687 1.03-2 1.544M12 13c-5.177 0-8-1.651-8-2.5S6.823 8 12 8s8 1.651 8 2.5s-2.823 2.5-8 2.5"/></svg></button>` : '';
          const size = (alumno.estado_pago === null || alumno.estado_pago === undefined) ?
            `col-start-3 bg-red-600 ` : 'col-start-2 col-end-4 bg-gray-300';
          const quitarButton = (alumno.estado_pago !== null || alumno.estado_pago !== undefined) ?
            `disabled` : '';
          tr.innerHTML = `
            <th>${alumno.tipoDocumento}${cedula}</th>
            <th>${nombre} ${apellido}</th>
            <th>${correo}</th>
            <th>${telefono}</th>
            <th id="pago-${cedula}">${pagoTag}</th>
            <th id="buttons-${cedula}" class="grid grid-cols-4 gap-1 items-center justify-center">
${botonPago}
              <button class="btn text-white  px-2 py-1 rounded ${size}"  onclick="quitarAlumnoConValidacion('${cedula}', ${periodo_id}, this)">X</button>
            </th>
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

  // --- Gestión de pagos ---
  let cedulaActualPago = null;

  function abrirModalPago(cedula) {
    cedulaActual = cedula;
    const label = document.getElementById('pago-cedula-label');
    if (label) {
      label.textContent = `Estudiante: ${cedula}`;
    }
    const porcentaje = document.getElementById('pago-porcentaje');
    const comentario = document.getElementById('pago-comentario');
    if (porcentaje) porcentaje.value = '';
    if (comentario) comentario.value = '';

    const modal = document.getElementById('modal-pago');
    if (modal) modal.classList.remove('hidden');
  }

  function cerrarModalPago() {
    const modal = document.getElementById('modal-pago');
    if (modal) modal.classList.add('hidden');
    cedulaActual = null;
  }

  function enviarPagoInicial(e) {
    e.preventDefault();
    if (!cedulaActual) {
      new notificationsMessage('error', 'No se ha seleccionado un estudiante');
      return;
    }
    const porcentaje = document.getElementById('pago-porcentaje')?.value;
    const comentario = document.getElementById('pago-comentario')?.value || null;

    fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'registrar_pago_inicial',
          estudiante_id: cedulaActual,
          periodo_id: periodo_id,
          porcentaje: porcentaje,
          comentario: comentario,
        })
      })
      .then(r => r.json())
      .then(resp => {
        if (resp && resp.success) {
          const celda = document.getElementById(`pago-${cedulaActual}`);
          if (celda) {
            let texto = "";
            if (resp.estado_pago === '100') {
              texto = '100% (Completo)';
            } else if (resp.estado_pago === '60') {
              texto = '60% (pendiente)';
            } else {
              texto = 'Pendiente';
            }
            celda.innerHTML = `<span class="bg-success/25 text-success" style=" padding: 7.5px; border-radius: 25px;">${texto}</span>`
          }
          const button = document.getElementById(`buttons-${cedulaActual}`);
          if (button) {
            button.innerHTML = `<button class="btn text-white px-2 py-1 rounded col-start-2 col-end-4 bg-gray-300" onclick="quitarAlumnoConValidacion('${cedulaActual}', ${periodo_id}, this)">X</button>`
          }

          new notificationsMessage('success', 'Pago inicial registrado correctamente');
          cerrarModalPago();
        } else {
          new notificationsMessage('error', resp.error || 'No se pudo registrar el pago inicial');
        }
      })
      .catch(err => {
        console.error(err);
        new notificationsMessage('error', 'Error al registrar el pago inicial');
      });
  }

  //Finalizar Inscripcion
  // ------------------- Finalizar Inscripción -------------------

  function abrirModalFinalizar() {
    const modal = document.getElementById('modal-finalizar');
    if (modal) modal.classList.remove('hidden');
  }

  function cerrarModalFinalizar() {
    const modal = document.getElementById('modal-finalizar');
    if (modal) modal.classList.add('hidden');
  }

  // Conectar el botón principal "Finalizar Inscripción"
  document.querySelector('.flex.justify-end.px-4.pb-3 button')?.addEventListener('click', function(e) {
    e.preventDefault();
    abrirModalFinalizar();
  });

  // Conectar el botón "Sí, finalizar" dentro del modal
  document.getElementById('btn-confirmar-finalizar')?.addEventListener('click', function(e) {
    e.preventDefault()
    fetch('<?php echo CompletePath ?>', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          action: 'finalizar_inscripcion',
          periodo_id: periodo_id
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          new notificationsMessage('success', 'Inscripción finalizada correctamente');
          window.location.href = "<?php echo PATH ?>clases/inscripciones"
          cerrarModalFinalizar();

          // Opcional: deshabilitar botones de acción para que no se pueda modificar más
          document.getElementById('agregar').disabled = true;
          document.querySelector('.flex.justify-end.px-4.pb-3 button').disabled = true;
        } else {
          new notificationsMessage('error', data.error || 'No se pudo finalizar la inscripción');
        }
      })
      .catch(err => {
        console.error(err);
        new notificationsMessage('error', 'Error al conectar con el servidor');
      });
  });
</script>
<?php echo $parte2; ?>
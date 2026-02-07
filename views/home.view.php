<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require "./views/templates/scripts.php"; ?>
  <link rel="stylesheet" href="src/css/material-home-min.css">
  <title>Inicio</title>
</head>

<body>
  <div class="flex wrapper">
    <?php require_once "./views/templates/menu.php"; ?>
    <div class="page-content">
      <?php require_once './views/templates/header.php'; ?>

      <main class="main-scroll">
        <div class="row px-6 main">
          <div class="card">
            <div class="card-header flex justify-between items-center  card-header-primary">
              <p class="title-2">Estudiantes por Inscribir</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center dark:border-sky-500" id="tbl">
                  <thead class="thead-dark">
                    <tr>
                      <th>Cedula</th>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Lenguaje</th>
                      <th>Nivel</th>
                      <th>#</th>
                    </tr>
                  </thead>
                  <tbody id="tablaPorInscribir">
                  </tbody>
                </table>
                <div class="w-full text-sm text-left text-gray-500 dark:text-gray-200 flex justify-end align-center line0" style="overflow-y: hidden;">
                  <div class="flex items-center gap-2">
                    <label for="rowForPageHome" class="whitespace-nowrap">Filas por página:</label>
                    <select id="rowForPageHome" class="px-2 py-1 bg-white dark:bg-gray-800">
                      <option value="5">5</option>
                      <option value="10" selected>10</option>
                      <option value="20">20</option>
                      <option value="50">50</option>
                    </select>
                  </div>
                  <p id="infoRange">0-0 de 0</p>
                  <div>
                    <button id="btnPrev" style="width: 20px;" title="Pagina Anterior" disabled>
                      <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z" />
                      </svg>
                    </button>
                    <button id="btnNext" style="width: 20px;" title="Siguiente Pagina">
                      <svg class="" focusable="false" viewBox="0 0 24 24">
                        <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"></path>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Nueva sección: Pagos Pendientes -->
        <div class="px-6 main">
          <div class="card">
            <div class="card-header flex justify-between items-center card-header-primary">
              <p class="title-2">Pagos Pendientes</p>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center dark:border-sky-500" id="tblPagos">
                  <thead class="thead-dark">
                    <tr>
                      <th>Cédula</th>
                      <th>Estudiante</th>
                      <th>Idioma/Nivel</th>
                      <th>Acción</th>
                    </tr>
                  </thead>
                  <tbody id="tablaPagosPendientes">
                  </tbody>
                </table>
                <div class="w-full text-sm text-left text-gray-500 dark:text-gray-200 flex justify-end align-center line0" style="overflow-y: hidden;">
                  <div class="flex items-center gap-2">
                    <label for="rowForPagePagos" class="whitespace-nowrap">Filas por página:</label>
                    <select id="rowForPagePagos" class="px-2 py-1 bg-white dark:bg-gray-800">
                      <option value="5">5</option>
                      <option value="10" selected>10</option>
                      <option value="20">20</option>
                      <option value="50">50</option>
                    </select>
                  </div>
                  <p id="infoRangePagos">0-0 de 0</p>
                  <div>
                    <button id="btnPrevPagos" style="width: 20px;" title="Página Anterior" disabled>
                      <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z" />
                      </svg>
                    </button>
                    <button id="btnNextPagos" style="width: 20px;" title="Siguiente Página">
                      <svg focusable="false" viewBox="0 0 24 24">
                        <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"></path>
                      </svg>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>

  </div>

  <script>
    // Datos que vienen de PHP
    const lista = <?php echo json_encode($listas); ?>;
    const pagos = <?php echo json_encode($pagos); ?>;


    // Elementos del DOM
    const tablaBody = document.getElementById("tablaPorInscribir");
    const selectRows = document.getElementById("rowForPageHome");
    const btnPrev = document.getElementById("btnPrev");
    const btnNext = document.getElementById("btnNext");
    const infoRange = document.getElementById("infoRange");

    // Variables de estado
    let currentPage = 1;
    let rowsPerPage = parseInt(selectRows.value) || 10;

    function renderTable() {
      if (!tablaBody) return;

      tablaBody.innerHTML = '';

      if (lista === false) {
        tablaBody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center text-red-600 font-bold">
            No hay alumnos por inscribir
          </td>
        </tr>`;
        return;
      }

      const totalRows = lista.length

      const totalPages = Math.ceil(totalRows / rowsPerPage);
      const start = (currentPage - 1) * rowsPerPage;
      const end = Math.min(start + rowsPerPage, totalRows);
      const pageData = lista.slice(start, end);

      // Actualizar info de rango
      infoRange.textContent = totalRows === 0 ?
        "0-0 de 0" :
        `${start + 1}-${end} de ${totalRows}`;

      // Des/habilitar botones
      btnPrev.disabled = currentPage <= 1;
      btnNext.disabled = currentPage >= totalPages || totalPages === 0;

      const fragment = document.createDocumentFragment();

      pageData.forEach(data => {
        const tr = document.createElement("tr");
        tr.classList.add('dark:text-white')
        tr.innerHTML = `
        <td class="border px-4 py-2">${data.cedula || '-'}</td>
        <td class="border px-4 py-2">${data.nombre || ''} ${data.apellido || ''}</td>
        <td class="border px-4 py-2">${data.telefono || '-'}</td>
        <td class="border px-4 py-2">${data.nombre_idioma || '-'}</td>
        <td class="border px-4 py-2">${(data.nivel || 0) + 1}</td>
        <td class="border px-4 py-2">
          <a href="<?php echo PATH ?>clases/periodo?idClass=${data.idClase || ''}" class="btn bg-primary px-3 py-1 rounded cursor-pointer inline-block dark:text-white">
            Inscribir
          </a>
        </td>
      `;
        fragment.appendChild(tr);
      });

      tablaBody.appendChild(fragment);
    }

    // Cambiar cantidad de filas por página
    selectRows.addEventListener("change", () => {
      rowsPerPage = parseInt(selectRows.value) || 10;
      currentPage = 1; // volver a la primera página
      renderTable();
    });

    // Botón anterior
    btnPrev.addEventListener("click", () => {
      if (currentPage > 1) {
        currentPage--;
        renderTable();
      }
    });

    // Botón siguiente
    btnNext.addEventListener("click", () => {
      const totalPages = Math.ceil(lista.length / rowsPerPage);
      if (currentPage < totalPages) {
        currentPage++;
        renderTable();
      }
    });

    // Inicializar
    document.addEventListener("DOMContentLoaded", () => {
      renderTable();
    });
  </script>
  <script>
    const tablaPagosBody = document.getElementById("tablaPagosPendientes");
    const selectRowsPagos = document.getElementById("rowForPagePagos");
    const btnPrevPagos = document.getElementById("btnPrevPagos");
    const btnNextPagos = document.getElementById("btnNextPagos");
    const infoRangePagos = document.getElementById("infoRangePagos");

    let currentPagePagos = 1;
    let rowsPerPagePagos = parseInt(selectRowsPagos?.value) || 10;

    function renderTablaPagos() {
      if (!tablaPagosBody) return;

      tablaPagosBody.innerHTML = '';

      if (!pagos || pagos.length === 0) {
        tablaPagosBody.innerHTML = `
      <tr>
        <td colspan="10" class="text-center text-green-600 font-bold">
          No hay pagos pendientes
        </td>
      </tr>`;
        return;
      }

      const totalRows = pagos.length;
      const totalPages = Math.ceil(totalRows / rowsPerPagePagos);
      const start = (currentPagePagos - 1) * rowsPerPagePagos;
      const end = Math.min(start + rowsPerPagePagos, totalRows);
      const pageData = pagos.slice(start, end);

      infoRangePagos.textContent = totalRows === 0 ?
        "0-0 de 0" :
        `${start + 1}-${end} de ${totalRows}`;

      btnPrevPagos.disabled = currentPagePagos <= 1;
      btnNextPagos.disabled = currentPagePagos >= totalPages || totalPages === 0;

      const fragment = document.createDocumentFragment();


      pageData.forEach(pago => {
        const tr = document.createElement("tr");
        tr.classList.add('dark:text-white')
        tr.innerHTML = `
      <td class="border px-4 py-2">${pago.cedula || '-'}</td>
      <td class="border px-4 py-2">${pago.estudiante || ''}</td>

        <td class="border px-4 py-2">${pago.nombre_idioma || '-'}/${(pago.nivel || 0) + 1}</td>
      <td class="border px-4 py-2">
        <a href="<?php echo PATH ?>pagos/abono?epi=${pago.estudiante_periodo_id || ''}" 
          class="btn bg-blue-600 dark:text-white px-3 py-1 rounded cursor-pointer inline-block text-sm">
          Ver / Registrar
        </a>
      </td>
    `;
        fragment.appendChild(tr);
      });

      tablaPagosBody.appendChild(fragment);
    }

    // Eventos para la tabla de pagos
    selectRowsPagos?.addEventListener("change", () => {
      rowsPerPagePagos = parseInt(selectRowsPagos.value) || 10;
      currentPagePagos = 1;
      renderTablaPagos();
    });

    btnPrevPagos?.addEventListener("click", () => {
      if (currentPagePagos > 1) {
        currentPagePagos--;
        renderTablaPagos();
      }
    });

    btnNextPagos?.addEventListener("click", () => {
      const totalPages = Math.ceil((pagos?.length || 0) / rowsPerPagePagos);
      if (currentPagePagos < totalPages) {
        currentPagePagos++;
        renderTablaPagos();
      }
    });

    // Inicializar ambas tablas
    document.addEventListener("DOMContentLoaded", () => {
      renderTable(); // la de alumnos por inscribir
      renderTablaPagos(); // la nueva de pagos
    });
  </script>
</body>

</html>
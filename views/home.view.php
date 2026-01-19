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
        <?php if (isset($listas)): ?>
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
                      <select id="rowForPageHome" class="border rounded px-2 py-1 bg-white dark:bg-gray-800">
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
        <?php endif; ?>
<!--         <div class="row px-6">
          <div class="col-lg-6 p-r">
            <div class="card">
              <div class="card-header card-header-primary">
                <h3 class="title-2">Estudiantes por Nivel</h3>
              </div>
              <div class="card-body min-h">
                <div id="ProductosVendidos" class="svgAuto"></div>
              </div>
            </div>
          </div>
          <div class="col-lg-6 p-l">
            <div class="card">
              <div class="card-header card-header-primary">
                <h3 class="title-2">Estudiantes por Idiomas</h3>
              </div>
              <div class="card-body min-h">
                <div id="patologias" class="svgAuto"></div>
              </div>
            </div>
          </div>
        </div> -->
      </main>
    </div>

  </div>
  <script>
/*     const medicamentos = new ApexCharts(document.querySelector("#ProductosVendidos"), {
      series: [{
        name: 'Ingles',
        data: [44, 55, 41, 67, 22, 43]
      }, {
        name: 'Frances',
        data: [13, 23, 20, 8, 13, 27]
      }, {
        name: 'Japones',
        data: [11, 17, 15, 15, 21, 14]
      }],
      chart: {
        type: 'bar',
        height: 280,
        stacked: true,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: true
        }
      },
      responsive: [{
        breakpoint: 480,
        options: {
          legend: {
            position: 'bottom',
            offsetX: -10,
            offsetY: 0
          }
        }
      }],
      plotOptions: {
        bar: {
          horizontal: false,
          borderRadius: 10,
          borderRadiusApplication: 'end', // 'around', 'end'
          borderRadiusWhenStacked: 'last', // 'all', 'last'
          dataLabels: {
            total: {
              enabled: true,
              style: {
                fontSize: '13px',
                fontWeight: 900
              }
            }
          }
        },
      },
      xaxis: {
        type: 'string',
        categories: ['Nivel 1', 'Nivel 2', 'Nivel 3', 'Nivel 4',
          'Nivel 5', 'Nivel 6'
        ],
      },
      legend: {
        position: 'right',
        offsetY: 40
      },
      fill: {
        opacity: 1
      }
    });

    const patologias = new ApexCharts(document.querySelector("#patologias"), {
      chart: {
        type: 'donut',
        height: '100%',
        toolbar: {
          show: true,
          tools: {
            download: true
          },
          export: {
            csv: {
              filename: 'datos-grafico',
              columnDelimiter: ',',
              headerCategory: 'Categoría',
              headerValue: 'Valor'
            },
            svg: {
              filename: 'grafico'
            },
            png: {
              filename: 'grafico'
            }
          }
        },
        animations: {
          enabled: true,
          speed: 800,
          animateGradually: {
            enabled: true,
            delay: 150
          },
          dynamicAnimation: {
            enabled: true,
            speed: 350
          }
        }
      },
      plotOptions: {
        pie: {
          donut: {
            labels: {
              show: true,
              total: {
                show: true,
                showAlways: true,
                label: 'Total',
                fontSize: '22px',
                fontFamily: 'Helvetica, Arial, sans-serif',
                color: '#373d3f'
              }
            }
          }
        }
      },
      series: [5, 4, 5],
      colors: ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'], // Colores Tailwind
      labels: ["ingles", "frances", "japones"],
      legend: {
        show: false
      },
    });
    medicamentos.render()
    patologias.render() */
  </script>

  <script>
    // Datos que vienen de PHP
    const lista = Array.isArray(<?php echo json_encode($listas ?? []); ?>) ?
      <?php echo json_encode($listas ?? []); ?> : [];

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

      const totalRows = lista.length;
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

      if (totalRows === 0) {
        tablaBody.innerHTML = `
        <tr>
          <td colspan="6" class="text-center text-red-600 font-bold">
            No hay alumnos por inscribir
          </td>
        </tr>`;
        return;
      }

      const fragment = document.createDocumentFragment();

      pageData.forEach(data => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
        <td class="border px-4 py-2">${data.cedula || '-'}</td>
        <td class="border px-4 py-2">${data.nombre || ''} ${data.apellido || ''}</td>
        <td class="border px-4 py-2">${data.telefono || '-'}</td>
        <td class="border px-4 py-2">${data.nombre_idioma || '-'}</td>
        <td class="border px-4 py-2">${(data.nivel || 0) + 1}</td>
        <td class="border px-4 py-2">
          <a href="<?php echo PATH ?>clases/periodo?idClass=${data.idClase || ''}" class="btn bg-primary px-3 py-1 rounded cursor-pointer inline-block">
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
</body>

</html>
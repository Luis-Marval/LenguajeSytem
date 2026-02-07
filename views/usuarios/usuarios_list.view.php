<!DOCTYPE html>
<html lang="es" data-sidenav-view="sm">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php

  use model\Usuario;

  require "./views/templates/scripts.php"; ?>
  <title>Inicio</title>
</head>

<body>
  <div class="flex wrapper">
    <?php require_once "./views/templates/menu.php"; ?>
    <div class="page-content">
      <?php require_once './views/templates/header.php'; ?>
      <main class="flex-grow p-6">
        <div class="alertContainer">
          <?php
          require_once "./views/templates/message/error.php";
          require_once "./views/templates/message/success.php";
          ?>
        </div>
        <div class="w-full flex justify-between mb-4 items-center">
          <div class="min-h-min ">
            <h1 class="text-2xl text-primary dark:text-primary"> Usuarios </h1>
          </div>
          <div class="">
            <button id="openModal" class="btn bg-primary text-white">
              <span class="mr-5">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                  <rect width="24" height="24" fill="none" />
                  <path fill="currentColor" d="M18 11h-2q-.425 0-.712-.288T15 10t.288-.712T16 9h2V7q0-.425.288-.712T19 6t.713.288T20 7v2h2q.425 0 .713.288T23 10t-.288.713T22 11h-2v2q0 .425-.288.713T19 14t-.712-.288T18 13zm-9 1q-1.65 0-2.825-1.175T5 8t1.175-2.825T9 4t2.825 1.175T13 8t-1.175 2.825T9 12m-8 6v-.8q0-.85.438-1.562T2.6 14.55q1.55-.775 3.15-1.162T9 13t3.25.388t3.15 1.162q.725.375 1.163 1.088T17 17.2v.8q0 .825-.587 1.413T15 20H3q-.825 0-1.412-.587T1 18m2 0h12v-.8q0-.275-.137-.5t-.363-.35q-1.35-.675-2.725-1.012T9 15t-2.775.338T3.5 16.35q-.225.125-.363.35T3 17.2zm6-8q.825 0 1.413-.587T11 8t-.587-1.412T9 6t-1.412.588T7 8t.588 1.413T9 10m0 8" />
                </svg>
              </span>
              Registrar Usuario</button>
          </div>
        </div>
        <div class="card">
          <table class="w-full text-sm text-gray-500 dark:text-gray-400 text-center">
            <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200 border-b border-black filas-row dark:bg-grea">
              <tr>
                <th scope="col" class="px-6 py-3">Nombre</th>
                <th scope="col" class="px-6 py-3">Correo</th>
                <th scope="col" class="px-6 py-3">Rol</th>
                <th scope="col" class="px-6 py-3">Acciones</th>

              </tr>
            </thead>
            <tbody class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
              <?php foreach ($usuarios as $usuario): ?>
                <tr class="border-b border-black filas-row text-center">
                  <td scope="col"><?php echo $usuario['nombre'] . " " . $usuario['apellido']; ?></td>
                  <td scope="col"><?php echo $usuario['correo'] ?></td>
                  <td scope="col"><?php echo $usuario['name'] ?></td>
                  <td scope="col" class="flex justify-center">
                    <a onclick="editarUsuario(<?php echo $usuario['id']; ?>)" class="p-2 bg-blue-100 hover:bg-blue-100 dark:text-blue-400 dark:hover:bg-blue-900/30 rounded-lg transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                      <path fill="currentColor" d="M4 21q-.425 0-.712-.288T3 20v-2.425q0-.4.15-.763t.425-.637L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.437.65T21 6.4q0 .4-.138.763t-.437.662l-12.6 12.6q-.275.275-.638.425t-.762.15zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                    </svg></a>
                    <a onclick="editarRol(<?php echo $usuario['id']; ?>)" class="p-2 text-amber-600 hover:bg-amber-100 dark:text-amber-400 dark:hover:bg-amber-900/30 rounded-lg transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" fill-rule="evenodd" d="M22 8.293c0 3.476-2.83 6.294-6.32 6.294c-.636 0-2.086-.146-2.791-.732l-.882.878c-.519.517-.379.669-.148.919c.096.105.208.226.295.399c0 0 .735 1.024 0 2.049c-.441.585-1.676 1.404-3.086 0l-.294.292s.881 1.025.147 2.05c-.441.585-1.617 1.17-2.646.146l-1.028 1.024c-.706.703-1.568.293-1.91 0l-.883-.878c-.823-.82-.343-1.708 0-2.05l7.642-7.61s-.735-1.17-.735-2.78c0-3.476 2.83-6.294 6.32-6.294S22 4.818 22 8.293m-6.319 2.196a2.2 2.2 0 0 0 2.204-2.195a2.2 2.2 0 0 0-2.204-2.196a2.2 2.2 0 0 0-2.204 2.196a2.2 2.2 0 0 0 2.204 2.195" clip-rule="evenodd" />
                      </svg></i></a>
                    <form action="<?php echo PATH ?>eliminarUsuario?id=<?php echo $usuario['id']; ?>" method="post" class="confirmar d-inline">
                      <button class="p-2 text-red-600 hover:bg-red-100 dark:text-red-400 dark:hover:bg-red-900/30 rounded-lg transition-colors" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                          <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                        </svg></button>
                    </form>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
          <div class="w-full plrb text-sm text-left text-gray-500 dark:text-gray-200 flex justify-between align-center mt-2">
            <div>
              <form action="<?php echo CompleteURL ?>" method="get" class="flex  line0">
                <label for="rowForPage">Filas Por Pagina:</label>
                <div class="relative">
                  <select id="rowForPage" name="porPaginas" class="">
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                  </select>
                </div>
              </form>
            </div>
            <div class="flex gap-25px">
              <p><?php echo ($cantidadActual ?? '0'); ?>-<?php echo ($cantidadFinal ?? '0'); ?> de <?php echo ($total ?? '0'); ?></p>
              <div class="">
                <button class="" id="before" tabindex="-1" type="button" <?php if (!empty($page) && $page == 1) {
                                                                            echo 'disabled';
                                                                          } ?> aria-label="Pagina Anterior" title="Pagina Anterior">
                  <svg class="" focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                    <path d="M15.41 16.09l-4.58-4.59 4.58-4.59L14 5.5l-6 6 6 6z"></path>
                  </svg>
                </button>
                <button class="" id="after" tabindex="0" type="button" <?php if (!empty($page) && $page == $pages) {
                                                                          echo 'disabled';
                                                                        } ?> aria-label="Siguiente Pagina" title="Siguiente Pagina">
                  <svg class="" focusable="false" aria-hidden="true" viewBox="0 0 24 24">
                    <path d="M8.59 16.34l4.58-4.59-4.58-4.59L10 5.75l6 6-6 6z"></path>
                  </svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <div id="RolModal" class="flex fixed h-screen w-screen bg-awd justify-center items-center z-999  l0 t0 hidden">
    <div class="modal-container dark:bg-slate-900">
      <div class="w-full max-w-sm bg-surface-light dark:bg-slate-900 rounded-2xl  overflow-hidden transform transition-all">
        <h3 class=" text-lg font-bold text-black dark:text-white">Editar Rol de Usuario</h3>
        <form id="formEditarRol">
          <div class="flex flex-col justify-between">
            <select class="w-full pl-10 pr-3 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" name="rol" id="selectRol" class="form-control">
            </select>
            <input class='hidden' type='number' id='idNumber'>
          </div>
          <div class="pt-4 bg-slate-50 dark:bg-slate-900/50 flex items-center justify-end gap-3 ">
            <button type="button" class="w-full sm:w-1/2 py-3 text-slate-500 dark:text-slate-400 font-medium hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all" id="cancelarRol">Cancelar</button>
            <button type="submit" class="w-full sm:w-1/2 bg-primary hover:bg-blue-600 active:scale-95 text-white font-semibold py-3 rounded-xl shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div id="formModal" class="flex fixed h-screen w-screen bg-awd justify-center items-center z-999  l0 t0 hidden">
    <div class="modal-container dark:bg-slate-900">
      <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-2" id="title">Registrar Usuario</h3>
      <form action="<?php echo PATH ?>register" method="post" autocomplete="off">
        <input type="hidden" name="id" id="id" value="">
        <div class="grid grid-cols-2 gap-4">
          <div class="space-y-1.5">
            <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="nombreModal">Nombre</label>
            <div class="relative">
              <input class="w-full pl-3 pr-3 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" id="nombreModal" name="nombre" placeholder="nombre" type="text" />
            </div>
          </div>
          <div class="space-y-1.5">
            <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="apellidoModal">Apellido</label>
            <input class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" id="apellidoModal" name="apellido" placeholder="apellido" type="text" />
          </div>
        </div>
        <div class="">
          <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="correoModal">Correo Electrónico</label>
          <div class="relative">
            <input class="w-full pl-10 pr-3 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" id="correoModal" name="correo" placeholder="ejemplo@correo.com" type="email" />
          </div>
        </div>
        <div class="space-y-1.5">
          <label class="text-sm font-medium text-slate-700 dark:text-slate-300" for="claveModal">Contraseña</label>
          <div class="relative">
            <input class="w-full pl-10 pr-3 py-2.5 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 rounded-lg text-slate-900 dark:text-white placeholder:text-slate-400 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none" id="claveModal" name="clave" placeholder="••••••••" type="password" />
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-4">
          <button class="w-full sm:w-1/2 py-3 text-slate-500 dark:text-slate-400 font-medium hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all" id="btnNuevo" type="button">
            Cancelar
          </button>
          <button class="w-full sm:w-1/2 bg-primary hover:bg-blue-600 active:scale-95 text-white font-semibold py-3 rounded-xl shadow-lg shadow-primary/25 transition-all flex items-center justify-center gap-2" type="submit">
            <span id="sendButton">Registrar</span>
          </button>
        </div>
      </form>
    </div>
  </div>
  <button data-toggle="back-to-top" class="fixed hidden h-10 w-10 items-center justify-center rounded-full z-10 bottom-20 end-14 p-2.5 bg-primary cursor-pointer shadow-lg text-white">
    <i class="mgc_arrow_up_line text-lg"></i>
  </button>
  <script>
    document.getElementById("btnNuevo").addEventListener("click", () => {
      document.getElementById("id").value = "";
      document.getElementById("nombreModal").value = "";
      document.getElementById("apellidoModal").value = "";
      document.getElementById("correoModal").value = "";
      document.getElementById("claveModal").value = "";
      cerrarModal();
    })
    
      document.getElementById('cancelarRol').addEventListener('click', () => {
              const rolModal = document.getElementById('RolModal');
        rolModal.classList.add('hidden')
      })
    async function editarRol(id) {
      const json = await fetch(`<?php echo CompleteURL ?>?id=${id}`)
      const datos = await json.json();
      const rolModal = document.getElementById('RolModal');
      const option = document.getElementById('selectRol');
      const form = document.getElementById("formEditarRol");
            const idContent = document.getElementById("idNumber");
      // Opciones de roles
      const roles = [{
          value: 3,
          label: 'usuario'
        },
        {
          value: 1,
          label: 'admin'
        }
      ];
      // Generar opciones del select
      let optionsHtml = '';
      roles.forEach(role => {
        optionsHtml += `<option value="${role.value}"  ${datos.rol == role.label ? 'selected' : ''} > ${role.label}</option>`;
      });
      option.innerHTML = optionsHtml;
      idContent.value = datos.id


      rolModal.classList.remove('hidden')
      // Manejar envío del formulario
      document.getElementById("formEditarRol").onsubmit = async function(e) {
        e.preventDefault();
        const nuevoRol = document.getElementById("selectRol").value;
        // Enviar cambio de rol por fetch/AJAX
        const resp = await fetch('<?php echo PATH ?>cambiarRolusuario', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id: document.getElementById("idNumber").value,
            rol: nuevoRol
          })
        });
        const datos = await resp.json();
        if (datos.hasOwnProperty("success")) {
          alert(datos.success);
          window.location.reload();
        } else if (datos.hasOwnProperty("error")) {
          alert(datos.error);
        }
        document.body.removeChild(modalBg);
      };
    }

    async function editarUsuario(id) {
      const json = await fetch(`<?php echo CompleteURL ?>?id=${id}`)
      const datos = await json.json();
      if (datos.error) {
        new notificationsMessage('error', datos.error);
        return
      }
      document.getElementById("title").innerText = "Actualizar Datos";
      document.getElementById("sendButton").innerText = "Actualizar";
      abrirModal()
      document.getElementById("id").value = datos.id;
      document.getElementById("nombreModal").value = datos.nombre;
      document.getElementById("apellidoModal").value = datos.apellido;
      document.getElementById("correoModal").value = datos.correo;
    }

    // Abrir modal para registrar usuario
    document.getElementById('openModal').addEventListener('click', abrirModal);

    function abrirModal() {
      document.getElementById('formModal').classList.remove('hidden');
    }

    function cerrarModal() {
      document.getElementById('formModal').classList.add('hidden');
    }
  </script>
</body>

</html>
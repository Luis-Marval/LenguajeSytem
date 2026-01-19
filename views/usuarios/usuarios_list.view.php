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
        <div class="min-h-min mb-4">
          <h1 class="text-4xl text-primary dark:text-primary"> Usuarios </h1>
        </div>
        <div class="alertContainer">
          <?php
          require_once "./views/templates/message/error.php";
          require_once "./views/templates/message/success.php";
          ?>
        </div>
        <div class="card">
          <div class="card-body">
            <form action="<?php echo PATH ?>register" method="post" autocomplete="off" class="form-user" id="formulario">
              <div class="rowUser mb-3">
                <div class="">
                  <div class="form-group">
                    <label for="nombre" class="lbl-nombre"><span class="text-nomb">Nombre</span></label>
                    <input type="text" class="form-control dark:bg-gray-700 dark:text-gray-200" placeholder="Ingrese Nombre" name="nombre" id="nombre">
                    <input type="hidden" id="id" name="id">
                  </div>

                </div>
                <div class="">
                  <div class="form-group">
                    <label for="apellido">Apellido</label>
                    <input type="text" class="form-control dark:bg-gray-700 dark:text-gray-200" placeholder="Ingrese Apellido" name="apellido" id="apellido">
                  </div>

                </div>
                <div class="">
                  <div class="form-group">
                    <label for="correo" class="lbl-nombre"><span class="text-nomb" style="white-space: nowrap;">Correo Electronico</span></label>
                    <input type="email" class="form-control dark:bg-gray-700 dark:text-gray-200" placeholder="Ingrese Correo Electrónico" name="correo" id="correo">
                  </div>
                </div>

                <div class="">
                  <div class="form-group">
                    <label for="clave">Contraseña</label>
                    <input type="password" class="form-control dark:bg-gray-700 dark:text-gray-200" placeholder="Ingrese Contraseña" name="clave" id="clave">
                  </div>
                </div>
              </div>
              <input type="submit" value="Registrar" class="btn bg-primary text-white" id="btnAccion">
              <input type="button" value="Limpiar" class="btn bg-success text-white" id="btnNuevo">
            </form>
          </div>
        </div>
        <br>
        <div class="card">
          <div>
            <div class="overflow-x-auto p-6">
              <table class="w-full text-sm text-gray-500 dark:text-gray-400 text-center">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 dark:bg-gray-700 dark:text-gray-200 out-b">
                  <tr>
                    <th scope="col" width="100" class="px-6 py-3">No</th>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Correo</th>
                    <th scope="col" class="px-6 py-3">Rol</th>
                    <th scope="col" class="px-6 py-3">Acciones</th>

                  </tr>
                </thead>
                <tbody class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-200">
                  <?php foreach ($usuarios as $usuario): ?>
                    <tr class="out-b text-center">
                      <td scope="col" width="100"><?php echo $usuario['id'] ?></td>
                      <td scope="col"><?php echo $usuario['nombre'] . " " . $usuario['apellido']; ?></td>
                      <td scope="col"><?php echo $usuario['correo'] ?></td>
                      <td scope="col"><?php echo $usuario['name'] ?></td>
                      <td scope="col" class="flex justify-center">
                        <a onclick="editarRol(<?php echo $usuario['id']; ?>)" class="btn "><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd" d="M22 8.293c0 3.476-2.83 6.294-6.32 6.294c-.636 0-2.086-.146-2.791-.732l-.882.878c-.519.517-.379.669-.148.919c.096.105.208.226.295.399c0 0 .735 1.024 0 2.049c-.441.585-1.676 1.404-3.086 0l-.294.292s.881 1.025.147 2.05c-.441.585-1.617 1.17-2.646.146l-1.028 1.024c-.706.703-1.568.293-1.91 0l-.883-.878c-.823-.82-.343-1.708 0-2.05l7.642-7.61s-.735-1.17-.735-2.78c0-3.476 2.83-6.294 6.32-6.294S22 4.818 22 8.293m-6.319 2.196a2.2 2.2 0 0 0 2.204-2.195a2.2 2.2 0 0 0-2.204-2.196a2.2 2.2 0 0 0-2.204 2.196a2.2 2.2 0 0 0 2.204 2.195" clip-rule="evenodd" />
                          </svg></i></a>
                        <a onclick="editarUsuario(<?php echo $usuario['id']; ?>)" class="btn"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M4 21q-.425 0-.712-.288T3 20v-2.425q0-.4.15-.763t.425-.637L16.2 3.575q.3-.275.663-.425t.762-.15t.775.15t.65.45L20.425 5q.3.275.437.65T21 6.4q0 .4-.138.763t-.437.662l-12.6 12.6q-.275.275-.638.425t-.762.15zM17.6 7.8L19 6.4L17.6 5l-1.4 1.4z" />
                          </svg></a>
                        <form action="<?php echo PATH ?>eliminarUsuario?id=<?php echo $usuario['id']; ?>" method="post" class="confirmar d-inline">
                          <button class="btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                              <path fill="currentColor" d="M7 21q-.825 0-1.412-.587T5 19V6H4V4h5V3h6v1h5v2h-1v13q0 .825-.587 1.413T17 21zm2-4h2V8H9zm4 0h2V8h-2z" />
                            </svg></button>
                        </form>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>
  <button data-toggle="back-to-top" class="fixed hidden h-10 w-10 items-center justify-center rounded-full z-10 bottom-20 end-14 p-2.5 bg-primary cursor-pointer shadow-lg text-white">
    <i class="mgc_arrow_up_line text-lg"></i>
  </button>
  <script>
    document.getElementById("btnNuevo").addEventListener("click", () => {
      document.getElementById("id").value = "";
      document.getElementById("nombre").value = "";
      document.getElementById("apellido").value = "";
      document.getElementById("correo").value = "";
      document.getElementById("clave").value = "";
    })
    async function editarRol(id) {
      const json = await fetch(`<?php echo CompleteURL ?>?id=${id}`)
      const datos = await json.json();
      const modalBg = document.createElement('div');
      modalBg.style.position = 'fixed';
      modalBg.style.top = 0;
      modalBg.style.left = 0;
      modalBg.style.width = '100vw';
      modalBg.style.height = '100vh';
      modalBg.style.background = 'rgba(0,0,0,0.5)';
      modalBg.style.display = 'flex';
      modalBg.style.alignItems = 'center';
      modalBg.style.justifyContent = 'center';
      modalBg.style.zIndex = 9999;

      // Crear modal
      const modal = document.createElement('div');
      modal.style.background = '#fff';
      modal.style.padding = '2em';
      modal.style.borderRadius = '8px';
      modal.style.boxShadow = '0 2px 8px rgba(0,0,0,0.2)';
      modal.style.minWidth = '300px';

      // Opciones de roles
      const roles = [{
          value: 2,
          label: 'analista'
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

      modal.innerHTML = `
    <h3>Editar Rol de Usuario</h3>
    <form id="formEditarRol">
      <div class="flex flex-row justify-between"> 
        <label>Rol</label>
        <select name="rol" id="selectRol" class="form-control">
          ${optionsHtml}
        </select>
        <input class="hidden" type="number" id="idNumber" value=${datos.id}>
      </div>
      <div style="margin-top:1em; text-align:right;">
        <button type="button" id="cancelEditRol" class="btn btn-secondary">Cancelar</button>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  `;
      modalBg.appendChild(modal);
      document.body.appendChild(modalBg);

      // Cerrar modal
      document.getElementById("cancelEditRol").onclick = () => {
        document.body.removeChild(modalBg);
      };

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
          document.body.removeChild(modalBg);
        } else if (datos.hasOwnProperty("error")) {
          alert(datos.error);
        }
        document.body.removeChild(modalBg);
      };
    }

    async function editarUsuario(id) {
      const json = await fetch(`<?php echo CompleteURL ?>?id=${id}`)
      const datos = await json.json();
      document.getElementById("id").value = datos.id;
      document.getElementById("nombre").value = datos.nombre;
      document.getElementById("apellido").value = datos.apellido;
      document.getElementById("correo").value = datos.correo;

    }
  </script>
</body>

</html>
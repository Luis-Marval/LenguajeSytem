document.addEventListener("DOMContentLoaded", function () {
  // Si NO estamos en la página de tratamiento_prolongado, borra productosPro
  if (!window.location.pathname.includes("/reporte/tratamiento_prolongado")) {
    localStorage.removeItem("productosPro");
  }
  if (!window.location.pathname.includes("/reporte/tratamiento_convencional")) {
    localStorage.removeItem("productosCon");
  }

  const userChangeBtn = document.getElementById("userChange");
  if (userChangeBtn) {
    userChangeBtn.addEventListener("click", function () {
      // Crear modal básico
      const modalBg = document.createElement("div");
      modalBg.style.position = "fixed";
      modalBg.style.top = 0;
      modalBg.style.left = 0;
      modalBg.style.width = "100vw";
      modalBg.style.height = "100vh";
      modalBg.style.background = "rgba(0,0,0,0.5)";
      modalBg.style.display = "flex";
      modalBg.style.alignItems = "center";
      modalBg.style.justifyContent = "center";
      modalBg.style.zIndex = 9999;

      const modal = document.createElement("div");
      modal.style.background = "#fff";
      modal.style.padding = "2em";
      modal.style.borderRadius = "8px";
      modal.style.boxShadow = "0 2px 8px rgba(0,0,0,0.2)";
      modal.innerHTML = `
          <h1>Cambiar contraseña</h1>
          <form id="changePassForm" class="flex flex-column aling-end">
            <div>
              <label>Clave actual</label>
              <input type="password" name="actual" required class="form-control" autofocus/>
            </div>
            <div>
              <label>Nueva clave</label>
              <input type="password" name="nueva" required class="form-control"/>
            </div>
            <div>
              <label>Repetir nueva clave</label>
              <input type="password" name="nueva2" required class="form-control"/>
            </div>
            <div style="margin-top:1em; text-align:right;">
              <button type="button" id="cancelChangePass" class="btn btn-secondary">Cancelar</button>
              <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
          </form>
        `;
      modalBg.appendChild(modal);
      document.body.appendChild(modalBg);

      // Cerrar modal
      document.getElementById("cancelChangePass").onclick = () => {
        document.body.removeChild(modalBg);
      };
      document.getElementById("changePassForm").onsubmit = async function (e) {
        e.preventDefault();
        const actual = this.actual.value;
        const nueva = this.nueva.value;
        const nueva2 = this.nueva2.value;
        if (nueva !== nueva2) {
          alert("Las nuevas contraseñas no coinciden.");
          return;
        }
        const post = JSON.stringify({ actual, nueva });
        const json = await fetch("/IPSFANB/cambiarContrasena", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: post,
        });
        const datos = await json.json();
        if (datos.hasOwnProperty("success")) {
          alert(datos.success);
          document.body.removeChild(modalBg);
        }else if(datos.hasOwnProperty("error")){
          alert(datos.error);
        }
      };
    });
  }
});

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

      const modal = `<div id="formModal" class="flex fixed h-screen w-screen bg-awd justify-center items-center z-999  l0 t0">
    <div class="modal-container dark:bg-slate-900">
          <h1 class="text-xl font-display font-bold text-slate-900 dark:text-white">Cambiar contraseña</h1>
          <form id="changePassForm" class="flex flex-column">
          <div class="mb-2">
<label class="block text-sm font-display font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-tight"  for="actual">Clave actual</label>
<input class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-blue-500 transition-all outline-none mono-text text-sm" placeholder="••••••••" type="password"  name="actual" id="actual"/>
</div>
<div class="mb-2">
<label class="block text-sm font-display font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-tight" for="nueva">Nueva clave</label>
<input class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-blue-500 transition-all outline-none mono-text text-sm" placeholder="••••••••" type="password" name="nueva" id="nieva"/>
</div>
<div class="mb-2">
<label class="block text-sm font-display font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-tight">Repetir nueva clave</label>
<div class="relative group" for="nueva2">
<input class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-blue-500 transition-all outline-none mono-text text-sm" placeholder="••••••••" type="password" name="nueva2" id="nueva2"/>
</div>
</div>
            <div style="margin-top:1em; text-align:right;">
              <button type="button" id="cancelChangePass" class="px-6 py-2.5 text-sm font-display font-semibold text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 transition-colors">Cancelar</button>
              <button type="submit" class="px-8 py-2.5 bg-primary hover:bg-accent text-white rounded-xl shadow-lg shadow-primary/20 transition-all transform hover:scale-[1.02] active:scale-[0.98] text-sm font-display font-bold tracking-wider" >Guardar</button>
            </div>
          </form>
                      </div>
          </div>
        `;

      // Insertar modal en el body
      const modalBg = document.createElement('div');
      modalBg.innerHTML = modal;
      document.body.appendChild(modalBg);

      // Cerrar modal con el botón Cancelar
      const cancelBtn = modalBg.querySelector('#cancelChangePass');
      if (cancelBtn) {
        cancelBtn.addEventListener('click', function () {
          if (document.body.contains(modalBg)) document.body.removeChild(modalBg);
        });
      }

      // Manejar envío del formulario dentro del modal
      const changePassForm = modalBg.querySelector('#changePassForm');
      if (changePassForm) {
        changePassForm.addEventListener('submit', async function (e) {
          e.preventDefault();
          const actual = this.actual.value;
          const nueva = this.nueva.value;
          const nueva2 = this.nueva2.value;
          if (nueva !== nueva2) {
            alert("Las nuevas contraseñas no coinciden.");
            return;
          }
          const post = JSON.stringify({ actual, nueva });
          const json = await fetch("/cambiarContrasena", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: post,
          });
          const datos = await json.json();
          if (datos.hasOwnProperty("success")) {
            alert(datos.success);
            if (document.body.contains(modalBg)) document.body.removeChild(modalBg);
          } else if (datos.hasOwnProperty("error")) {
            alert(datos.error);
          }
        });
      }
    });
  }
});

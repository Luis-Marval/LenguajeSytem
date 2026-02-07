  <div id="formModal" class="flex fixed h-screen w-screen bg-awd justify-center items-center z-999  l0 t0 hidden">
    <div class="modal-container dark:bg-slate-900"> <h1 class="text-xl font-display font-bold text-slate-900  dark:text-slate-100 uppercase tracking-wide">Cambiar contraseña</h1>
          <form id="changePassForm" class="flex flex-column aling-end">
          <div class="">
<label class="block text-sm font-display font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-tight"  for="actual">Clave actual</label>
<input class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-blue-500 transition-all outline-none mono-text text-sm" placeholder="••••••••" type="password"  name="actual" id="actual"/>
</div>
<div class="space-y-2">
<label class="block text-sm font-display font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-tight" for="nueva">Nueva clave</label>
<input class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-blue-500 transition-all outline-none mono-text text-sm" placeholder="••••••••" type="password" name="nueva" id="nieva"/>
</div>
<div class="space-y-2">
<label class="block text-sm font-display font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-tight">Repetir nueva clave</label>
<div class="relative group" for="nueva2">
<input class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary/20 focus:border-primary dark:focus:border-blue-500 transition-all outline-none mono-text text-sm" placeholder="••••••••" type="password" name="nueva2" id="nueva2"/>
</div>
</div>
            <div style="margin-top:1em; text-align:right;">
              <button type="button" id="cancelChangePass" class="px-6 py-2.5 text-sm font-display font-semibold text-slate-500 dark:text-slate-400 hover:text-primary dark:hover:text-blue-300 transition-colors">Cancelar</button>
              <button type="submit" class="px-8 py-2.5 bg-primary hover:bg-accent text-white rounded-xl shadow-lg shadow-primary/20 transition-all transform hover:scale-[1.02] active:scale-[0.98] text-sm font-display font-bold tracking-wider" >Guardar</button>
            </div>
          </form></div>
  </div>
<?php if (isset($_SESSION['success'])): ?>
  <div id="dismiss-alert" class="transition duration-300 bg-success/25 border border-teal-200 rounded-md p-4 mb-2" role="alert">
    <div class="flex items-center gap-3">
      <div class="flex-shrink-0">
        <i class="mgc_-badge-check text-xl"></i>
      </div>
      <div class="flex-grow">
        <div class="text-sm text-success font-medium">
          <span class="font-bold">Alerta:</span> <?php echo addslashes($_SESSION['success']); ?>
        </div>
      </div>
      <button data-fc-dismiss="dismiss-alert" type="button" id="dismiss-test" class="ms-auto h-8 w-8 rounded-full bg-green-400 flex justify-center items-center">
        <i class="mgc_close_line text-xl text-green-800"></i>
      </button>
    </div>
  </div>
<?php unset($_SESSION['success']);endif; ?>

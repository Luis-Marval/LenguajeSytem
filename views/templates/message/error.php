
<?php if (isset($_SESSION['error'])): ?>
  <div id="dismiss-alert" class="transition duration-300 bg-danger/25 border border-danger rounded-md p-2 m-1 col-span-3" role="alert">
    <div class="flex items-center gap-3">
      <div class="flex-shrink-0">
        <i class="mgc_-badge-check text-xl"></i>
      </div>
      <div class="flex-grow">
        <div class="text-sm text-danger font-medium">
          <span class="font-bold">Error: </span> <?php echo addslashes($_SESSION['error']); ?>
        </div>
      </div>
      <button data-fc-dismiss="dismiss-alert" type="button" id="dismiss-test" class="ms-auto h-8 w-8 rounded-full bg-red-400 flex justify-center items-center hover:bg-red-500">
        <i class="mgc_close_line text-xl text-red-800"></i>
      </button>
    </div>
  </div>
<?php unset($_SESSION['error']);endif; ?>

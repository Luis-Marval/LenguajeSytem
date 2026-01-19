<?php
ob_start();
?>
  <!DOCTYPE html>
  <html lang='es' class="">

  <head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='width=device-width, initial-scale=1.0'>
  <?php require_once './views/templates/scripts.php'; ?>
  <title><?php echo $title?></title>
  </head>

  <body>
  <div class='flex wrapper'>
    <?php require_once './views/templates/menu.php'; ?>
    <div class='page-content'>
      <?php require_once './views/templates/header.php'; ?>
<?php $parte1 = ob_get_clean();
ob_start();?>

  </div>
  </div>
  <button data-toggle='back-to-top' class='fixed hidden h-10 w-10 items-center justify-center rounded-full z-10 bottom-20 end-14 p-2.5 bg-primary cursor-pointer shadow-lg text-white'>
    <i class='mgc_arrow_up_line text-lg'></i>
  </button></body></html>


<?php $parte2 = ob_get_clean();?>
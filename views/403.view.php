<?php
$title = "Acceso Denegado";
require_once "./views/view.struct.php";
echo $parte1;
?>
<main class="flex-grow p-6">
  <div class="min-h-min mb-8  negate-access">
    <div>
      <h1 class="text-4xl text-primary i">Acceso Denegado</h1>
    </div>
    <div>
      <p>
        Lo sentimos, no tiene los permisos necesarios para utilizar este recurso
      </p>
    </div>
  </div>
</main>
<?php echo $parte2 ?>
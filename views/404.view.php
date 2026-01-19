<!DOCTYPE html>
<html lang="es" type='error'>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo PATH?>src/css/estilos.css">
  <title>Error 404 - Página no encontrada</title>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>Error 404</h1>
    </div>
    <img src="<?php echo PATH?>src/images/404.png" alt="Error 404" />
    <div class="footer">
        <p>
            Lo sentimos, la pagina que buscas no se ha encontrado
        </p>
        <a href="http://<?php echo $_SERVER['HTTP_HOST']?>/home" >Volver al inicio</a>
    </div>
</div>

</body>
</html>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo PATH ?>src/css/estilos.css">
  <link rel="stylesheet" href="<?php echo PATH ?>src/css/app.min.css">
  <?php require "./views/templates/scripts.php"; ?>
  <title>Iniciar Sesion</title>
</head>

<body class="font-poppins login">
  <main class="bg-fondo">
    <div class="h-screen w-screen flex justify-center items-center">
      <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2">
  <div class="AuthContainer">
          <img src="<?php echo PATH ?>src/images/logo.jpeg" >
      <h1 class="AuthTitle text-white">Iniciar Session</h1>
      <div class="AuthContainerForm">
          <form class="AuthForm"  action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
              <div>
                  <input type="email"  placeholder=""  name="email"  id="LoggingEmailAddress" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Ingresa un correo electrónico"   autocomplete="email" required autofocus>
                  <label for="LoggingEmailAddress" >Correo Electronico</label>
              </div>
              <div>
                  <input id="loggingPassword" title="Contraseña" required="" type="password" value="" name="contrasena" autocomplete="current-password">
                  <label for="loggingPassword">Contraseña</label>
              </div>
              <button>Iniciar Session</button>
              <a href="<?php echo PATH ?>recuperar" class="text-sm text-primary border-primary">¿Olvidaste tu Contraseña?</a>
          </form>
      </div>
     <!--- <div class="AuthQuestion">
          <div class="">
              <p class="text-white">¿No tienes una cuenta?</p>
              <a  class="text-sm text-primary border-primary" id="change">Registrarte</a>
          </div>
      </div>--->
      <div class="pt-3">
          <?php require_once "./views/templates/message/success.php" ?>
          <?php require_once "./views/templates/message/error.php" ?>
      </div>
  </div>
  </main>

</body>

</html>
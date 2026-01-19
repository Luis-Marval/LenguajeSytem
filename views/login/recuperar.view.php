<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php require_once './views/templates/scripts.php'; ?>
  <title>Recuperacion de Usuario</title>
</head>

<body class=" font-poppins">
  <div class=" bg-fondo">
    <div class="h-screen w-screen flex justify-center items-center">

      <div class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
        <div class="card overflow-hidden sm:rounded-md rounded-none">
          <form method="post" action="<?php echo PATH ?>recuperar" class="p-6">
            <div class="mb-4">
              <p class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
                Recuperar Usuario
              </p>

            </div>

            <div class="mb-4">
              <input id="LoggingEmailAddress" class="form-input" type="email" name="email" placeholder="Ingresa tu Correo..."  <?php if(isset($mail)){echo "value = '$mail' disabled";}?> >
            </div>
            
            <?php if(isset($token)):?>
              <div class="mb-4">
                <input id="LoggingEmailToken" class="form-input" type="text" name="token" placeholder="Ingresa el token" autocomplete="off">
              </div>
            <?php endif;?>

            <div class="flex justify-center mb-6">
              <button class="btn w-full text-white bg-primary hover:bg-gradient-to-r hover:from-indigo-600 hover:to-violet-600"> Ingresar </button>
            </div>
            <p class="text-gray-500 dark:text-gray-400 text-center">Volver a<a href="<?php echo PATH ?>login" class="text-primary ms-1"><b>Iniciar Sesion</b></a></p>
          </form>
        </div>
        <div class="alertContainer "> 
          <?php require_once "./views/templates/message/success.php" ?>
          <?php require_once "./views/templates/message/error.php" ?>
        </div>
      </div>
    </div>
  </div>

</body>

</html>
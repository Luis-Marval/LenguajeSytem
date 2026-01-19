<!DOCTYPE html>
<html lang="es" >
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
                    <form method="post" action="<?php echo PATH?>new_password" class="p-6">
                        <div class="mb-4">
                            <p class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
                                Ingrese su Nueva Clave
                            </p>
                        </div>
                        <input class="hidden" type="text" value="<?php echo $token?>" name="token">
                        <div class="mb-4">
                            <input id="LoggingEmailAddress" class="form-input" type="password" name="password" placeholder="Ingresa la nueva Contraseña" >
                        </div>
                        <div class="mb-4">
                            <input id="LoggingEmailAddress" class="form-input" type="password" name="confirm_password" placeholder="Confirma la nueva Contraseña" >
                        </div>
                        <div class="flex justify-center mb-6">
                            <button class="btn w-full text-white bg-primary hover:bg-gradient-to-r hover:from-indigo-600 hover:to-violet-600"> Cambiar Clave </button>
                        </div>
                    </form>
                  </div>
                  <div class="pt-3">
                      <?php require_once "./views/templates/message/success.php" ?>
                      <?php require_once "./views/templates/message/error.php" ?>
                  </div>
            </div>
        </div>
    </div>
</body>
</html>
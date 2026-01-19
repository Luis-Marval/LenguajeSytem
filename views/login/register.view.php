<!DOCTYPE html>
<html lang="es" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require "./views/templates/scripts.php";?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Registrate</title>
</head>
<body class="font-poppins">

<div class="bg-fondo">
    <div class="h-screen w-screen flex justify-center items-center">
        <main class="2xl:w-1/4 lg:w-1/3 md:w-1/2 w-full">
            <div class="card overflow-hidden sm:rounded-md rounded-none">
                <div class="p-6">
                    <h1 class="mb-4">
                        <p class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-">
                            Registrate
                        </p>
                    </h1>
                    <form id="registerForm" action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
                        <div class="mb-4">
                            <input id="LoggingEmailAddress" class="form-input" type="text" placeholder="Ingresa tu Nombre" name="nombre" pattern="[A-Za-z\sáéíóúÁÉÍÓÚñÑ]+" title="Solo se permiten letras y espacios." required >
                        </div>
                        <div class="mb-4">
                            <input id="LoggingEmailAddress" class="form-input" type="text" placeholder="Ingresa tu Apellido" name="apellido" pattern="[A-Za-z\sáéíóúÁÉÍÓÚñÑ]+" title="Solo se permiten letras y espacios." required >
                        </div>
                        <div class="mb-4">
                            <input id="LoggingEmailAddress" class="form-input" type="email" placeholder="Ingresa tu Correo" name="email" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" title="Ingresa un correo electrónico válido." required >
                        </div>
                        <div class="mb-4">
                            <input id="loggingPassword" class="form-input" type="password" placeholder="Ingresa tu Contrasena" name="contrasena" required>
                        </div>
                        <div class="mb-4">
                            <input id="loggingPassword" class="form-input" type="password" placeholder="Repite tu Contrasena" name="contrasena2" required>
                        </div>
                        <div class="flex justify-center mb-6">
                            <button type="submit" class="btn w-full text-white bg-primary bg-gradient-to-r from-violet-600 to-indigo-600 hover:bg-gradient-to-r hover:from-indigo-600 hover:to-violet-600">Registrate</button>
                        </div>
                    </form>
                    <p class="text-gray-500 dark:text-gray-400 text-center">Ya posees una Cuenta?<a href="<?php echo PATH ?>login" class="text-primary ms-1"><b>Inicia Sesion</b></a></p>
                <?php require_once "./views/templates/message/error.php";
                require_once "./views/templates/message/success.php";?>
                </div>
            </div>
        </main>
    </div>
</div>
</body>
</html>
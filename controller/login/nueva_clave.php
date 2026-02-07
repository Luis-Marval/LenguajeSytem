<?php

use model\Usuario;

if ($_SERVER['REQUEST_METHOD'] === "GET") {
  $email = $_SESSION['email'];
  $userToken = (new Usuario)->comprobar(['correo' => $email]);

  if (strtotime($userToken['reset_expires']) < time()) {
    $_SESSION['error'] =  "El enlace de recuperación no es válido o ha expirado";
    header("location: " . PATH . "recuperar");
    exit;
  }

  require_once "./views/login/nueva_clave.view.php";
}

if ($_SERVER['REQUEST_METHOD'] === "POST") {
  $token =  $_SESSION['email'];
  $userToken = (new Usuario)->comprobar(['correo' => $token]);
  // Validar token y expiración nuevamente
  if (
    !isset($userToken['reset_token']) ||
    strtotime($userToken['reset_expires']) < time()
  ) {
    $_SESSION['error'] = "El codigo de validacion ha expirado";
    header("location: " . PATH . "recuperar");
    exit;
  }
  $usuario = new Usuario;

  $clave = $_POST['password'];
  $clave2 = $_POST['confirm_password'];
  try {
    if (empty($clave) || empty($clave2)) {
      throw new Exception("Todo los campos son obligatorios");
    }
    if ($clave !== $clave2) {
      throw new Exception("Las contraseñas no coinciden. Vuelve a intentarlo.");
    }
    $usuario->newPAssword($clave,['correo' => $userToken['correo']]);
    $_SESSION['success'] = "contraseña cambiada con Exito";

    header('location:' . PATH . "login");
    exit();
  } catch (\Exception $e) {
    $_SESSION['error'] = $e->getMessage();
  }
}

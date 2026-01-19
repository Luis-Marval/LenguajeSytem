<?php

use model\Usuario;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
  if (isset($_POST['token'])) {
    $email = $_SESSION['email'];
    $token = $_POST['token'];

    $userToken = (new Usuario)->comprobar(['reset_token' => $token, 'correo' => $email]);

    if ($token !== $userToken['reset_token'] || strtotime($userToken['reset_expires']) < time()) {
      $_SESSION['error'] =  "El enlace de recuperación no es válido o ha expirado";
      header("location: " . PATH . "recuperar");
      unset($_SESSION['email']);
      exit;
    }
    header("location:" . PATH . "new_password");
  }
  $usuario  = new Usuario;
  try {
    $email = $_POST['email'];
    $user = $usuario->comprobar(['correo' => $email]);
    if ($user) {
      $token = bin2hex(random_bytes(4));
      $expires = date("Y-m-d H:i:s", strtotime('+1 hour'));
      (new Usuario)->setRecoverData($user['id'], $token, $expires);

      $usuario->EnviarCorreoRecuperacion($email, $token);
      if ($usuario === false) {
        throw new Exception('Error al enviar el mensaje');
      }
      $_SESSION['email'] = $email;
      $mail = $email;
      $token = true;
      $_SESSION['success'] = "Revice su correo Electronico e ingrese el codigo en el campo correspondiente";
    } else {
      throw new Exception("No se encontró una cuenta con ese correo electrónico.");
    }
  } catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
  }
}

require 'views/login/recuperar.view.php';

<?php

use model\Usuario;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    $email = $_POST['email'];
    $contrasena = $_POST['contrasena'];
    if (empty($email) || empty($contrasena)) {
      throw new Exception('Todos los campos son obligatorios');
    }

    $conexion = (new Usuario)->login(['correo' => $email, 'clave' => $contrasena]);
    if ($conexion !== false) {
      header('Location: home');
      exit;
    } else {
      throw new Exception('Clave o Correo Invalido');
    }
  } catch (\Exception $e) {
    $_SESSION['error'] = $e->getMessage();
  }
}

require 'views/login/login.view.php';

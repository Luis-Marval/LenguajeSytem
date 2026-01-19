<?php

use model\utils;
use model\Usuario;

if($_SESSION["rol"] != "admin"){
  $_SESSION["error"] = "No tiene los permisos para rezlizar esta accion";
  header("location: " . PATH . "users");
  die();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  if (!isset($_POST['id']) || !empty($_POST['id'])) {
    try {
      $usuario = new Usuario();
      $id = $_POST['id'];
      // Obtener datos actuales del usuario
      $usuarioActual = $usuario->getTotal($id)[0]; // Debes tener este método implementado

      // Preparar array con los datos modificados
      $datosActualizados = ['id' => $id];
      if (isset($_POST['nombre']) && $_POST['nombre'] !== $usuarioActual['nombre']) {
        $datosActualizados['nombre'] = $_POST['nombre'];
      }
      if (isset($_POST['apellido']) && $_POST['apellido'] !== $usuarioActual['apellido']) {
        $datosActualizados['apellido'] = $_POST['apellido'];
      }
      if (isset($_POST['correo']) && $_POST['correo'] !== $usuarioActual['correo']) {
        $datosActualizados['correo'] = $_POST['correo'];
      }
      if (isset($_POST['clave']) && !empty($_POST['clave'])) {
        $datosActualizados['clave'] = $_POST['clave'];
      }

      // Si solo hay 'id', no hay cambios
      if (count($datosActualizados) === 1) {
        $_SESSION["error"] = "No hay cambios para actualizar";
        die();
      }
      $usuario->actualizarUsuario($datosActualizados);
      $_SESSION["success"] = "Usuario Modificado Correctamente";
    } catch (\Exception $e) {
      $_SESSION["error"] = $e->getMessage();
    }
    
  } else {
    try {
      $datos = [
        'nombre' => empty($_POST['nombre']) ? false : $_POST['nombre'],
        'apellido' => empty($_POST['apellido']) ? false : $_POST['apellido'],
        'correo' => empty($_POST['correo']) ? false : $_POST['correo'],
        'clave' => empty($_POST['clave']) ? false : $_POST['clave'],
      ];

      if (!$datos['nombre'] || !$datos['apellido'] || !$datos['correo'] || !$datos['clave']) {
        throw new Exception('Todos los campos son obligatorios');
      }
      $conexion = (new Usuario)->registro($datos);
      $_SESSION['success'] = "Registrado Correctemente";
    } catch (Exception $e) {
      $_SESSION['error'] = $e->getMessage();
    }
  }
  header("location: " . PATH . "users");
  die();
}


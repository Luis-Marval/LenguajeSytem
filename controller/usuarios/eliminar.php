<?php

use model\Usuario;

try {
  if (isset($_GET["id"])) {
    $id = intval($_GET["id"]);
    $usuario = new Usuario();

    // Obtener datos del usuario
    $usuarioData = $usuario->getTotal($id)[0]; // Debes tener este método implementado

    if (empty($usuarioData)) {
      throw new Exception("El usuario no existe");
    }

    // Comprobar que el rol no sea admin (asumiendo que el rol admin es 1)

    if (isset($usuarioData['rol']) && $usuarioData['rol'] == 1) {
      throw new Exception("No se puede eliminar un usuario administrador");
    }

    // Eliminar usuario (marcar como inactivo)
    $usuario->usersDelete($id); 
    $_SESSION["success"] = "usuario eliminado correctamente";
  }
} catch (\Exception $e) {
  $_SESSION["error"] = $e->getMessage();
}
header("location:" . PATH . "users");

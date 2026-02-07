<?php

use model\Usuario;

if (isset($_GET["id"])) {
  try {
    $usuario = (new Usuario)->comprobar(['id' => $_GET["id"]]);
    $datos = [
      'id' => $usuario['id'],
      'nombre' => $usuario['nombre'],
      'apellido' => $usuario['apellido'],
      'correo' => $usuario['correo']
    ];
    header("Content-Type:application/json");
    echo json_encode($datos);
    die();
  } catch (\Exception $e) {
    header("Content-Type:application/json");
    http_response_code(500);
    echo json_encode(['error' => 'fallo al buscar la inforamcion del usuario']);
    die();
  }
}

try {
  $usuarios = (new Usuario)->getTotal();
} catch (\Exception $e) {
  $_SESSION["error"] = $e;
}
require_once "./views/usuarios/usuarios_list.view.php";

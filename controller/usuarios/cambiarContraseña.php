<?php

use model\Usuario;

if ($_SERVER['REQUEST_METHOD'] == "POST") {
try{
  $usuario = new Usuario;
  $datos = json_decode(file_get_contents("php://input"), true);
  
  if (!$usuario->verifyPassword($datos['actual'],$_SESSION['id'])) {
    throw new Exception("la clave ingresada es incorrecta");
  }
  $res = $usuario->newPAssword($datos["nueva"],['correo' => $_SESSION['email']]);
  header('Content-Type: application/json');
  echo json_encode(["success" => "Cambio de Contraseña realizado correctamente"]);
  die();
}catch(Exception $e){
  header('Content-Type: application/json');
  echo json_encode(["error" => $e->getMessage()]);
  die();
}
}

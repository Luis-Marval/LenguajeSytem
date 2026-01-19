<?php

use model\Profesores;
use model\utils;

try {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Obtener los datos del FORM
    $datos = [
      'cedula' => utils::sanear($_POST['cedula']),
      'nombre' => utils::sanear($_POST['nombre']),
      'apellido' => utils::sanear($_POST['apellido']),
      'telefono' => utils::sanear($_POST['telefono']),
      'email' => utils::sanear($_POST['correo']),
      'nacionalidad' => utils::sanear($_POST['nacionalidad']),
    ];
    $res = (new Profesores())->getProfesor(['cedula' => $datos["cedula"]]);
    if (empty($res) && $res['status'] == 1) {
      throw new Exception("Profesor ya registrado");
    }
/*     if($res['status'] == 0){
      $_SESSION["success"] = "Profesor registrado correctamente";
      header("Location: " . PATH . "profesor/listado");
      exit();
    } */
    utils::vacia($datos);
    //registrar Profesor
    $pacientes = (new Profesores())->setProfesor($datos);
    // redirigir al listado de estudiantes con un mensaje de exito
    if ($pacientes) {
      $_SESSION["success"] = "Profesor registrado correctamente";
      header("Location: " . PATH . "profesor/listado");
      exit();
    }
  }
} catch (\Exception $err) {
  $_SESSION['error'] = $err->getMessage();
}
require_once './views/profesores/registrar_profesores.view.php';

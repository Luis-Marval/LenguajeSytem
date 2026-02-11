<?php

use model\Profesores;
use model\utils;

try {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Obtener los datos del FORM
    $datos = [
      'nombre' => utils::sanear($_POST['nombre']),
      'apellido' => utils::sanear($_POST['apellido']),
      'telefono' => utils::sanear($_POST['telefono']),
      'email' => utils::sanear($_POST['correo']),
      'nacionalidad' => utils::sanear($_POST['nacionalidad']),
      'tipoDocumento' => utils::sanear($_POST['tipoDocumento']),
    ];
    utils::vacia($datos);
    //registrar Profesor
    $cedula = $_POST['cedula'];
    $res = (new Profesores())->updateProfesor($cedula,$datos);
    // redirigir al listado de estudiantes con un mensaje de exito

    $_SESSION["success"] = "Datos actualizados correctamente";
    header("Location: " . PATH . "profesor/listado");
    exit();
  }
  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $cedula = $_GET["cedula"];
  
    $res = (new Profesores())->getProfesor(['cedula' => $cedula]);
    if (empty($res)) {
      throw new Exception("Profesor no encontrado");
    }
    $res = $res[0];
  }
} catch (\Exception $err) {
  $_SESSION['error'] = $err->getMessage();
  header("Location: " . PATH . "profesor/listado");
  exit();
}
require_once './views/profesores/actualizar_profesor.view.php';

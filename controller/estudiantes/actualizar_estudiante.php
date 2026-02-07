<?php

use model\Estudiante;
use model\utils;

try {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Obtener los datos del FORM
    $datos = [
      'nombre' => utils::sanear($_POST['nombre']),
      'apellido' => utils::sanear($_POST['apellido']),
      'fecha_nacimiento' => $_POST['fecha_nacimiento'],
      'telefono' => utils::sanear($_POST['telefono']),
      'email' => utils::sanear($_POST['correo']),
      'residencia' => utils::sanear($_POST['Residencia']),
      'nacionalidad' => utils::sanear($_POST['nacionalidad']),
    ];
    utils::vacia($datos);
    //registrar Profesor
    $cedula = $_POST['cedula'];
/*     if ($_FILES['file']['name'] != '') {
      $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
      $imgName = preg_replace('/[^A-Za-z0-9_-]/', '', $_POST['cedula'] . $datos['nombre'] . $datos['apellido']);
      $imgName = $imgName . ($ext ? '.' . $ext : '.jpg');

      $targetPath = targetSubmit . DIRECTORY_SEPARATOR . $imgName;
      $datos['imgadress'] = $targetPath;
      //registrar estudiante
      if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
        throw new Exception("No se pudo mover el archivo a: $targetPath");
      }
    }*/

    $res = (new Estudiante())->updateEstudante($cedula, $datos); 
    // redirigir al listado de estudiantes con un mensaje de exito

    $_SESSION["success"] = "Datos actualizados correctamente";
    header("Location: " . PATH . "estudiantes/listado");
    exit();
  }
  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $cedula = $_GET["cedula"];

    $res = (new Estudiante())->getEstudiante(['cedula' => $cedula]);
    if (empty($res)) {
      throw new Exception("Estudiante no encontrado");
    }
    $res = $res[0];
  }
} catch (\Exception $err) {
  $_SESSION['error'] = $err->getMessage();
  header("Location: " . PATH . "estudiantes/listado");
  exit();
}
require_once './views/estudiantes/actualizar_estudiante.view.php';

<?php

use model\Estudiante;
use model\utils;

try {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Obtener los datos del FORM
    $datos = [
      'cedula' => utils::sanear($_POST['cedula']),
      'nombre' => utils::sanear($_POST['nombre']),
      'apellido' => utils::sanear($_POST['apellido']),
      'fecha_nacimiento' => $_POST['fecha_nacimiento'],
      'telefono' => utils::sanear($_POST['telefono']),
      'email' => utils::sanear($_POST['correo']),
      'residencia' => utils::sanear($_POST['Residencia']),
      'nacionalidad' => utils::sanear($_POST['nacionalidad']),
      'tipoDocumento' => utils::sanear($_POST['tipoDocumento'])
    ];
    $res = (new Estudiante())->getEstudiante(['dato' => $datos["cedula"]]);
/*     if ($res === true) {
      throw new Exception("Estudiante ya registrado");
    }
    // varificar que es una imagen
    if (stripos($_FILES['file']['type'], 'image/') !== 0) {
      throw new Exception("El archivo debe ser una imagen.");
    }

    //nombre y extension de la imagen
    $ext = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));
    $imgName = preg_replace('/[^A-Za-z0-9_-]/', '', $datos['cedula'] . $datos['nombre'] . $datos['apellido']);
    $imgName = $imgName . ($ext ? '.' . $ext : '.jpg');

    $targetPath = targetSubmit . DIRECTORY_SEPARATOR . $imgName;
    $datos['imgadress'] = $targetPath ; */
    //verificar que no este vacio
    utils::vacia($datos);
    
    //registrar estudiante
    $pacientes = (new Estudiante())->setEstudiante($datos);
/*     if (!move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
      throw new Exception("No se pudo mover el archivo a: $targetPath");
    } */
    // redirigir al listado de estudiantes con un mensaje de exito
    if ($pacientes) {
      $_SESSION["success"] = "Estudiante registrado correctamente";
      header("Location: " . PATH . "estudiantes/listado");
      exit();
    }
  }
} catch (\Exception $err) {
  $_SESSION['error'] = $err->getMessage();
}
require_once './views/estudiantes/registrar_estudiante.view.php';

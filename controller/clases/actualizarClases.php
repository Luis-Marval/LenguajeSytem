<?php

use model\Clases;
use model\utils;

try {
  if ($_SERVER['REQUEST_METHOD'] == "POST") {
    //Obtener los datos del FORM
    $datos = [
      'idioma' => utils::sanear($_POST['idioma']),
      'nivel' => utils::sanear($_POST['nivel']),
      'horario' => utils::sanear($_POST['horario']),
      'tipo' => utils::sanear($_POST['tipo']),
      'horaInicio' => utils::sanear($_POST['horaInicio']),
      'horaFin' => utils::sanear($_POST['horaFin']),
      'monto' => utils::sanear($_POST['costo']),
      'modalidad' => utils::sanear($_POST['modalidad']),
    ];
    utils::vacia($datos);
    //registrar Profesor
    $id = $_POST['id'];
    $res = (new Clases())->updateClase($id, $datos); 
    // redirigir al listado de estudiantes con un mensaje de exito

    $_SESSION["success"] = "Datos actualizados correctamente";
    header("Location: " . PATH . "clases/listado");
    exit();
  }
  if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $idClase = $_GET["id"];

    $res = (new Clases())->getClase($idClase);
    if (empty($res)) {
      throw new Exception("Clase no encontrada");
    }
    $res = $res[0];

  $idiomas = (new Clases)->getIdiomas();
  }
} catch (\Exception $err) {
  $_SESSION['error'] = $err->getMessage();
  header("Location: " . PATH . "estudiantes/listado");
  exit();
}
require_once './views/clases/actualizarClases.view.php';

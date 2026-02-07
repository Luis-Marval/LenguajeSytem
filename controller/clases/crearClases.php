<?php

use model\Clases;
use model\utils;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
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
    (new Clases)->createClase($datos);
    unset($datos);
    $_SESSION['success'] = "Clase creada correctamente";
    header("location:" . PATH . "clases/inscripciones");
  } catch (\Exception $err) {
    $_SESSION['error'] = $err->getMessage();
    header("location:" . PATH . "clases/listado");
  }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $idiomas = (new Clases)->getIdiomas();
}


require_once("./views/clases/crearClases.view.php");

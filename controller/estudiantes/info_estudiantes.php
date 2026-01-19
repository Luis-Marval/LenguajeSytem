<?php

use model\Estudiante;
use model\Productos;

/*if ($_SERVER['REQUEST_METHOD'] == "POST") {
  try {
    $datos = json_decode(file_get_contents('php://input'), true);
    $result = (new Pacientes)->setCedula($datos['cedulaAntigua'], $datos['cedulaNueva']);
    header('Content-Type:application/json');
    echo json_encode(["success" => $result]);
    die();
  } catch (Exception $e) {
    header('Content-Type:application/json');
    echo json_encode(["error" => $e->getMessage()]);
    die();
  }
}*/

if ($_SERVER['REQUEST_METHOD'] == "GET") {
  try {
    if (!empty(isset($_GET["cedula"]))) {
      $cedula = $_GET["cedula"];
    } else {
      $cedula = false;
    }
    if ($cedula === null || $cedula === "") {
      throw new Exception("Cedula no valida");
    }
    $estudiante = (new Estudiante)->getEstudiante(['Cedula' => $cedula]);
    
    if ($estudiante === false || empty($estudiante)) {
      throw new Exception("Estudiante no registrado en el sistema");
    }
    $estudiante = $estudiante[0];
  } catch (\Exception $err) {
    $_SESSION['error'] = $err->getMessage();
    header("location:" . PATH . "estudiantes/listado");
    die();
  }
}
require_once "./views/estudiantes/info_estudiantes.view.php";

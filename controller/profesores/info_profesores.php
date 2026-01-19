<?php

use model\Profesores;
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
    $profesor = (new Profesores)->getProfesor(['Cedula' => $cedula]);
    if ($profesor === false || empty($profesor)) {
      throw new Exception("Profesor no registrado en el sistema");
    }
    $profesor = $profesor[0];
  } catch (\Exception $err) {
    $_SESSION['error'] = $err->getMessage();
    header("location:" . PATH . "profesor/listado");
    die();
  }
}
require_once "./views/profesores/info_profesores.view.php";

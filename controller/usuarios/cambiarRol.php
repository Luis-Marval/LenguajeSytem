<?php

use model\Usuario;

header("Content-Type:application/json");
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['error' => 'Método no permitido']);
  exit;
}

// Obtener datos enviados por JSON
$input = json_decode(file_get_contents('php://input'), true);
$id = isset($input['id']) ? intval($input['id']) : 0;
$rol = isset($input['rol']) ? intval($input['rol']) : null;

if (!$id || is_null($rol)) {
  http_response_code(400);
  echo json_encode(['error' => 'Datos incompletos']);
  exit;
}

$usuario = new Usuario();

try {
  if ($rol == 1) {
    $usuario->setAllAnalistasExcept($id);
    echo json_encode(['success' => "cambio exitoso"]);
    exit;
  }

  if (count($usuario->getTotalAdmins()) <= 1) {
    echo json_encode(['error' => "El sistema necesita un administrador"]);
    exit;
  }
} catch (Exception $e) {
  echo json_encode(['error' => $e->getMessage()]);
  die();
}

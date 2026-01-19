<?php

use model\Profesores;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Asume datos JSON en el body
  try {
    $data = json_decode(file_get_contents('php://input'), true);
    (new Profesores)->eliminarProfesor($data['cedula']);
    header('Content-Type:application/json');
    echo json_encode(['success' => true]);
    die();
  } catch (Exception $err) {
    header('Content-Type:application/json');
    echo json_encode(['success' => false]);
    die();
  }
}

<?php


use model\Clases;
use model\utils;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  try {
    utils::vacia($_POST['fechaInicio']);
    utils::vacia($_POST['fechaFin']);

    $datos = [
      'fechaInicio' => $_POST['fechaInicio'],
      'fechaFin' => $_POST['fechaFin'],
    ];
    $result = (new Clases)->setPeriodoDate($datos);
    $_SESSION['success'] = 'periodo registrado correctamente';
  } catch (Exception $err) {
    $_SESSION['error'] = 'Error al registrar el periodo';
    $_SESSION['error'] = $err->getMessage();
  }
  header('Location:' . PATH . 'clases/inscripciones');
}

$periodo = (new Clases)->getPeriodoDate();
$status = empty($periodo[0]['status']) ? false : $periodo[0]['status'];
if ($status || !empty($status)) {
  $PorPagina = $_GET['PorPagina'] ?? 10;
  $page = (int)($_GET['pagina'] ?? 1);
  $offset = ($page - 1) * $PorPagina;
  $search = $_GET['search'] ?? null;
  $total = ((new Clases())->countClasesPeriodos())[0][0];
  $periodo = $periodo[0];
  $lista = (new Clases)->getClasesPeriodos(0,['min' => $offset, 'max' => $PorPagina]);
  $cantidad = (sizeof($lista));
  // Número inicial mostrado en la página (si no hay elementos será 0)
  $cantidadActual = $cantidad > 0 ? ($offset + 1) : 0;
  // Número final mostrado en la página (si no hay elementos será 0)
  $cantidadFinal = $cantidad > 0 ? $offset + $cantidad : 0;
  $pages = (int)ceil($total / $PorPagina);
  if ($pages < 1) {
    $pages = 1;
  }
  // Si la página actual excede el número de páginas disponibles, redirigir a la página 1
  if ($page > $pages) {
    $redirectUrl = PATH . 'clases/inscripciones?pagina=1&PorPagina=' . $PorPagina;
    if (!empty($search)) {
      $redirectUrl .= '&search=' . urlencode($search);
    }
    header('Location: ' . $redirectUrl);
    exit;
  }
  $clases = new Clases;
  $estudiate = new model\Estudiante;
}

require_once("./views/clases/inscripciones.view.php");

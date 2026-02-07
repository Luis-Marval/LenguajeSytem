<?php

use model\Clases;

if (empty($_GET['idClase'])) {
  $PorPagina = $_GET['PorPagina'] ?? 10;
  $page = (int)($_GET['pagina'] ?? 1);
  $offset = ($page - 1) * $PorPagina;
  $search = $_GET['search'] ?? null;
  $total = ((new Clases())->countClases());
  if ($search == null) {
    $lista = (new Clases)->getListadoClases(['min' => $offset, 'max' => $PorPagina]);
  } else {
    $lista = (new Clases)->getListadoClases(['min' => $offset, 'max' => $PorPagina], $search);
  }
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
    $redirectUrl = PATH . 'clases/listado?pagina=1&PorPagina=' . $PorPagina;
    if (!empty($search)) {
      $redirectUrl .= '&search=' . urlencode($search);
    }
    header('Location: ' . $redirectUrl);
    exit;
  }
  $clases = new Clases;
  $estudiate = new model\Estudiante;
  require_once("./views/clases/listadoClases.view.php");
} else {
  try {
    $datos = (new Clases)->getClase($_GET['idClase']);
    if (empty($datos)) {
      throw new Exception('Clase no existente');
    }
    $datos = $datos[0];
    require_once("./views/clases/infoClases.view.php");
  } catch (\Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('location:' . PATH . 'clases/listado');
  }
}

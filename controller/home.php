<?php

use model\Clases;

$periodoDate =  (new Clases)->getPeriodoDate();
  $listas = [];
$status = 0;
if (!empty($periodoDate) && $periodoDate[0]['status'] == 1) {
  $listas = (new Clases)->getAlumnosPorInscribir();
  $status = 1;
}


/* $cantidad = (sizeof($lista));
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
} */
require_once 'views/home.view.php';

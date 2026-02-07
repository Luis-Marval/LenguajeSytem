<?php

use model\Estudiante;
use model\utils;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $PorPagina = $_GET['PorPagina'] ?? 10;
  $page = max(1, (int)($_GET['pagina'] ?? 1));
  $offset = ($page - 1) * $PorPagina;
  $search = $_GET['search'] ?? null;
  $total = ((new Estudiante())->countEstudiantes());
  if($search != null){
    $lista = (new Estudiante)->getEstudiante(['dato' => $search],['min'=>$offset,'max'=>$PorPagina]);
  }else{
    $lista = (new Estudiante)->getEstudiante([],['min'=>$offset,'max'=>$PorPagina]);
  }
  $cantidad = sizeof($lista);
    // Número inicial mostrado en la página (si no hay elementos será 0)
  $cantidadActual = $cantidad > 0 ? ($offset + 1) : 0;
  // Número final mostrado en la página (si no hay elementos será 0)
  $cantidadFinal = $cantidad > 0 ? $offset + $cantidad : 0;
  $pages = ceil($total / $PorPagina);

  require_once "./views/estudiantes/list_estudiantes.view.php";
}


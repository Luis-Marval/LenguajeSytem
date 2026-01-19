<?php

use model\Profesores;
use model\utils;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
  $PorPagina = $_GET['porPaginas'] ?? 10;
  $page = max(1, (int)($_GET['pagina'] ?? 1));
  $offset = ($page - 1) * $PorPagina;
  $search = $_GET['search'] ?? null;
  $total = ((new Profesores())->countProfesores())[0][0];
  if($search != null){
    $lista = (new Profesores)->getProfesor(['dato' => $search],['min'=>$offset,'max'=>10]);
  }else{
    $lista = (new Profesores)->getProfesor([],['min'=>$offset,'max'=>10]);
  }
  $cantidad = sizeof($lista);
  $pages = ceil($total / $PorPagina);

  require_once "./views/profesores/list_profesores.view.php";
}


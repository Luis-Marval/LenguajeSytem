<?php

use model\Pagos;

$pagosModel = new Pagos();

// Paginación básica similar a lista de estudiantes
$porPagina = isset($_GET['PorPagina']) ? (int)$_GET['PorPagina'] : 10;
if ($porPagina <= 0) { $porPagina = 10; }
$page = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($page < 1) { $page = 1; }
$offset = ($page - 1) * $porPagina;

$total = $pagosModel->countPagos();
$pagos = $pagosModel->getTodosLosPagos($porPagina, $offset);
$pendientes = $pagosModel->getPendientesGlobal();

$cantidad = count($pagos);
$cantidadActual = $cantidad > 0 ? ($offset + 1) : 0;
$cantidadFinal = $cantidad > 0 ? $offset + $cantidad : 0;
$pages = $porPagina > 0 ? (int)ceil($total / $porPagina) : 1;

// Para la plantilla de paginación
$pagina = $page;
$numeroPaginas = $pages;
$anterior = max(1, $pagina - 1);
$siguiente = min($numeroPaginas, $pagina + 1);
$nums = range(max(1, $pagina - 2), min($numeroPaginas, $pagina + 2));
$reference = PATH . 'pagos/listado?pagina=';

require_once "./views/pagos/listado.view.php";
